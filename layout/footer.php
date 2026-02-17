<?php
if (!isset($start_time)) {
    // kalau belum ada, buat default supaya gak error
    $start_time = microtime(true);
}

$execution_time = microtime(true) - $start_time;
$mem_usage = memory_get_peak_usage(true);
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
    z-index: 9999;
">
    ⏱️ <?= number_format($execution_time, 4) ?> detik | 💾 <?= number_format($mem_usage / 1024, 2) ?> KB
</div>
