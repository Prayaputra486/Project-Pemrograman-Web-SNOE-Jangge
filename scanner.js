let html5QrcodeScanner = null;
let isScanning = false;
let resultModal = null;
document.addEventListener('DOMContentLoaded', function () {
    resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
    initializeScanner();
});
function initializeScanner() {
    document.getElementById('scan-next-btn').addEventListener('click', function () {
        resultModal.hide();
        startScanner();
    });
    document.getElementById('resultModal').addEventListener('hidden.bs.modal', function () {
        startScanner();
    });
    startScanner();
}
async function startScanner() {
    if (isScanning) return;
    try {
        const cameras = await Html5Qrcode.getCameras();
        if (!cameras || cameras.length === 0) {
            updateStatusText("No camera found", "text-danger");
            return;
        }
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            rememberLastUsedCamera: true
        };
        if (html5QrcodeScanner) {
            await html5QrcodeScanner.clear();
        }
        html5QrcodeScanner = new Html5QrcodeScanner("reader", config);
        await html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        isScanning = true;
        updateStatusText("Scanner active - Point camera at QR code", "text-success");
    } catch (err) {
        console.error("Scanner initialization failed", err);
        updateStatusText("Camera access denied or not available", "text-danger");
    }
}
function onScanSuccess(decodedText, decodedResult) {
    console.log('QR Code scanned:', decodedText);
    stopScanner();
    updateStatusText("Processing QR code...", "text-warning");
    processScannedData(decodedText);
}
function onScanFailure(error) {
    if (!error.includes("No MultiFormat Readers") && !error.includes("NotFoundException")) {
        console.warn('Scan error:', error);
    }
}
function processScannedData(data) {
    const reservationId = extractReservationIdFromString(data);
    if (!reservationId) {
        showError("Invalid QR Code", "This doesn't appear to be a valid SNÖE Jangge reservation QR code");
        return;
    }
    confirmReservation(reservationId);
}

function extractReservationIdFromString(data) {
    if (data.includes('|')) {
        const parts = data.split('|');
        if (parts.length >= 7 && parts[5] === 'snoe_reservation') {
            return parts[0];
        }
    }
    const idMatch = data.match(/^(\d+)$/);
    return idMatch ? idMatch[1] : null;
}
async function confirmReservation(reservationId) {
    updateStatusText("Confirming reservation...", "text-warning");
    try {
        const formData = new FormData();
        formData.append('reservation_id', reservationId);
        const response = await fetch('confirm_reservation.php', {
            method: 'POST',
            body: formData
        });
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        if (data.success) {
            showSuccess(data.data, data.message);
        } else {
            showError("Confirmation Failed", data.message);
        }
    } catch (error) {
        console.error('Error confirming reservation:', error);
        showError("System Error", "Unable to connect to server. Please try again.");
    }
}
function showSuccess(reservationData, message) {
    const resultContent = document.getElementById('result-content');
    const formattedDate = new Date(reservationData.tanggal_reservasi).toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    resultContent.innerHTML = `
        <div class="alert alert-success">
            <h5><i class="fas fa-check-circle"></i> Reservation Confirmed</h5>
            <p class="mb-2">${message}</p>
            <small>Scanned at: ${new Date().toLocaleTimeString()}</small>
        </div>
        <div class="reservation-card">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-warning">Reservation Details</h6>
                    <p><strong>ID:</strong> #${reservationData.id_reservasi}</p>
                    <p><strong>Name:</strong> ${reservationData.username}</p>
                    <p><strong>Date:</strong> ${formattedDate}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-warning">&nbsp;</h6>
                    <p><strong>Time:</strong> ${reservationData.waktu_reservasi}</p>
                    <p><strong>Guests:</strong> ${reservationData.jumlah_orang}</p>
                    <p><strong>Table:</strong> ${reservationData.nama_meja}</p>
                </div>
            </div>
            <div class="mt-3">
                <span class="status-badge bg-success">
                    <i class="fas fa-check"></i> ${reservationData.status}
                </span>
            </div>
        </div>
    `;
    updateStatusText("Reservation confirmed successfully", "text-success");
    resultModal.show();
}
function showError(title, message) {
    const resultContent = document.getElementById('result-content');
    resultContent.innerHTML = `
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-triangle"></i> ${title}</h5>
            <p class="mb-0">${message}</p>
        </div>
        <div class="text-center mt-3">
            <button class="btn btn-warning" onclick="startScanner()">
                <i class="fas fa-redo"></i> Try Again
            </button>
        </div>
    `;
    updateStatusText("Scan failed", "text-danger");
    resultModal.show();
}
async function stopScanner() {
    if (html5QrcodeScanner && isScanning) {
        try {
            await html5QrcodeScanner.clear();
            isScanning = false;
            console.log("Scanner stopped successfully");
        } catch (err) {
            console.error("Failed to stop scanner:", err);
        }
    }
}
function updateStatusText(text, className) {
    const statusElement = document.getElementById('scanner-status-text');
    if (statusElement) {
        statusElement.textContent = text;
        statusElement.className = className;
    }
}