const sessions = [
    { label: "09:00 - 10:30", value: "09:00-10:30" },
    { label: "10:45 - 12:15", value: "10:45-12:15" },
    { label: "12:30 - 14:00", value: "12:30-14:00" },
    { label: "14:15 - 15:45", value: "14:15-15:45" },
    { label: "16:00 - 17:30", value: "16:00-17:30" },
    { label: "17:45 - 19:15", value: "17:45-19:15" },
    { label: "19:30 - 21:00", value: "19:30-21:00" },
];
const waktuSelect = document.getElementById('waktu_reservasi');
sessions.forEach(s => {
    const opt = document.createElement('option');
    opt.value = s.value;
    opt.textContent = s.label;
    waktuSelect.appendChild(opt);
});
let currentStep = 1;
const totalSteps = 5;
function showStep(n) {
    document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
    const sel = document.querySelector('.step[data-step="' + n + '"]');
    if (sel) sel.classList.add('active');
    currentStep = n;
    document.querySelectorAll('.step-circle').forEach((circle, index) => {
        const stepNum = index * 1 + 1;
        if (stepNum <= n) {
            circle.classList.add('active');
        } else {
            circle.classList.remove('active');
        }
    });
    document.querySelectorAll('.step-line').forEach((line, index) => {
        if (index < n - 1) {
            line.classList.add('active');
        } else {
            line.classList.remove('active');
        }
    });
}
document.getElementById('toStep2').addEventListener('click', async () => {
    const date = document.getElementById('tanggal_reservasi').value;
    const waktu = document.getElementById('waktu_reservasi').value;
    const jumlah = document.getElementById('jumlah_orang').value;
    if (!date || !waktu || !jumlah || jumlah < 1) {
        alert('Please enter the date, time, and number of guests correctly.');
        return;
    }
    await fetchTables(date, waktu, jumlah);
    showStep(2);
});
document.getElementById('backTo1').addEventListener('click', () => showStep(1));
document.getElementById('backTo2').addEventListener('click', () => showStep(2));
document.getElementById('backTo3').addEventListener('click', () => showStep(3));
document.getElementById('backTo4').addEventListener('click', () => showStep(4));
document.getElementById('toStep3').addEventListener('click', () => {
    if (!document.getElementById('id_meja').value) {
        alert('Please choose your table before proceeding.');
        return;
    }
    showStep(3);
});
document.getElementById('toStep4').addEventListener('click', () => showStep(4));
document.getElementById('toStep5').addEventListener('click', () => {
    buildSummary();
    showStep(5);
});
async function fetchTables(tanggal, waktu, jumlah) {
    const container = document.getElementById('tablesContainer');
    container.innerHTML = '<div class="col-12">Checking table availability...</div>';
    try {
        const form = new FormData();
        form.append('tanggal_reservasi', tanggal);
        form.append('waktu_reservasi', waktu);
        form.append('jumlah_orang', jumlah);
        const resp = await fetch('get_tables.php', { method: 'POST', body: form });
        const html = await resp.text();
        container.innerHTML = html;
        document.querySelectorAll('.table-card').forEach(card => {
            card.addEventListener('click', function () {
                document.querySelectorAll('.table-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('id_meja').value = this.dataset.id;
            });
        });
    } catch (err) {
        container.innerHTML = '<div class="col-12 text-danger">An error occurred while checking the table.</div>';
        console.error(err);
    }
}
async function buildSummary() {
    const tanggal = document.getElementById('tanggal_reservasi').value;
    const waktu = document.getElementById('waktu_reservasi').value;
    const jumlah = document.getElementById('jumlah_orang').value;
    const id_meja = document.getElementById('id_meja').value;
    const tableCard = id_meja ? document.querySelector('.table-card[data-id="' + id_meja + '"]') : null;
    const mejaNama = tableCard ? tableCard.dataset.nama : '-';
    const menuData = [];
    document.querySelectorAll('input[type="number"][name^="menu_"]').forEach(inp => {
        const qty = parseInt(inp.value) || 0;
        if (qty > 0) {
            const menuId = inp.name.replace('menu_', '');
            const name = inp.closest('.card').querySelector('.card-title')?.textContent || 'Menu';
            menuData.push({ id: menuId, qty: qty, name: name });
        }
    });
    let menus = [];
    let totalEuro = 0;
    let totalDollar = 0;
    if (menuData.length > 0) {
        try {
            const formData = new FormData();
            formData.append('menu_data', JSON.stringify(menuData));
            const resp = await fetch('get_menu_prices.php', {
                method: 'POST',
                body: formData
            });
            const result = await resp.json();
            if (result.success) {
                menus = result.menus;
                totalEuro = result.total_euro;
                totalDollar = result.total_dollar;
            }
        } catch (error) {
            console.error('Error fetching menu prices:', error);
        }
    }
    document.getElementById('total_euro').value = totalEuro;
    document.getElementById('total_dollar').value = totalDollar;
    const catatan = document.querySelector('textarea[name="catatan"]').value || '-';
    let html = `
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Date:</strong> ${tanggal}</p>
                <p><strong>Time (Session):</strong> ${waktu}</p>
                <p><strong>Number of people:</strong> ${jumlah}</p>
                <p><strong>Table selected:</strong> ${mejaNama}</p>
            </div>
        </div>
    `;
    if (menus.length > 0) {
        html += `
            <div class="mb-4">
                <table class="table table-sm summary-table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Price €</th>
                            <th class="text-end">Price $</th>
                            <th class="text-end">Subtotal €</th>
                            <th class="text-end">Subtotal $</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        menus.forEach(menu => {
            html += `
                <tr>
                    <td>${menu.name}</td>
                    <td class="text-center">${menu.qty}</td>
                    <td class="text-end">€ ${menu.harga_euro.toFixed(2)}</td>
                    <td class="text-end">$ ${menu.harga_dollar.toFixed(2)}</td>
                    <td class="text-end">€ ${menu.subtotal_euro.toFixed(2)}</td>
                    <td class="text-end">$ ${menu.subtotal_dollar.toFixed(2)}</td>
                </tr>
            `;
        });
        html += `
                    </tbody>
                    <tfoot class="border-top" style="border-color: #ffcc80 !important;">
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                            <td class="text-end"><strong>€ ${totalEuro.toFixed(2)}</strong></td>
                            <td class="text-end"><strong>$ ${totalDollar.toFixed(2)}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        `;
    } else {
        html += `<p class="text-muted">No menu items selected</p>`;
    }
    html += `
        <div>
            <p><strong>Special Notes:</strong> ${catatan}</p>
        </div>
    `;
    document.getElementById('summary').innerHTML = html;
}
document.getElementById('reservationForm').addEventListener('submit', function (e) {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.textContent = 'Save Reservation...';
});