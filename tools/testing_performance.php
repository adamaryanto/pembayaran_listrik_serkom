<?php
// 🔹 Uji performa fungsi hitungTagihan()

// 1. Definisikan fungsi yang mau diuji
function hitungTagihan($awal, $akhir, $daya) {
    $pemakaian = $akhir - $awal;
    if ($pemakaian <= 0) return 0;

    if ($daya <= 900) $tarif = 1000;
    elseif ($daya <= 1200) $tarif = 1400;
    elseif ($daya <= 1300) $tarif = 1500;
    elseif ($daya <= 2200) $tarif = 1700;
    else $tarif = 2000;

    return $pemakaian * $tarif;
}

// 2. Mulai ukur waktu dan memori
$start = microtime(true);
$awal_mem = memory_get_usage();

// 3. Jalankan fungsi yang diuji
$total = hitungTagihan(100, 150, 900); // bisa kamu ubah angka-angkanya

// 4. Akhiri pengukuran
$end = microtime(true);
$akhir_mem = memory_get_usage();

// 5. Tampilkan hasil
echo "<h2>Hasil Uji Performa Fungsi hitungTagihan()</h2>";
echo "Total Bayar: Rp" . number_format($total) . "<br>";
echo "Waktu eksekusi: " . round(($end - $start), 6) . " detik<br>";
echo "Memori digunakan: " . ($akhir_mem - $awal_mem) . " byte<br>";
?>
