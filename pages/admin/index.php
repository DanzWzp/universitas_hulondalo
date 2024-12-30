<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Dashboard Admin</h1>
            <a href="../../index.php" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Kembali ke Beranda
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="crud_fakultas.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Kelola Fakultas</h2>
                <p class="text-gray-600">CRUD untuk data fakultas.</p>
            </a>
            <a href="crud_prodi.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Kelola Program Studi</h2>
                <p class="text-gray-600">CRUD untuk data program studi.</p>
            </a>
            <a href="crud_ruangan.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Kelola Ruangan</h2>
                <p class="text-gray-600">CRUD untuk data ruangan.</p>
            </a>
            <a href="crud_dosen.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Kelola Dosen</h2>
                <p class="text-gray-600">CRUD untuk data dosen.</p>
            </a>
            <a href="crud_matkul.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Kelola Mata Kuliah</h2>
                <p class="text-gray-600">CRUD untuk data mata kuliah.</p>
            </a>
            <a href="crud_mahasiswa.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Kelola Mahasiswa</h2>
                <p class="text-gray-600">CRUD untuk data mahasiswa.</p>
            </a>
            <a href="crud_nilai.php" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold mb-2">Kelola Nilai</h2>
                <p class="text-gray-600">CRUD untuk data nilai.</p>
            </a>
        </div>
    </div>
</body>
</html>