<?php
session_start();
include 'db.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    exit('Access denied');
}
if (isset($_GET['id'])) {
    $id_reservasi = $_GET['id'];   
    try {
        $query = "SELECT r.*, u.nama, u.email, u.no_telp, m.nama_meja, m.kapasitas, m.lokasi
                  FROM reservasi r
                  JOIN users u ON r.id_user = u.id_user
                  JOIN meja m ON r.id_meja = m.id_meja
                  WHERE r.id_reservasi = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id_reservasi]);
        $reservation = $stmt->fetch();
        if ($reservation) {
            $menu_query = "SELECT rm.id_menu, rm.jumlah, rm.catatan, mn.nama_menu 
                           FROM reservasi_menu rm 
                           JOIN menu mn ON rm.id_menu = mn.id_menu 
                           WHERE rm.id_reservasi = ?";
            $menu_stmt = $pdo->prepare($menu_query);
            $menu_stmt->execute([$id_reservasi]);
            $menu_items = $menu_stmt->fetchAll();
            ?>
            <div class="reservation-details">
                <div class="detail-section mb-4">
                        <strong>ID Reservation</strong> <?php echo $reservation['id_reservasi']; ?>
                </div>
                <div class="section-divider"></div>
                <div class="detail-section mb-4">
                    <div class="detail-item">
                        <strong>User ID</strong> <?php echo $reservation['id_user']; ?>
                    </div>
                    <div class="detail-item">
                        <strong>Name</strong> <?php echo htmlspecialchars($reservation['nama']); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Email</strong> <?php echo htmlspecialchars($reservation['email']); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Phone Number</strong> <?php echo htmlspecialchars($reservation['no_telp']); ?>
                    </div>
                </div>
                <div class="section-divider"></div>
                <div class="detail-section mb-4">
                    <div class="detail-item">
                        <strong>Date</strong> <?php echo date('l, F j, Y', strtotime($reservation['tanggal_reservasi'])); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Time</strong> <?php echo date('H:i', strtotime($reservation['waktu_reservasi'])); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Number of Guests</strong> <?php echo $reservation['jumlah_orang']; ?>
                    </div>
                    <div class="detail-item">
                        <strong>Date Booked</strong> <?php echo date('F j, Y - H:i', strtotime($reservation['tanggal_dibuat'])); ?>
                    </div>
                </div>
                <div class="section-divider"></div>
                <div class="detail-section mb-4">
                    <div class="detail-item">
                        <strong>Table Name</strong> <?php echo htmlspecialchars($reservation['nama_meja']); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Table Capacity</strong> <?php echo $reservation['kapasitas']; ?> Persons
                    </div>
                    <div class="detail-item">
                        <strong>Table Location</strong> <?php echo htmlspecialchars($reservation['lokasi']); ?>
                    </div>
                </div>
                <div class="section-divider"></div>
                <div class="detail-section mb-4">
                    <?php if (!empty($menu_items)): ?>
                        <div class="menu-list">
                            <?php foreach ($menu_items as $menu): ?>
                                <div class="menu-item mb-2 p-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong><?php echo htmlspecialchars($menu['nama_menu']);?></strong>
                                            <div class="small text-light">
                                                Menu ID: <?php echo $menu['id_menu']; ?> | 
                                                Quantity: <?php echo $menu['jumlah']; ?>
                                            </div>
                                            <?php if (!empty($menu['catatan'])): ?>
                                                <div class="small mt-1">
                                                    <em>Note: <?php echo htmlspecialchars($menu['catatan']); ?></em>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="detail-item text-muted">
                            No menu items ordered.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="section-divider"></div>
                <div class="detail-section mb-4">
                    <div class="detail-item">
                        <strong>Total Amount (Euro):</strong> €<?php echo number_format($reservation['total_euro'], 2); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Total Amount (Dollar):</strong> $<?php echo number_format($reservation['total_dollar'], 2); ?>
                    </div>
                    <div class="detail-item mt-3">
                        <strong>Customer Notes:</strong><br>
                        <?php echo !empty($reservation['catatan']) ? nl2br(htmlspecialchars($reservation['catatan'])) : '<span class="text-light">No notes provided</span>'; ?>
                    </div>
                </div>
                <div class="section-divider"></div>
                <div class="detail-section">
                    <div class="detail-item">
                        <span class="status-badge status-<?php echo strtolower($reservation['status']); ?>">
                            <?php echo strtoupper($reservation['status']); ?>
                        </span>
                    </div>
                </div>
            </div>
            <style>
                .detail-section {
                    padding: 0 10px;
                }
                .detail-item {
                    padding: 8px 0;
                    border-bottom: 1px solid rgba(255, 204, 128, 0.2);
                }
                .detail-item:last-child {
                    border-bottom: none;
                }
                .detail-item strong {
                    color: #ffcc80;
                    min-width: 150px;
                    display: inline-block;
                }
                .menu-list {
                    max-height: 200px;
                    overflow-y: auto;
                }
                .menu-item {
                    background: rgba(255, 255, 255, 0.05);
                    border-radius: 5px;
                    border-left: 3px solid #ffcc80;
                }
            </style>
            <?php
        } else {
            echo '<div class="alert alert-danger">Reservation not found.</div>';
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error loading reservation details: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger">No reservation ID provided.</div>';
}
?>