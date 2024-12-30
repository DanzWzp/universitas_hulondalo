<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotMahasiswa();

$mahasiswa_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
         <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Dashboard Mahasiswa</h1>
            <a href="../../index.php" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Kembali ke Beranda
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="jadwal.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Jadwal Kuliah</h2>
                <p class="text-gray-600">Lihat jadwal kuliah untuk semester ini.</p>
            </a>
            <a href="krs.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Kartu Rencana Studi (KRS)</h2>
                <p class="text-gray-600">Lihat dan cetak KRS Anda.</p>
            </a>
            <a href="khs.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Kartu Hasil Studi (KHS)</h2>
                <p class="text-gray-600">Lihat dan cetak KHS Anda.</p>
            </a>
            <a href="transkip.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Transkip Nilai</h2>
                <p class="text-gray-600">Lihat dan cetak Transkip Nilai Anda.</p>
            </a>
        </div>
    </div>
</body>
</html>