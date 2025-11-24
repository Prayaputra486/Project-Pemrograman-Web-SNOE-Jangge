<?php
session_start();
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); echo 'Method not allowed'; exit;
}
$tanggal = $_POST['tanggal_reservasi'] ?? '';
$waktu = $_POST['waktu_reservasi'] ?? '';
$jumlah = intval($_POST['jumlah_orang'] ?? 0);
if (!$tanggal || !$waktu || $jumlah < 1) {
    echo '<div class="col-12 text-danger">Parameter tidak valid.</div>'; exit;
}
try {
    $reservedStmt = $pdo->prepare("SELECT id_meja FROM reservasi WHERE tanggal_reservasi = :tgl AND waktu_reservasi = :wkt AND status NOT IN ('batal','cancel')");
    $reservedStmt->execute([':tgl'=>$tanggal, ':wkt'=>$waktu]);
    $reserved = $reservedStmt->fetchAll(PDO::FETCH_COLUMN);
    if (count($reserved) > 0) {
        $placeholders = implode(',', array_fill(0, count($reserved), '?'));
        $sql = "SELECT id_meja, nama_meja, kapasitas, lokasi, catatan FROM meja WHERE id_meja NOT IN ($placeholders) AND kapasitas >= ? ORDER BY kapasitas ASC";
        $params = $reserved;
        $params[] = $jumlah;
    } else {
        $sql = "SELECT id_meja, nama_meja, kapasitas, lokasi, catatan FROM meja WHERE kapasitas >= ? ORDER BY kapasitas ASC";
        $params = [$jumlah];
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $mejas = $stmt->fetchAll();
    if (!$mejas) {
        echo '<div class="col-12">Maaf, tidak ada meja yang tersedia untuk pilihan Anda. Coba ubah tanggal/waktu/jumlah orang.</div>';
        exit;
    }
    foreach ($mejas as $m) {
        $id = htmlspecialchars($m['id_meja']);
        $nama = htmlspecialchars($m['nama_meja']);
        $kap = (int)$m['kapasitas'];
        $lok = htmlspecialchars($m['lokasi']);
        $note = htmlspecialchars($m['catatan']);
        echo <<<HTML
<div class="col-md-4">
  <div class="card table-card p-3" data-id="$id" data-nama="$nama" title="Click to select">
    <div class="d-flex justify-content-between align-items-start">
      <div>
        <h6 class="mb-1">$nama</h6>
        <div class="small-muted">Capacity: $kap Person • Location: $lok</div>
      </div>
      <div class="text-end"><small class="small-muted">ID: $id</small></div>
    </div>
    <div class="mt-2"><small>$note</small></div>
  </div>
</div>
HTML;
    }

} catch (Exception $e) {
    echo '<div class="col-12 text-danger">An error occurred while retrieving the table.</div>';
}