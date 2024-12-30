<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotMahasiswa();

$mahasiswa_id = $_SESSION['user_id'];

// Ambil jadwal kuliah mahasiswa menggunakan PDO
$stmt = $pdo->prepare("
    SELECT jadwal.id, mata_kuliah.nama_matkul, ruangan.nama_ruangan, jadwal.hari, jadwal.jam_mulai, jadwal.jam_selesai 
    FROM jadwal 
    JOIN mata_kuliah ON jadwal.mata_kuliah_id = mata_kuliah.id 
    JOIN ruangan ON jadwal.ruangan_id = ruangan.id 
    JOIN nilai ON mata_kuliah.id = nilai.mata_kuliah_id 
");
$stmt->execute();
$result = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Jadwal Kuliah</h1>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Mata Kuliah</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Ruangan</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Hari</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Jam Mulai</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['nama_matkul']); ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['nama_ruangan']); ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['hari']); ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['jam_mulai']); ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['jam_selesai']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-6 text-center">
    <a href="/universitas_hulondalo/pages/reports/jadwal_pdf.php" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cetak Jadwal</a>
</div>
</body>
</html>