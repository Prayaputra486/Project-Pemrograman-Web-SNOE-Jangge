<?php
require 'db.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}
$menuData = json_decode($_POST['menu_data'] ?? '[]', true);
$result = [
    'success' => false,
    'menus' => [],
    'total_euro' => 0,
    'total_dollar' => 0
];
if (empty($menuData)) {
    echo json_encode($result);
    exit;
}
try {
    $totalEuro = 0;
    $totalDollar = 0;
    $menus = [];
    foreach ($menuData as $item) {
        $menuId = intval($item['id']);
        $qty = intval($item['qty']);
        $stmt = $pdo->prepare("SELECT nama_menu, harga_euro, harga_dollar FROM menu WHERE id_menu = :id");
        $stmt->execute([':id' => $menuId]);
        $menu = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($menu) {
            $hargaEuro = floatval($menu['harga_euro']);
            $hargaDollar = floatval($menu['harga_dollar']);
            $subtotalEuro = $hargaEuro * $qty;
            $subtotalDollar = $hargaDollar * $qty;
            $menus[] = [
                'id' => $menuId,
                'name' => $menu['nama_menu'],
                'qty' => $qty,
                'harga_euro' => $hargaEuro,
                'harga_dollar' => $hargaDollar,
                'subtotal_euro' => $subtotalEuro,
                'subtotal_dollar' => $subtotalDollar
            ];
            $totalEuro += $subtotalEuro;
            $totalDollar += $subtotalDollar;
        }
    }
    $result['success'] = true;
    $result['menus'] = $menus;
    $result['total_euro'] = $totalEuro;
    $result['total_dollar'] = $totalDollar;
} catch (Exception $e) {
    $result['message'] = 'Error fetching menu prices';
}
echo json_encode($result);
?>