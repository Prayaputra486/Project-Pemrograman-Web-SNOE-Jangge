<?php
include 'config_admin.php';
if (isset($_GET['delete_id'])) {
    $id_reservasi = $_GET['delete_id'];
    
    echo "<script>
            if(confirm('Are you sure you want to delete this reservation?')) {
                window.location.href = 'reservation_tables.php?confirm_delete=" . $id_reservasi . "';
            } else {
                window.location.href = 'reservation_tables.php';
            }
          </script>";
    exit;
}
if (isset($_GET['confirm_delete'])) {
    $id_reservasi = $_GET['confirm_delete'];
    try {
        $pdo->beginTransaction();
        $stmt1 = $pdo->prepare("DELETE FROM reservasi_menu WHERE id_reservasi = ?");
        $stmt1->execute([$id_reservasi]);
        $stmt2 = $pdo->prepare("DELETE FROM reservasi WHERE id_reservasi = ?");
        $stmt2->execute([$id_reservasi]);
        $pdo->commit();
        $_SESSION['message'] = "Reservation deleted successfully!";
        $_SESSION['message_type'] = "success";
        
    } catch (Exception $e) {
        $pdo->rollback();
        $_SESSION['message'] = "Error deleting reservation: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }
    header("Location: reservation_tables.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_reservation'])) {
    $id_reservasi = $_POST['id_reservasi'];
    $tanggal_reservasi = $_POST['tanggal_reservasi'];
    $waktu_reservasi = $_POST['waktu_reservasi'];
    $jumlah_orang = $_POST['jumlah_orang'];
    $catatan = $_POST['catatan'];
    $status = $_POST['status'];
    
    try {
        $check_stmt = $pdo->prepare("SELECT jumlah_orang FROM reservasi WHERE id_reservasi = ?");
        $check_stmt->execute([$id_reservasi]);
        $old_data = $check_stmt->fetch();
        if ($jumlah_orang > $old_data['jumlah_orang']) {
            $_SESSION['message'] = "Cannot increase number of guests from original booking!";
            $_SESSION['message_type'] = "warning";
        } else {
            $stmt = $pdo->prepare("UPDATE reservasi SET tanggal_reservasi = ?, waktu_reservasi = ?, jumlah_orang = ?, catatan = ?, status = ? WHERE id_reservasi = ?");
            $stmt->execute([$tanggal_reservasi, $waktu_reservasi, $jumlah_orang, $catatan, $status, $id_reservasi]);
            $_SESSION['message'] = "Reservation updated successfully!";
            $_SESSION['message_type'] = "success";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Error updating reservation: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }
    header("Location: reservation_tables.php");
    exit;
}
$search = $_GET['search'] ?? '';
$filter_date = $_GET['filter_date'] ?? '';
$filter_status = $_GET['filter_status'] ?? '';
$sort = $_GET['sort'] ?? 'id_asc';
try {
    $query = "SELECT r.id_reservasi, u.nama, r.tanggal_reservasi, r.waktu_reservasi, 
                     r.jumlah_orang, m.nama_meja, r.status, r.tanggal_dibuat
              FROM reservasi r
              JOIN users u ON r.id_user = u.id_user
              JOIN meja m ON r.id_meja = m.id_meja
              WHERE 1=1";
    $params = [];
    if (!empty($search)) {
        $query .= " AND u.nama LIKE ?";
        $params[] = "%$search%";
    }
    if (!empty($filter_date)) {
        $query .= " AND r.tanggal_reservasi = ?";
        $params[] = $filter_date;
    }
    if (!empty($filter_status) && $filter_status !== 'all') {
        $query .= " AND r.status = ?";
        $params[] = $filter_status;
    }
    switch ($sort) {
        case 'id_asc':
            $query .= " ORDER BY r.id_reservasi ASC";
            break;
        case 'id_desc':
            $query .= " ORDER BY r.id_reservasi DESC";
            break;
        case 'date_asc':
            $query .= " ORDER BY r.tanggal_reservasi ASC, r.waktu_reservasi ASC";
            break;
        case 'date_desc':
            $query .= " ORDER BY r.tanggal_reservasi DESC, r.waktu_reservasi DESC";
            break;
        case 'name_asc':
            $query .= " ORDER BY u.nama ASC";
            break;
        case 'name_desc':
            $query .= " ORDER BY u.nama DESC";
            break;
        default:
            $query .= " ORDER BY r.id_reservasi ASC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $reservations = $stmt->fetchAll();
    $date_stmt = $pdo->query("SELECT DISTINCT tanggal_reservasi FROM reservasi ORDER BY tanggal_reservasi DESC");
    $available_dates = $date_stmt->fetchAll();
} catch (Exception $e) {
    die("Error fetching reservations: " . $e->getMessage());
}
?>
<?php include 'header.php'; ?>
    <main class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-custom alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
        <section class="content-section">
            <h2 class="welcome-heading" style="margin-top: 0;">Reservation Management</h2>
            <hr class="separator">
            <div class="text-center mb-4">
                <a href="scanner.php" class="btn-new-reservation">Scan Reservation</a>
            </div>
            <div class="filter-section mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <form method="GET" action="" class="d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search by customer name..." 
                                    value="<?php echo htmlspecialchars($search); ?>">
                                <button class="btn btn-warning" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <?php if (!empty($search)): ?>
                                    <a href="?" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form method="GET" action="" class="d-flex" id="dateFilterForm">
                            <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                            <input type="hidden" name="filter_status" value="<?php echo htmlspecialchars($filter_status); ?>">
                            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                            <select class="form-select" name="filter_date" onchange="this.form.submit()">
                                <option value="">All Dates</option>
                                <?php foreach ($available_dates as $date_row): ?>
                                    <option value="<?php echo $date_row['tanggal_reservasi']; ?>" 
                                        <?php echo $filter_date == $date_row['tanggal_reservasi'] ? 'selected' : ''; ?>>
                                        <?php echo date('M j, Y', strtotime($date_row['tanggal_reservasi'])); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (!empty($filter_date)): ?>
                                <a href="?search=<?php echo urlencode($search); ?>&filter_status=<?php echo urlencode($filter_status); ?>&sort=<?php echo urlencode($sort); ?>" 
                                class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form method="GET" action="" class="d-flex" id="statusFilterForm">
                            <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                            <input type="hidden" name="filter_date" value="<?php echo htmlspecialchars($filter_date); ?>">
                            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                            <select class="form-select" name="filter_status" onchange="this.form.submit()">
                                <option value="all">All Status</option>
                                <option value="Scheduled" <?php echo $filter_status == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                                <option value="Confirmed" <?php echo $filter_status == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="Completed" <?php echo $filter_status == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="Cancelled" <?php echo $filter_status == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <?php if (!empty($filter_status) && $filter_status !== 'all'): ?>
                                <a href="?search=<?php echo urlencode($search); ?>&filter_date=<?php echo urlencode($filter_date); ?>&sort=<?php echo urlencode($sort); ?>" 
                                class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form method="GET" action="" id="sortForm">
                            <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                            <input type="hidden" name="filter_date" value="<?php echo htmlspecialchars($filter_date); ?>">
                            <input type="hidden" name="filter_status" value="<?php echo htmlspecialchars($filter_status); ?>">
                            <select class="form-select" name="sort" onchange="this.form.submit()">
                                <option value="id_asc" <?php echo $sort == 'id_asc' ? 'selected' : ''; ?>>ID ↑</option>
                                <option value="id_desc" <?php echo $sort == 'id_desc' ? 'selected' : ''; ?>>ID ↓</option>
                                <option value="date_asc" <?php echo $sort == 'date_asc' ? 'selected' : ''; ?>>Date ↑</option>
                                <option value="date_desc" <?php echo $sort == 'date_desc' ? 'selected' : ''; ?>>Date ↓</option>
                                <option value="name_asc" <?php echo $sort == 'name_asc' ? 'selected' : ''; ?>>Name A-Z</option>
                                <option value="name_desc" <?php echo $sort == 'name_desc' ? 'selected' : ''; ?>>Name Z-A</option>
                            </select>
                        </form>
                    </div>
                </div>
                <?php if (!empty($search) || !empty($filter_date) || (!empty($filter_status) && $filter_status !== 'all')): ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="active-filters">
                            <small class="text-warning">
                                <i class="fas fa-filter me-1"></i>
                                Active filters: 
                                <?php if (!empty($search)): ?>
                                    <span class="badge bg-warning text-dark me-1">Search: "<?php echo htmlspecialchars($search); ?>"</span>
                                <?php endif; ?>
                                <?php if (!empty($filter_date)): ?>
                                    <span class="badge bg-warning text-dark me-1">Date: <?php echo date('M j, Y', strtotime($filter_date)); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($filter_status) && $filter_status !== 'all'): ?>
                                    <span class="badge bg-warning text-dark me-1">Status: <?php echo ucfirst($filter_status); ?></span>
                                <?php endif; ?>
                                <a href="?" class="text-light ms-2"><small>Clear all</small></a>
                            </small>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
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
                                        <td><span class='status-badge <?php echo $status_class; ?>'><?php echo $row['status']; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                <?php if (!empty($reservations)): ?>

                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>
                                            No reservations found
                                            <?php if (!empty($search) || !empty($filter_date) || (!empty($filter_status) && $filter_status !== 'all')): ?>
                                                with the current filters.
                                                <br><a href="?" class="btn btn-warning btn-sm mt-2">Clear Filters</a>
                                            <?php else: ?>
                                                .
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" onclick="editReservation()">Edit</button>
                    <button type="button" class="btn btn-danger" onclick="deleteReservation()">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Reservation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body" id="editContent">
                        <div class="text-center">
                            <div class="spinner-border text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p>Loading edit form...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_reservation" class="btn btn-warning">Update Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
<script src="reservation_tables.js"></script>
</body>
</html>