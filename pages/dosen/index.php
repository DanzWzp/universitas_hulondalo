<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotDosen();

$dosen_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Dashboard Dosen</h1>
            <a href="../../index.php" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Kembali ke Beranda
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="input_nilai.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Input Nilai</h2>
                <p class="text-gray-600">Input nilai mahasiswa untuk mata kuliah yang diajar.</p>
            </a>
            <a href="jadwal.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Jadwal Mengajar</h2>
                <p class="text-gray-600">Lihat jadwal mengajar untuk semester ini.</p>
            </a>
        </div>
    </div>
</body>
</html>