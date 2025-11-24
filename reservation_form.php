<?php
include 'config.php';
$catStmt = $pdo->prepare("SELECT id_kategori, nama_kategori, deskripsi FROM kategori_menu WHERE status = 'aktif' ORDER BY nama_kategori ASC");
$catStmt->execute();
$categories = $catStmt->fetchAll();
?>
<?php include 'header.php'; ?>
<main class="container">
    <section class="content-section">
        <h2 class="welcome-heading" style="margin-top: 0;">SNÖE Jangge Reservation</h2>
        <hr class="separator">
        <div class="progress-steps text-center mb-4">
            <div class="steps-wrapper d-flex justify-content-center align-items-center gap-4">
                <div class="step-circle active" data-step="1">1</div>
                <div class="step-line"></div>
                <div class="step-circle" data-step="2">2</div>
                <div class="step-line"></div>
                <div class="step-circle" data-step="3">3</div>
                <div class="step-line"></div>
                <div class="step-circle" data-step="4">4</div>
                <div class="step-line"></div>
                <div class="step-circle" data-step="5">5</div>
            </div>
        </div>
        <div class="card shadow-lg p-4" style="background-color: rgba(62,39,35,0.85); color:#f5f5dc;">
            <form id="reservationForm" method="post" action="submit_reservation.php">
                <div class="step active" data-step="1">
                    <div class="operating-hours">
                        <h5 class="text-warning mb-3"><i class="fas fa-clock me-2"></i>Operating Hours & Sessions
                        </h5>
                        <p class="mb-2"><strong>Open:</strong> 09:00 - 21:00</p>
                        <p class="mb-0"><strong>Session System:</strong> 1 hour 30 minutes per session with 15
                            minutes break</p>
                    </div>
                    <div class="card p-3 mb-3" style="background-color: rgba(255, 204, 128, 0.1); color:#f5f5dc;">
                        <h5>Step 1: Date, Time & Guests</h5>
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Reservation Date <span
                                        class="required-star">*</span></label>
                                <input id="tanggal_reservasi" name="tanggal_reservasi" type="date"
                                    class="form-control" required />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Reservation Time (Session) <span
                                        class="required-star">*</span></label>
                                <select id="waktu_reservasi" name="waktu_reservasi" class="form-select" required>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Number of People <span
                                        class="required-star">*</span></label>
                                <input id="jumlah_orang" name="jumlah_orang" type="number" min="1"
                                    class="form-control" value="1" required />
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="reservation.php" class="btn btn-next px-4 py-2">Back: Reservation Table</a>
                            <button type="button" id="toStep2" class="btn btn-next px-4 py-2">Next: Select
                                Table</button>
                        </div>
                    </div>
                </div>
                <div class="step" data-step="2">
                    <div class="card p-3 mb-3" style="background-color: rgba(255, 204, 128, 0.1); color:#f5f5dc;">
                        <h5>Step 2: Select Table</h5>
                        <div id="tablesContainer" class="row g-3 mt-2">
                            <div class="col-12 small-muted">Please complete Step 1 first to see available tables.
                            </div>
                        </div>
                        <input type="hidden" id="id_meja" name="id_meja" value="">
                        <div class="mt-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-next px-4 py-2" id="backTo1">Previous: Date &
                                Guests</button>
                            <button type="button" class="btn btn-next px-4 py-2" id="toStep3">Next: Select
                                Menu</button>
                        </div>
                    </div>
                </div>
                <div class="step" data-step="3">
                    <div class="card p-3 mb-3" style="background-color: rgba(255, 204, 128, 0.1); color:#f5f5dc;">
                        <h5>Step 3: Select Menu Items</h5>
                        <div class="accordion mt-3" id="menuAccordion">
                            <?php
                            if (count($categories) === 0) {
                                echo '<div class="small-muted">Belum ada kategori menu aktif.</div>';
                            } else {
                                $i = 0;
                                foreach ($categories as $cat) {
                                    $i++;
                                    $catId = (int) $cat['id_kategori'];
                                    $catName = htmlspecialchars($cat['nama_kategori']);
                                    $catDesc = htmlspecialchars($cat['deskripsi'] ?? '');
                                    $menuStmt = $pdo->prepare("SELECT id_menu, nama_menu, deskripsi, harga_euro, harga_dollar FROM menu WHERE id_kategori = :idkat AND status = 'aktif' ORDER BY nama_menu ASC");
                                    $menuStmt->execute([':idkat' => $catId]);
                                    $menusInCat = $menuStmt->fetchAll();
                                    $collapseId = "collapseCat" . $i;
                                    $headingId = "headingCat" . $i;
                                    ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="<?= $headingId ?>">
                                            <button class="accordion-button <?= $i > 1 ? 'collapsed' : '' ?>" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>"
                                                aria-expanded="<?= $i === 1 ? 'true' : 'false' ?>"
                                                aria-controls="<?= $collapseId ?>">
                                                <?= $catName ?>
                                                <?php if ($catDesc): ?>
                                                    <small class="text-muted ms-2"><?= $catDesc ?></small>
                                                <?php endif; ?>
                                            </button>
                                        </h2>
                                        <div id="<?= $collapseId ?>"
                                            class="accordion-collapse collapse <?= $i === 1 ? 'show' : '' ?>"
                                            aria-labelledby="<?= $headingId ?>" data-bs-parent="#menuAccordion">
                                            <div class="accordion-body">
                                                <?php if (count($menusInCat) === 0): ?>
                                                    <p class="small-muted fst-italic">There are no active menus in this
                                                        category.</p>
                                                <?php else: ?>
                                                    <div class="row g-3">
                                                        <?php foreach ($menusInCat as $m):
                                                            $idm = (int) $m['id_menu'];
                                                            $nama = htmlspecialchars($m['nama_menu']);
                                                            $des = htmlspecialchars($m['deskripsi']);
                                                            $euro = number_format($m['harga_euro'], 2, ',', '.');
                                                            $dollar = number_format($m['harga_dollar'], 2, ',', '.');
                                                            ?>
                                                            <div class="col-md-4">
                                                                <div class="card h-100">
                                                                    <div class="card-body d-flex flex-column">
                                                                        <h6 class="card-title mb-1"><?= $nama ?></h6>
                                                                        <?php
                                                                        if ($catId == 301) {
                                                                            $items = explode(',', $des);
                                                                            echo '<ul class="small-muted mb-2" style="padding-left: 1.2rem;">';
                                                                            foreach ($items as $item) {
                                                                                $trimmed = trim($item);
                                                                                if (!empty($trimmed)) {
                                                                                    echo '<li>' . htmlspecialchars($trimmed) . '</li>';
                                                                                }
                                                                            }
                                                                            echo '</ul>';
                                                                        } else {
                                                                            echo '<p class="card-text small-muted mb-2">' . htmlspecialchars($des) . '</p>';
                                                                        }
                                                                        ?>

                                                                        <p class="mb-2"><strong>€ <?= $euro ?></strong> •
                                                                            <?= $dollar ?></p>

                                                                        <div class="mt-auto d-flex align-items-center">
                                                                            <input type="number" min="0" value="0"
                                                                                name="menu_<?= $idm ?>"
                                                                                class="form-control menu-qty me-2" />
                                                                            <span class="me-auto small-muted">pcs</span>
                                                                        </div>
                                                                        <input type="hidden" name="menu_id_list[]"
                                                                            value="<?= $idm ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-next px-4 py-2" id="backTo2">Previous: Select
                                Table</button>
                            <button type="button" class="btn btn-next px-4 py-2" id="toStep4">Next: Notes</button>
                        </div>
                    </div>
                </div>
                <div class="step" data-step="4">
                    <div class="card p-3 mb-3" style="background-color: rgba(255, 204, 128, 0.1); color:#f5f5dc;">
                        <h5>Step 4: Notes (Optional)</h5>
                        <div class="mt-3 d-flex justify-content-between">
                            <textarea name="catatan" rows="4" class="form-control"
                                placeholder="Special Notes (Optional): Any special requests, allergies, dietary restrictions, or celebration notes..."></textarea>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-next px-4 py-2" id="backTo3">Previous: Select
                                Menu</button>
                            <button type="button" class="btn btn-next px-4 py-2" id="toStep5">Next: Summary</button>
                        </div>
                    </div>
                </div>
                <div class="step" data-step="5">
                    <div class="card p-3 mb-3 summary-card"
                        style="background-color: rgba(245, 245, 220, 1); color:#3e2723;">
                        <h5>Step 5: Reservation Summary</h5>
                        <div id="summary" class="mb-3">

                        </div>
                    </div>
                    <input type="hidden" name="total_euro" id="total_euro" value="0">
                    <input type="hidden" name="total_dollar" id="total_dollar" value="0">
                    <div class="mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-next px-4 py-2" id="backTo4">Previous: Notes</button>
                        <button type="submit" class="btn btn-next px-4 py-2" id="submitBtn">Confirmation</button>
                    </div>
                </div>
            </form>
            <div id="alertArea" class="mt-3"></div>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>
<script src="reservation_form.js"></script>
</body>
</html>