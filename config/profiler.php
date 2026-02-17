<?php
function profiler_start() {
    global $profiler_start_time, $profiler_start_mem;
    $profiler_start_time = microtime(true);
    $profiler_start_mem  = memory_get_usage(true);
}

function profiler_end() {
    global $profiler_start_time, $profiler_start_mem, $profiler_results;
    $time_taken = microtime(true) - $profiler_start_time;
    $mem_used   = memory_get_usage(true) - $profiler_start_mem;
    $profiler_results = [
        'time' => $time_taken,
        'memory' => $mem_used
    ];
}

function profiler_report() {
    global $profiler_results;
    if (!isset($profiler_results)) return;
    echo "<div style='position:fixed;bottom:10px;right:10px;
            background:rgba(0,0,0,0.75);color:#fff;
            padding:8px 14px;border-radius:20px;font-size:13px;
            font-family:sans-serif;box-shadow:0 2px 8px rgba(0,0,0,0.2);'>
            ⏱️ Waktu eksekusi: <b>" . number_format($profiler_results['time'], 4) . " detik</b><br>
            💾 Memori: <b>" . number_format($profiler_results['memory'] / 1024, 2) . " KB</b>
          </div>";
}

// tes include
echo "✅ profiler loaded<br>";
