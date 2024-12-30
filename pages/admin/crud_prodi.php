<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotAdmin();

// Create
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $nama_prodi = $_POST['nama_prodi'];
    $fakultas_id = $_POST['fakultas_id'];
    $stmt = $conn->prepare("INSERT INTO prodi (nama_prodi, fakultas_id) VALUES (:nama_prodi, :fakultas_id)");
    $stmt->bindParam(':nama_prodi', $nama_prodi);
    $stmt->bindParam(':fakultas_id', $fakultas_id);
    $stmt->execute();
}

// Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_prodi = $_POST['nama_prodi'];
    $fakultas_id = $_POST['fakultas_id'];
    $stmt = $conn->prepare("UPDATE prodi SET nama_prodi = :nama_prodi, fakultas_id = :fakultas_id WHERE id = :id");
    $stmt->bindParam(':nama_prodi', $nama_prodi);
    $stmt->bindParam(':fakultas_id', $fakultas_id);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM prodi WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Read
$stmt = $conn->query("
    SELECT prodi.id, prodi.nama_prodi, fakultas.nama_fakultas 
    FROM prodi 
    JOIN fakultas ON prodi.fakultas_id = fakultas.id
");
$prodi = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil data fakultas untuk dropdown
$fakultas_stmt = $conn->query("SELECT * FROM fakultas");
$fakultas = $fakultas_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Program Studi - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">CRUD Program Studi</h1>
        
        <!-- Form Create -->
        <form method="POST" class="mb-6">
            <div class="mb-4">
                <label for="nama_prodi" class="block text-sm font-medium text-gray-700">Nama Program Studi</label>
                <input type="text" name="nama_prodi" id="nama_prodi" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="fakultas_id" class="block text-sm font-medium text-gray-700">Fakultas</label>
                <select name="fakultas_id" id="fakultas_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php foreach ($fakultas as $fak): ?>
                        <option value="<?php echo $fak['id']; ?>"><?php echo $fak['nama_fakultas']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="create" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Tambah Program Studi</button>
        </form>

        <!-- Table Read -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Nama Program Studi</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Fakultas</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prodi as $row): ?>
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['id']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_prodi']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_fakultas']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300">
                            <a href="?edit=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <a href="?delete=<?php echo $row['id']; ?>" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Form Update -->
        <?php if (isset($_GET['edit'])): ?>
            <?php
            $id = $_GET['edit'];
            $stmt = $conn->prepare("SELECT * FROM prodi WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <form method="POST" class="mt-6">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-4">
                    <label for="nama_prodi" class="block text-sm font-medium text-gray-700">Nama Program Studi</label>
                    <input type="text" name="nama_prodi" id="nama_prodi" value="<?php echo $row['nama_prodi']; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="fakultas_id" class="block text-sm font-medium text-gray-700">Fakultas</label>
                    <select name="fakultas_id" id="fakultas_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <?php foreach ($fakultas as $fak): ?>
                            <option value="<?php echo $fak['id']; ?>" <?php echo ($fak['id'] == $row['fakultas_id']) ? 'selected' : ''; ?>><?php echo $fak['nama_fakultas']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="update" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update Program Studi</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>