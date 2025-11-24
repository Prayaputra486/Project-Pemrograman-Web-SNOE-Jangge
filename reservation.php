<?php
include 'config.php';
try {
    $query = "SELECT r.id_reservasi, u.nama, r.tanggal_reservasi, r.waktu_reservasi, 
                    r.jumlah_orang, m.nama_meja, r.status, r.tanggal_dibuat
            FROM reservasi r
            JOIN users u ON r.id_user = u.id_user
            JOIN meja m ON r.id_meja = m.id_meja
            WHERE r.id_user = ?
            ORDER BY r.tanggal_dibuat DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $reservations = $stmt->fetchAll();
} catch (Exception $e) {
    die("Error fetching reservations: " . $e->getMessage());
}
?>
<?php include 'header.php'; ?>
    <main class="container">
        <section class="content-section">
            <h2 class="welcome-heading" style="margin-top: 0;">My Reservation</h2>
            <hr class="separator">
            <div class="text-center mb-4">
                <a href="reservation_form.php" class="btn-new-reservation">
                    <i class="fas fa-plus-circle me-2"></i>New Reservation
                </a>
            </div>
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Guest</th>
                                <th>Table</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reservations)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($reservations as $row): ?>
                                    <?php 
                                    $status_class = 'status-' . strtolower($row['status']);
                                    if ($row['status'] == 'Confirmed') $status_class = 'status-confirmed';
                                    if ($row['status'] == 'Completed') $status_class = 'status-completed';
                                    if ($row['status'] == 'Cancelled') $status_class = 'status-cancelled';
                                    ?>
                                    <tr data-bs-toggle='modal' data-bs-target='#detailModal' 
                                        onclick='loadReservationDetail(<?php echo $row['id_reservasi']; ?>)'>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['id_reservasi']; ?></td>
                                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($row['tanggal_reservasi'])); ?></td>
                                        <td><?php echo date('H:i', strtotime($row['waktu_reservasi'])); ?></td>
                                        <td><?php echo $row['jumlah_orang']; ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_meja']); ?></td>
                                        <td>
                                            <span class='status-badge <?php echo $status_class; ?>'>
                                                <?php echo $row['status']; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>
                                        No reservations found.
                                        <div class="mt-3">
                                            <a href="reservation_form.php" class="btn btn-warning">
                                                <i class="fas fa-plus-circle me-2"></i>Make Your First Reservation
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Reservation Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <div class="text-center">
                        <div class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Loading reservation details...</p>
                    </div>
                </div>
            <div class="modal-footer"></div>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>   
    <script>
        let currentReservationId = null;
        function loadReservationDetail(id) {
            currentReservationId = id;
            document.getElementById('detailContent').innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading reservation details...</p>
                </div>
            `;
            fetch('get_my_reservation_detail.php?id=' + id)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    document.getElementById('detailContent').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('detailContent').innerHTML = 
                        '<div class="alert alert-danger">Error loading reservation details. Please try again.</div>';
                    console.error('Error:', error);
                });
        }
    </script>
</body>
</html>