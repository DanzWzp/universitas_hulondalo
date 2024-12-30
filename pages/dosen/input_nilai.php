<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotDosen();

$dosen_id = $_SESSION['user_id'];

// Create
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $mahasiswa_id = $_POST['mahasiswa_id'];
    $mata_kuliah_id = $_POST['mata_kuliah_id'];
    $nilai = $_POST['nilai'];

    $stmt = $pdo->prepare("INSERT INTO nilai (mahasiswa_id, mata_kuliah_id, nilai) VALUES (:mahasiswa_id, :mata_kuliah_id, :nilai)");
    $stmt->execute([
        'mahasiswa_id' => $mahasiswa_id,
        'mata_kuliah_id' => $mata_kuliah_id,
        'nilai' => $nilai
    ]);
}

// Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nilai = $_POST['nilai'];

    $stmt = $pdo->prepare("UPDATE nilai SET nilai = :nilai WHERE id = :id");
    $stmt->execute([
        'id' => $id,
        'nilai' => $nilai
    ]);
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM nilai WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

// Ambil data mahasiswa dan mata kuliah
$mahasiswa_result = $pdo->query("SELECT * FROM mahasiswa")->fetchAll();
$matkul_result = $pdo->query("SELECT * FROM mata_kuliah")->fetchAll();

// Ambil data nilai untuk ditampilkan di tabel
$nilai_result = $pdo->query("
    SELECT nilai.id, mahasiswa.nama_mahasiswa, mata_kuliah.nama_matkul, nilai.nilai 
    FROM nilai 
    JOIN mahasiswa ON nilai.mahasiswa_id = mahasiswa.id 
    JOIN mata_kuliah ON nilai.mata_kuliah_id = mata_kuliah.id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Input Nilai</h1>
        
        <!-- Form Input Nilai -->
        <form method="POST" class="mb-6">
            <div class="mb-4">
                <label for="mahasiswa_id" class="block text-sm font-medium text-gray-700">Mahasiswa</label>
                <select name="mahasiswa_id" id="mahasiswa_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php foreach ($mahasiswa_result as $row): ?>
                        <option value="<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="mata_kuliah_id" class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                <select name="mata_kuliah_id" id="mata_kuliah_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php foreach ($matkul_result as $row): ?>
                        <option value="<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['nama_matkul']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="nilai" class="block text-sm font-medium text-gray-700">Nilai</label>
                <input type="text" name="nilai" id="nilai" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <button type="submit" name="create" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Input Nilai</button>
        </form>

        <!-- Tabel Data Nilai -->
        <h2 class="text-2xl font-bold mb-6">Data Nilai</h2>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Nama Mahasiswa</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Mata Kuliah</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Nilai</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nilai_result as $row): ?>
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['nama_matkul']); ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo htmlspecialchars($row['nilai']); ?></td>
                        <td class="px-6 py-4 border-b border-gray-300">
                            <!-- Form Update -->
                            <form method="POST" class="inline">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <input type="text" name="nilai" value="<?php echo htmlspecialchars($row['nilai']); ?>" class="px-2 py-1 border border-gray-300 rounded-md">
                                <button type="submit" name="update" class="bg-blue-600 text-white py-1 px-2 rounded-md hover:bg-blue-700">Update</button>
                            </form>
                            <!-- Tombol Delete -->
                            <a href="?delete=<?php echo htmlspecialchars($row['id']); ?>" class="bg-red-600 text-white py-1 px-2 rounded-md hover:bg-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>