<?php include 'config_admin.php'; ?>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="styles.css">
<main class="container">
    <section class="content-section">
        <h2 class="welcome-heading" style="margin-top: 0;">QR Code Confirmation</h2>
        <hr class="separator">
        <div class="scanner-container text-center">
            <div id="reader"></div>
            <div class="scanner-status">
                <div id="scanner-status-text" class="text-light">
                    <i class="fas fa-camera"></i> Scanner ready - Point the QR code at the camera
                </div>
            </div>
        </div>
        <div class="text-center mb-4">
            <a href="reservation_tables.php" class="btn-new-reservation">Reservation Tables</a>
        </div>
    </section>
</main>
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Scan results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="result-content">
                    
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="scanner.js"></script>
</body>
</html>