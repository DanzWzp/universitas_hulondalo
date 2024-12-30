<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotMahasiswa();

$mahasiswa_id = $_SESSION['user_id'];

// Ambil data transkrip nilai mahasiswa
try {
    $stmt = $pdo->prepare("
        SELECT mata_kuliah.nama_matkul, prodi.nama_prodi, nilai.nilai 
        FROM nilai 
        JOIN mata_kuliah ON nilai.mata_kuliah_id = mata_kuliah.id 
        JOIN prodi ON mata_kuliah.prodi_id = prodi.id
    ");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transkrip Nilai - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Transkrip Nilai</h1>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Mata Kuliah</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Program Studi</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['nama_matkul']); ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['nama_prodi']); ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['nilai']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mt-6">
            <a href="/universitas_hulondalo/pages/reports/transkip_pdf.php" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cetak Transkrip Nilai</a>
        </div>
    </div>
</body>
</html>