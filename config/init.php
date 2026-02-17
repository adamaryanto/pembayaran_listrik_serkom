<?php
if (!isset($start_time)) {
    // jika belum didefinisikan, set start sekarang (menghindari warning)
    $start_time = microtime(true);
}

// hitung waktu eksekusi
$execution_time = microtime(true) - $start_time;

// ambil penggunaan memori puncak
$memory_usage = memory_get_peak_usage(true);

// ubah jadi MB biar lebih gampang dibaca
$memory_usage_mb = number_format($memory_usage / 1048576, 2); // 1MB = 1024*1024 byte
?>
<div style="
    position: fixed;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: #fff;
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 14px;
    font-family: sans-serif;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
">
    ⏱️ Halaman dimuat dalam <strong><?= number_format($execution_time, 4) ?></strong> detik 
    | 💾 Memori: <strong><?= $memory_usage_mb ?> MB</strong>
</div>
