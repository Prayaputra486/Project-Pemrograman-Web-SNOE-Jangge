<?php
session_start();
include 'db.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}
$reservation_id = $_POST['reservation_id'] ?? '';
if (empty($reservation_id)) {
    echo json_encode(['success' => false, 'message' => 'Reservation ID required']);
    exit;
}
try {
    $stmt = $pdo->prepare("
        SELECT r.*, u.username, m.nama_meja 
        FROM reservasi r 
        JOIN users u ON r.id_user = u.id_user 
        JOIN meja m ON r.id_meja = m.id_meja 
        WHERE r.id_reservasi = ?
    ");
    $stmt->execute([$reservation_id]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$reservation) {
        echo json_encode(['success' => false, 'message' => 'Reservation not found']);
        exit;
    }
    if ($reservation['status'] === 'Confirmed') {
        echo json_encode([
            'success' => true, 
            'message' => 'Reservation has been confirmed in advance',
            'data' => $reservation
        ]);
        exit;
    }
    if ($reservation['status'] === 'Cancelled') {
        echo json_encode([
            'success' => false, 
            'message' => 'Unable to confirm a reservation that has been cancelled'
        ]);
        exit;
    }
    $update_stmt = $pdo->prepare("
        UPDATE reservasi 
        SET status = 'Confirmed' 
        WHERE id_reservasi = ?
    ");
    $update_stmt->execute([$reservation_id]);
    $stmt->execute([$reservation_id]);
    $updated_reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode([
        'success' => true,
        'message' => 'Reservation successfully confirmed',
        'data' => $updated_reservation
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>