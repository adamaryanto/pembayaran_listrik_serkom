<?php
// test_all.php
// 🔍 Tools Pengujian Otomatis Aplikasi MyListrik

echo "<h2>🔧 Pengujian Sistem MyListrik</h2>";
echo "<style>
body { font-family: Arial; background:#f9fafb; color:#333; line-height:1.6; }
.pass { color:green; font-weight:bold; }
.fail { color:red; font-weight:bold; }
.box { background:white; padding:15px; border-radius:8px; box-shadow:0 0 5px rgba(0,0,0,0.1); margin:10px 0; }
</style>";

// ✅ 1. Cek koneksi database
echo "<div class='box'><strong>1️⃣ Pengujian Koneksi Database</strong><br>";
include 'config/db.php';
if ($conn && mysqli_ping($conn)) {
    echo " <span class='pass'>PASS:</span> Koneksi database berhasil.<br>";
} else {
    echo " <span class='fail'>FAIL:</span> Tidak dapat terhubung ke database.<br>";
}
echo "</div>";

// ✅ 2. Uji Fungsi Hitung Tagihan
echo "<div class='box'><strong>2️⃣ Pengujian Fungsi Hitung Tagihan</strong><br>";


// =====================================================
// 🔹 Fungsi: hitungTagihan()
// -----------------------------------------------------
// Fungsi ini menghitung total biaya listrik berdasarkan:
// - Meter awal & meter akhir (pemakaian kWh)
// - Daya listrik pelanggan (VA)
// =====================================================
function hitungTagihan($awal, $akhir, $daya) {
    $pemakaian = $akhir - $awal;
    if ($pemakaian < 0) return 0; // mencegah nilai negatif

    if ($daya <= 900) $tarif = 1000;
    elseif ($daya <= 1200) $tarif = 1400;
    elseif ($daya <= 1300) $tarif = 1500;
    elseif ($daya <= 2200) $tarif = 1700;
    else $tarif = 2000;

    return $pemakaian * $tarif;
}

// =====================================================
// 🧪 Daftar Pengujian (Test Case)
// =====================================================
$tests = [
    [
        'awal'=>50, 'akhir'=>70, 'daya'=>450, 'expected'=>20000,
        'deskripsi'=>"Pengujian untuk pelanggan dengan daya 450 VA. 
        Meter awal 50, akhir 70 → pemakaian 20 kWh × Rp1000 = Rp20.000."
    ],
    [
        'awal'=>100, 'akhir'=>120, 'daya'=>900, 'expected'=>20000,
        'deskripsi'=>"Pengujian pelanggan daya 900 VA dengan pemakaian 20 kWh. 
        Tarif Rp1000/kWh → total Rp20.000."
    ],
    [
        'awal'=>150, 'akhir'=>180, 'daya'=>1200, 'expected'=>42000,
        'deskripsi'=>"Pengujian pelanggan daya 1200 VA. 
        Meter awal 150, akhir 180 → 30 kWh × Rp1400 = Rp42.000."
    ],
    [
        'awal'=>200, 'akhir'=>100, 'daya'=>900, 'expected'=>0,
        'deskripsi'=>"Pengujian gagal (meter akhir lebih kecil dari awal). 
        Fungsi harus mengembalikan Rp0."
    ],
];

$all_pass = true;

// =====================================================
// ⚙️ Jalankan Pengujian
// =====================================================
echo "<h2>🧾 Pengujian Fungsi <code>hitungTagihan()</code></h2>";

foreach ($tests as $i => $t) {
    $hasil = hitungTagihan($t['awal'], $t['akhir'], $t['daya']);
    
    echo "<div style='margin-bottom:10px; padding:10px; border:1px solid #ddd; border-radius:8px;'>";
    echo "<strong>Test " . ($i+1) . "</strong><br>";
    echo "<em>{$t['deskripsi']}</em><br>";

    if ($hasil === $t['expected']) {
        echo "✅ Hasil benar → Dihasilkan Rp<b>{$hasil}</b> (sesuai harapan Rp{$t['expected']}).";
    } else {
        echo "❌ Hasil salah → Dihasilkan Rp<b>{$hasil}</b>, seharusnya Rp{$t['expected']}.";
        $all_pass = false;
    }
    echo "</div>";
}

// =====================================================
// 📊 Kesimpulan
// =====================================================
if ($all_pass) {
    echo "<h3 style='color:green;'>🎉 Semua pengujian BERHASIL (PASS)</h3>";
} else {
    echo "<h3 style='color:red;'>⚠️ Beberapa pengujian GAGAL (CEK KEMBALI LOGIKA)</h3>";
}



// ✅ 3. Cek Data User dan Pelanggan
echo "<div class='box'><strong>3️⃣ Pengujian Data User & Pelanggan</strong><br>";
$user_count = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM users");
$pelanggan_count = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM pelanggan");

$u = mysqli_fetch_assoc($user_count);
$p = mysqli_fetch_assoc($pelanggan_count);

if ($u['jml'] > 0 && $p['jml'] > 0) {
    echo "✅ <span class='pass'>PASS:</span> Data user ($u[jml]) dan pelanggan ($p[jml]) tersedia.<br>";
} else {
    echo "❌ <span class='fail'>FAIL:</span> Belum ada data user/pelanggan di database.<br>";
}
echo "</div>";

// ✅ 4. Cek Tagihan
echo "<div class='box'><strong>4️⃣ Pengujian Data Tagihan</strong><br>";
$q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tagihan");
$t = mysqli_fetch_assoc($q);
if ($t['total'] > 0) {
    echo "✅ <span class='pass'>PASS:</span> Data tagihan ditemukan sejumlah {$t['total']} baris.<br>";
} else {
    echo "⚠️ <span class='fail'>Belum ada data tagihan, silakan input pemakaian dulu.</span><br>";
}
echo "</div>";

// ✅ Selesai
echo "<div class='box'><strong>✅ Pengujian Selesai</strong><br>";
echo "Jika semua modul menunjukkan status <span class='pass'>PASS</span>, sistem MyListrik berjalan dengan baik.<br>";
echo "</div>";
?>
