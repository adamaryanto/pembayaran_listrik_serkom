<?php
// tools/quick_binary.php

//  Quick Sort Function
function quick_sort(array $arr): array {
    if (count($arr) < 2) {
        return $arr;
    }
    $pivot = $arr[0];
    $left = $right = [];

    for ($i = 1; $i < count($arr); $i++) {
        if ($arr[$i] <= $pivot)
            $left[] = $arr[$i];
        else
            $right[] = $arr[$i];
    }
    return array_merge(quick_sort($left), [$pivot], quick_sort($right));
}

//  Binary Search Function
function binary_search(array $sorted, $target): int {
    $low = 0;
    $high = count($sorted) - 1;

    while ($low <= $high) {
        $mid = intdiv($low + $high, 2);
        if ($sorted[$mid] == $target) return $mid;
        elseif ($sorted[$mid] < $target) $low = $mid + 1;
        else $high = $mid - 1;
    }
    return -1;
}

//  Contoh Penggunaan (bisa kamu screenshot hasilnya)
$data = [45, 12, 89, 33, 27, 64];
echo "Data awal: " . implode(", ", $data) . "<br>";

$sorted = quick_sort($data);
echo "Data setelah Quick Sort: " . implode(", ", $sorted) . "<br>";

$cari = 33;
$posisi = binary_search($sorted, $cari);

if ($posisi >= 0)
    echo "Nilai $cari ditemukan pada indeks ke-$posisi.";
else
    echo "Nilai $cari tidak ditemukan.";
?>
