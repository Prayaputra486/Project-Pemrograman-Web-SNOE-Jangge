<?php
session_start();
if (!isset($_SESSION['reservation_success']) || !$_SESSION['reservation_success']) {
    header("Location: reservation_form.php");
    exit;
}
$reservation_id = $_SESSION['reservation_id'] ?? '';
$email_sent = $_SESSION['email_sent'] ?? false;
$qr_code_path = $_SESSION['qr_code_path'] ?? '';
unset($_SESSION['reservation_success']);
unset($_SESSION['reservation_id']);
unset($_SESSION['email_sent']);
unset($_SESSION['qr_code_path']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Successful - SNÖE Jangge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1b1b1b 0%, #2c2c2c 50%, #3e2723 100%);
            color: #f5f5dc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        } 
        .success-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 35px 30px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            color: #333;
            max-width: 500px;
            margin: 0 auto;
            transition: transform 0.3s ease;
        }
        .success-card:hover {
            transform: translateY(-5px);
        }
        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 20px;
            animation: bounce 1s ease;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-15px);}
            60% {transform: translateY(-7px);}
        }
        .reservation-id {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 18px;
            margin: 25px 0;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .qr-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            border: 2px dashed #ffcc80;
        }
        .qr-code {
            max-width: 200px;
            margin: 0 auto;
            padding: 10px;
            background: white;
            border-radius: 8px;
        }
        .btn-custom {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 5px;
        }
        .btn-outline-dark {
            border-color: #3e2723;
            color: #3e2723;
        }
        .btn-outline-dark:hover {
            background-color: #3e2723;
            color: white;
            transform: scale(1.05);
        }
        .info-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        .email-status {
            margin: 15px 0;
            padding: 12px;
            border-radius: 6px;
            font-weight: 500;
        }
        .email-sent {
            background-color: rgba(40, 167, 69, 0.1);
            color: #155724;
        }
        .email-not-sent {
            background-color: rgba(255, 193, 7, 0.1);
            color: #856404;
        }
        h3 {
            font-weight: 600;
            margin-bottom: 15px;
        }
        h4 {
            font-weight: 700;
        }
        h5 {
            font-weight: 600;
        }
        .text-warning {
            color: #ff9800 !important;
        }
        .status-icon {
            font-size: 1.2rem;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="success-card">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 style="color: #3e2723;">Reservation Confirmed!</h3>
                    <p class="mb-4">Your reservation has been successfully confirmed. We look forward to welcoming you to SNÖE Jangge.</p>
                    <div class="reservation-id">
                        <h5 class="mb-2" style="color: #3e2723;">Your Reservation ID</h5>
                        <h4 class="mb-0 text-warning">#<?php echo htmlspecialchars($reservation_id); ?></h4>
                    </div>
                    <?php if ($qr_code_path && file_exists($qr_code_path)): ?>
                    <div class="qr-section">
                        <h5 style="color: #3e2723; margin-bottom: 15px;">
                            <i class="fas fa-qrcode me-2"></i>Your Digital QR Code
                        </h5>
                        <div class="qr-code">
                            <img src="<?php echo $qr_code_path; ?>" alt="Reservation QR Code" class="img-fluid">
                        </div>
                        <p class="mt-3 mb-2"><strong>How to use:</strong></p>
                        <p class="small text-muted mb-0">
                            Show this QR code at the cashier.
                        </p>
                    </div>
                    <?php endif; ?>
                    <?php if ($email_sent): ?>
                        <div class="email-status email-sent">
                            <i class="fas fa-check-circle status-icon"></i>
                            Confirmation email sent with QR code
                            <div class="mt-2">
                                <small>
                                    <i class="fas fa-paperclip me-1"></i>
                                    QR code is attached to the email - please check your attachments
                                </small>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="email-status email-not-sent">
                            <i class="fas fa-exclamation-triangle status-icon"></i>
                            Email not sent
                            <div class="mt-1">
                                <small>Please save your Reservation ID and screenshot the QR code above</small>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex flex-column flex-md-row justify-content-center mt-4">
                        <a href="index.php" class="btn btn-outline-dark btn-custom mt-4">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                        <a href="reservation.php" class="btn btn-outline-dark btn-custom mt-4">
                            <i class="fas fa-plus me-2"></i>New Reservation
                        </a>
                    </div>
                    <div class="info-section">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Please arrive 15 minutes before your reservation time.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>