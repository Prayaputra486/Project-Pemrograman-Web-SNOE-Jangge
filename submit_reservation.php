<?php
session_start();
include 'db.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'phpqrcode/qrlib.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_user = $_SESSION['id_user'];
        $tanggal_reservasi = $_POST['tanggal_reservasi'];
        $waktu_reservasi = $_POST['waktu_reservasi'];
        $jumlah_orang = $_POST['jumlah_orang'];
        $id_meja = $_POST['id_meja'];
        $catatan = $_POST['catatan'] ?? '';
        $total_euro = $_POST['total_euro'] ?? 0;
        $total_dollar = $_POST['total_dollar'] ?? 0;
        if (empty($tanggal_reservasi) || empty($waktu_reservasi) || empty($jumlah_orang) || empty($id_meja)) {
            throw new Exception("All required fields must be filled.");
        }
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("
            INSERT INTO reservasi (id_user, tanggal_reservasi, waktu_reservasi, jumlah_orang, id_meja, catatan, total_euro, total_dollar, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Scheduled')
        ");
        $stmt->execute([$id_user, $tanggal_reservasi, $waktu_reservasi, $jumlah_orang, $id_meja, $catatan, $total_euro, $total_dollar]);
        $id_reservasi = $pdo->lastInsertId();
        $menu_ids = $_POST['menu_id_list'] ?? [];
        foreach ($menu_ids as $menu_id) {
            $qty_field = "menu_" . $menu_id;
            $qty = $_POST[$qty_field] ?? 0;
            if ($qty > 0) {
                $stmt_menu = $pdo->prepare("
                    INSERT INTO reservasi_menu (id_reservasi, id_menu, jumlah) 
                    VALUES (?, ?, ?)
                ");
                $stmt_menu->execute([$id_reservasi, $menu_id, $qty]);
            }
        }
        $qrData = generateQRData($id_reservasi, $id_user, $tanggal_reservasi, $waktu_reservasi);
        $qrCodePath = generateQRCode($qrData, $id_reservasi);
        $reservation_data = getReservationData($pdo, $id_reservasi);
        $email_sent = sendConfirmationEmail($reservation_data, $_SESSION['username'], $qrCodePath);
        $pdo->commit();
        $_SESSION['reservation_success'] = true;
        $_SESSION['reservation_id'] = $id_reservasi;
        $_SESSION['email_sent'] = $email_sent;
        $_SESSION['qr_code_path'] = $qrCodePath;
        header("Location: reservation_success.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Reservation failed: " . $e->getMessage();
        header("Location: reservation_form.php");
        exit;
    }
}
function generateQRData($reservation_id, $user_id, $date, $time) {
    $data = $reservation_id . '|' . 
            $user_id . '|' . 
            $date . '|' . 
            $time . '|' . 
            time() . '|' . 
            'snoe_reservation' . '|' . 
            'SNÖE Jangge';
    
    return $data;
}
function generateQRCode($data, $reservation_id) {
    $qrDir = 'qrcodes/';
    if (!is_dir($qrDir)) {
        mkdir($qrDir, 0755, true);
    }
    $filename = $qrDir . 'reservation_' . $reservation_id . '.png';
    QRcode::png($data, $filename, QR_ECLEVEL_L, 8, 2);
    return $filename;
}
function getReservationData($pdo, $id_reservasi) {
    $stmt = $pdo->prepare("
        SELECT r.*, u.username, u.email, m.nama_meja, m.kapasitas
        FROM reservasi r 
        JOIN users u ON r.id_user = u.id_user 
        JOIN meja m ON r.id_meja = m.id_meja 
        WHERE r.id_reservasi = ?
    ");
    $stmt->execute([$id_reservasi]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt_menu = $pdo->prepare("
        SELECT m.nama_menu, rm.jumlah, m.harga_euro, m.harga_dollar
        FROM reservasi_menu rm 
        JOIN menu m ON rm.id_menu = m.id_menu 
        WHERE rm.id_reservasi = ?
    ");
    $stmt_menu->execute([$id_reservasi]);
    $menus = $stmt_menu->fetchAll(PDO::FETCH_ASSOC);
    return [
        'reservation' => $reservation,
        'menus' => $menus
    ];
}
function sendConfirmationEmail($reservation_data, $username, $qrCodePath) {
    $reservation = $reservation_data['reservation'];
    $menus = $reservation_data['menus'];
    if (empty($reservation['email'])) {
        error_log("No email found for user: " . $username);
        return false;
    }
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'snoejangge@gmail.com';
        $mail->Password = 'zvmi jsvt clja sjvp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('snoejangge@gmail.com', 'SNÖE Jangge');
        $mail->addAddress($reservation['email'], $username);
        $mail->addReplyTo('snoejangge@gmail.com', 'SNÖE Jangge Support');
        $mail->addAttachment($qrCodePath, 'reservation_qr.png');
        $mail->isHTML(true);
        $mail->Subject = 'Reservation Confirmation - SNÖE Jangge';
        $emailContent = buildEmailContent($reservation, $menus, $username, $reservation['id_reservasi']);
        $mail->Body = $emailContent;
        $mail->AltBody = strip_tags(str_replace('<br>', "\n", $emailContent));
        $mail->send();
        error_log("Confirmation email with QR code sent to: " . $reservation['email']);
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $e->getMessage());
        return false;
    }
}
function buildEmailContent($reservation, $menus, $username, $reservation_id) {
    $total_euro = $reservation['total_euro'];
    $total_dollar = $reservation['total_dollar'];
    $reservation_date = date('F j, Y', strtotime($reservation['tanggal_reservasi']));
    $menu_html = '';
    if (!empty($menus)) {
        foreach ($menus as $menu) {
            $subtotal_euro = $menu['harga_euro'] * $menu['jumlah'];
            $subtotal_dollar = $menu['harga_dollar'] * $menu['jumlah'];
            $menu_html .= "
            <tr>
                <td style='padding: 10px; border-bottom: 1px solid #ddd;'>{$menu['nama_menu']}</td>
                <td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: center;'>{$menu['jumlah']}</td>
                <td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: right;'>€ " . number_format($menu['harga_euro'], 2) . "</td>
                <td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: right;'>$ " . number_format($menu['harga_dollar'], 2) . "</td>
                <td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: right;'>€ " . number_format($subtotal_euro, 2) . "</td>
                <td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: right;'>$ " . number_format($subtotal_dollar, 2) . "</td>
            </tr>";
        }
    } else {
        $menu_html = "<tr><td colspan='6' style='padding: 10px; text-align: center;'>No menu items selected</td></tr>";
    }
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { 
                font-family: 'Arial', sans-serif; 
                color: #333; 
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .container { 
                max-width: 700px; 
                margin: 0 auto; 
                background: white;
            }
            .header { 
                background: linear-gradient(135deg, #1b1b1b 0%, #3e2723 100%); 
                color: #ffcc80; 
                padding: 30px 20px; 
                text-align: center; 
            }
            .header h1 { 
                margin: 0; 
                font-size: 2.5em; 
                font-weight: bold;
            }
            .header p { 
                margin: 10px 0 0 0; 
                font-style: italic;
                opacity: 0.9;
            }
            .content { 
                padding: 30px; 
            }
            .reservation-info {
                background: #fff9e6;
                border-left: 4px solid #ffcc80;
                padding: 20px;
                margin: 20px 0;
                border-radius: 0 8px 8px 0;
            }
            .summary-table { 
                width: 100%; 
                border-collapse: collapse; 
                margin: 20px 0; 
                background: white;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .summary-table th { 
                background: #ffcc80; 
                color: #3e2723; 
                padding: 12px; 
                text-align: left; 
                font-weight: bold;
                border-bottom: 2px solid #e6b800;
            }
            .summary-table td { 
                padding: 12px; 
                border-bottom: 1px solid #eee; 
            }
            .footer { 
                background: #3e2723; 
                color: #f5f5dc; 
                padding: 25px; 
                text-align: center; 
                margin-top: 20px; 
            }
            .total-row { 
                background: #fff3e0; 
                font-weight: bold; 
                font-size: 1.1em;
            }
            .info-box {
                background: #fff3e0;
                border-left: 4px solid #ffb74d;
                padding: 15px;
                margin: 15px 0;
                border-radius: 0 5px 5px 0;
            }
            .notes-box {
                background: #fff3e0;
                border-left: 4px solid #ffb74d;
                padding: 15px;
                margin: 15px 0;
                border-radius: 0 5px 5px 0;
            }
            .qr-section {
                background: #f8f9fa;
                padding: 25px;
                margin: 25px 0;
                border-radius: 10px;
                border: 2px dashed #ffcc80;
                text-align: center;
            }
            @media (max-width: 600px) {
                .container { width: 100%; }
                .content { padding: 15px; }
                .summary-table { font-size: 0.9em; }
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>SNÖE Jangge</h1>
                <p>Fine Dining Experience</p>
            </div>
            <div class='content'>
                <h2 style='color: #3e2723; margin-top: 0;'>Reservation Confirmation</h2>
                <p>Dear <strong>{$username}</strong>,</p>
                <p>Thank you for choosing SNÖE Jangge! Your reservation has been successfully confirmed.</p>
                <div class='reservation-info'>
                    <h3 style='color: #3e2723; margin-top: 0;'>Reservation Details</h3>
                    <p><strong>Reservation ID:</strong> #{$reservation_id}</p>
                    <p><strong>Date:</strong> {$reservation_date}</p>
                    <p><strong>Time:</strong> {$reservation['waktu_reservasi']}</p>
                    <p><strong>Number of Guests:</strong> {$reservation['jumlah_orang']}</p>
                    <p><strong>Table:</strong> {$reservation['nama_meja']} (Capacity: {$reservation['kapasitas']})</p>
                </div>
                <h3 style='color: #3e2723;'>Order Summary</h3>
                <table class='summary-table'>
                    <thead>
                        <tr>
                            <th>Menu Item</th>
                            <th style='text-align: center;'>Qty</th>
                            <th style='text-align: right;'>Price €</th>
                            <th style='text-align: right;'>Price $</th>
                            <th style='text-align: right;'>Subtotal €</th>
                            <th style='text-align: right;'>Subtotal $</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$menu_html}
                    </tbody>
                    <tfoot>
                        <tr class='total-row'>
                            <td colspan='4' style='text-align: right; padding: 15px;'><strong>Total Amount:</strong></td>
                            <td style='text-align: right; padding: 15px;'><strong>€ " . number_format($total_euro, 2) . "</strong></td>
                            <td style='text-align: right; padding: 15px;'><strong>$ " . number_format($total_dollar, 2) . "</strong></td>
                        </tr>
                    </tfoot>
                </table>
                " . (!empty($reservation['catatan']) ? "
                <div class='notes-box'>
                    <h4 style='color: #3e2723; margin-top: 0;'>Your Special Notes:</h4>
                    <p style='margin: 0;'>{$reservation['catatan']}</p>
                </div>
                " : "") . "
                <div class='info-box'>
                    <h4 style='color: #3e2723; margin-top: 0;'>Important Information</h4>
                    <ul style='margin-bottom: 0;'>
                        <li>Please arrive 10-15 minutes before your reservation time</li>
                        <li>Show the QR code at the cashier when you arrive</li>
                        <li>Your table will be held for 15 minutes past the scheduled time</li>
                        <li>For cancellations or changes, please contact us at least 2 hours in advance</li>
                        <li>Dress code: Smart casual</li>
                    </ul>
                </div>
                <!-- QR Code Section -->
                <div class='qr-section'>
                    <h3 style='color: #3e2723; margin-top: 0;'>
                        <i class='fas fa-qrcode' style='margin-right: 10px;'></i>
                        Your Digital Reservation QR Code
                    </h3>
                    <p style='color: #666; font-size: 14px;'>
                        ⬇️ <strong>QR Code is attached to this email</strong> ⬇️
                    </p>
                </div>
                <p>We look forward to serving you at SNÖE Jangge!</p>
                <p>Warm regards,<br>
                <strong>The SNÖE Jangge Team</strong></p>
            </div>
            <div class='footer'>
                <p style='margin: 0 0 10px 0;'><strong>SNÖE Jangge Restaurant</strong></p>
                <p style='margin: 5px 0;'>Gaislachkogl, Sölden, Austria</p>
                <p style='margin: 5px 0;'>📞 0821-3705-4964 | ✉️ snoejangge@gmail.com</p>
                <p style='margin: 15px 0 0 0; font-size: 0.9em; opacity: 0.8;'>
                    Copyright ©️ 2025 SNÖE Jangge. All rights reserved.
                </p>
            </div>
        </div>
    </body>
    </html>";
}
?>