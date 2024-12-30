<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotAdmin();

// Create
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $mahasiswa_id = $_POST['mahasiswa_id'];
    $mata_kuliah_id = $_POST['mata_kuliah_id'];
    $nilai = $_POST['nilai'];
    $stmt = $conn->prepare("INSERT INTO nilai (mahasiswa_id, mata_kuliah_id, nilai) VALUES (:mahasiswa_id, :mata_kuliah_id, :nilai)");
    $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
    $stmt->bindParam(':mata_kuliah_id', $mata_kuliah_id);
    $stmt->bindParam(':nilai', $nilai);
    $stmt->execute();
}

// Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $mahasiswa_id = $_POST['mahasiswa_id'];
    $mata_kuliah_id = $_POST['mata_kuliah_id'];
    $nilai = $_POST['nilai'];
    $stmt = $conn->prepare("UPDATE nilai SET mahasiswa_id = :mahasiswa_id, mata_kuliah_id = :mata_kuliah_id, nilai = :nilai WHERE id = :id");
    $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
    $stmt->bindParam(':mata_kuliah_id', $mata_kuliah_id);
    $stmt->bindParam(':nilai', $nilai);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM nilai WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Read
$result = $conn->query("
    SELECT nilai.id, mahasiswa.nama_mahasiswa, mata_kuliah.nama_matkul, nilai.nilai 
    FROM nilai 
    JOIN mahasiswa ON nilai.mahasiswa_id = mahasiswa.id 
    JOIN mata_kuliah ON nilai.mata_kuliah_id = mata_kuliah.id
");
$mahasiswa_result = $conn->query("SELECT * FROM mahasiswa");
$matkul_result = $conn->query("SELECT * FROM mata_kuliah");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Nilai - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">CRUD Nilai</h1>
        
        <!-- Form Create -->
        <form method="POST" class="mb-6">
            <div class="mb-4">
                <label for="mahasiswa_id" class="block text-sm font-medium text-gray-700">Mahasiswa</label>
                <select name="mahasiswa_id" id="mahasiswa_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php while ($row = $mahasiswa_result->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_mahasiswa']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="mata_kuliah_id" class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                <select name="mata_kuliah_id" id="mata_kuliah_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php while ($row = $matkul_result->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_matkul']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="nilai" class="block text-sm font-medium text-gray-700">Nilai</label>
                <input type="text" name="nilai" id="nilai" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <button type="submit" name="create" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Tambah Nilai</button>
        </form>

        <!-- Table Read -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Mahasiswa</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Mata Kuliah</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Nilai</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['id']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_mahasiswa']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_matkul']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nilai']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300">
                            <a href="?edit=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <a href="?delete=<?php echo $row['id']; ?>" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Form Update -->
        <?php if (isset($_GET['edit'])): ?>
            <?php
            $id = $_GET['edit'];
            $stmt = $conn->prepare("SELECT * FROM nilai WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <form method="POST" class="mt-6">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-4">
                    <label for="mahasiswa_id" class="block text-sm font-medium text-gray-700">Mahasiswa</label>
                    <select name="mahasiswa_id" id="mahasiswa_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <?php
                        $mahasiswa_result = $conn->query("SELECT * FROM mahasiswa");
                        while ($mahasiswa = $mahasiswa_result->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo $mahasiswa['id']; ?>" <?php echo ($mahasiswa['id'] == $row['mahasiswa_id']) ? 'selected' : ''; ?>><?php echo $mahasiswa['nama_mahasiswa']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="mata_kuliah_id" class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                    <select name="mata_kuliah_id" id="mata_kuliah_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <?php
                        $matkul_result = $conn->query("SELECT * FROM mata_kuliah");
                        while ($matkul = $matkul_result->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo $matkul['id']; ?>" <?php echo ($matkul['id'] == $row['mata_kuliah_id']) ? 'selected' : ''; ?>><?php echo $matkul['nama_matkul']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="nilai" class="block text-sm font-medium text-gray-700">Nilai</label>
                    <input type="text" name="nilai" id="nilai" value="<?php echo $row['nilai']; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <button type="submit" name="update" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update Nilai</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>