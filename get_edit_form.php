<?php
session_start();
include 'db.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    exit('Access denied');
}
if (isset($_GET['id'])) {
    $id_reservasi = $_GET['id'];   
    try {
        $query = "SELECT * FROM reservasi WHERE id_reservasi = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id_reservasi]);
        $reservation = $stmt->fetch();
        if ($reservation) {
            ?>
            <input type="hidden" name="id_reservasi" value="<?php echo $reservation['id_reservasi']; ?>">
            <div class="mb-3">
                <label class="form-label">Date:</label>
                <input type="date" class="form-control" name="tanggal_reservasi" 
                       value="<?php echo $reservation['tanggal_reservasi']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Time:</label>
                <input type="time" class="form-control" name="waktu_reservasi" 
                       value="<?php echo $reservation['waktu_reservasi']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Number of Guests:</label>
                <input type="number" class="form-control" name="jumlah_orang" 
                       value="<?php echo $reservation['jumlah_orang']; ?>" 
                       max="<?php echo $reservation['jumlah_orang']; ?>" min="1" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Notes:</label>
                <textarea class="form-control" name="catatan" rows="3"><?php echo htmlspecialchars($reservation['catatan']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status:</label>
                <select class="form-select" name="status" required>
                    <option value="Scheduled" <?php echo $reservation['status'] == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                    <option value="Confirmed" <?php echo $reservation['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="Completed" <?php echo $reservation['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="Cancelled" <?php echo $reservation['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <?php
        } else {
            echo '<div class="alert alert-danger">Reservation not found.</div>';
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error loading edit form: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger">No reservation ID provided.</div>';
}
?>