<?php
session_start(); // Mulai session untuk mengecek status login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero {
            background: linear-gradient(to right, #4F46E5, #9333EA);
        }
        .btn-primary {
            background-color: #4F46E5;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #4338CA;
        }
        .btn-secondary {
            background-color: #9333EA;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #7E22CE;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/universitas_hulondalo" class="text-2xl font-bold text-indigo-600">Universitas Hulondalo</a>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/universitas_hulondalo/pages/login.php" class="btn-primary text-white py-2 px-4 rounded-md">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl font-bold mb-4">Selamat Datang di Universitas Hulondalo</h1>
            <p class="text-xl mb-8">Membangun generasi unggul melalui pendidikan berkualitas.</p>
            <div class="space-x-4">
                <a href="/universitas_hulondalo/pages/login.php" class="btn-primary text-white py-3 px-8 rounded-md text-lg">Masuk ke Sistem</a>
                <a href="/universitas_hulondalo/pages/signup.php" class="btn-secondary text-white py-3 px-8 rounded-md text-lg">Daftar Sekarang</a>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="container mx-auto py-16">
        <h2 class="text-3xl font-bold text-center mb-8">Tentang Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h3 class="text-2xl font-bold mb-4">Visi</h3>
                <p class="text-gray-700">Menjadi universitas terkemuka yang menghasilkan lulusan berkompeten dan berkarakter.</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h3 class="text-2xl font-bold mb-4">Misi</h3>
                <p class="text-gray-700">Menyelenggarakan pendidikan berkualitas, penelitian inovatif, dan pengabdian masyarakat.</p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-indigo-50 py-16">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center mb-8">Fitur Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold mb-4">Manajemen Akademik</h3>
                    <p class="text-gray-700">Sistem terintegrasi untuk mengelola data akademik dengan mudah.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold mb-4">E-Learning</h3>
                    <p class="text-gray-700">Platform pembelajaran online untuk mendukung proses belajar mengajar.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold mb-4">Laporan Otomatis</h3>
                    <p class="text-gray-700">Generate laporan akademik secara otomatis dalam format PDF.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-indigo-600 text-white py-8">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Universitas Hulondalo. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>