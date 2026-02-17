<?php
// =====================
// 🔹 MULAI UKUR WAKTU
// =====================
$start_time = microtime(true);

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/db.php';
include '../config/init.php';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Input Pemakaian Listrik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Input Pemakaian Listrik</h2>
        <a href="index.php"
           class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50">
            &larr; Kembali
        </a>
    </div>

    <form action="proses_pemakaian.php" method="POST" class="space-y-4">

        <!-- Pilih Pelanggan -->
        <div>
            <label for="pelanggan_id" class="block font-medium text-gray-700">Pelanggan</label>
            <select id="pelanggan_id" name="pelanggan_id" required class="w-full border rounded p-2">
                <option value="">-- Pilih Pelanggan --</option>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY nama_pelanggan ASC");
                while ($p = mysqli_fetch_assoc($q)) {
                    echo "<option value='{$p['id']}' data-daya='{$p['daya']}'>"
                        . htmlspecialchars($p['nama_pelanggan'])
                        . " ({$p['no_kwh']} - {$p['daya']} VA)</option>";
                }
                ?>
            </select>
        </div>

        <!-- Bulan & Tahun -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="bulan">Bulan</label>
                <select id="bulan" name="bulan" required class="w-full border rounded p-2">
                    <?php
                    $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                    foreach ($bulan as $b) echo "<option value='$b'>$b</option>";
                    ?>
                </select>
            </div>
            <div>
                <label for="tahun">Tahun</label>
                <input type="number" name="tahun" value="<?= date('Y') ?>" required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- Meteran -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="meter_awal">Meter Awal</label>
                <input type="number" name="meter_awal" id="meter_awal" required class="w-full border rounded p-2">
            </div>
            <div>
                <label for="meter_akhir">Meter Akhir</label>
                <input type="number" name="meter_akhir" id="meter_akhir" required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- Hasil Otomatis -->
        <div id="hasil" class="mt-4 p-3 bg-gray-50 border rounded text-gray-700 text-sm">
            <strong>Info Tagihan:</strong>
            <div id="info-daya">Daya: -</div>
            <div id="info-pemakaian">Pemakaian: -</div>
            <div id="info-total">Total Bayar: -</div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                Simpan
            </button>
        </div>
    </form>
</div>

<!-- 🔹 JS Otomatis Hitung Tagihan -->
<script>
const pelangganSelect = document.getElementById('pelanggan_id');
const meterAwal = document.getElementById('meter_awal');
const meterAkhir = document.getElementById('meter_akhir');

function hitungTagihan() {
    const daya = parseInt(pelangganSelect.options[pelangganSelect.selectedIndex]?.dataset?.daya || 0);
    const awal = parseInt(meterAwal.value || 0);
    const akhir = parseInt(meterAkhir.value || 0);
    const pemakaian = akhir - awal;

    let tarif = 0;
    if (daya <= 900) tarif = 1000;
    else if (daya <= 1200) tarif = 1400;
    else if (daya <= 1300) tarif = 1500;
    else if (daya <= 2200) tarif = 1700;
    else tarif = 2000;

    const total = pemakaian > 0 ? pemakaian * tarif : 0;

    document.getElementById('info-daya').innerText = `Daya: ${daya} VA`;
    document.getElementById('info-pemakaian').innerText = `Pemakaian: ${pemakaian > 0 ? pemakaian : 0} kWh`;
    document.getElementById('info-total').innerText = `Total Bayar: Rp ${total.toLocaleString()}`;
}

pelangganSelect.addEventListener('change', hitungTagihan);
meterAwal.addEventListener('input', hitungTagihan);
meterAkhir.addEventListener('input', hitungTagihan);
</script>


</body>
</html>
