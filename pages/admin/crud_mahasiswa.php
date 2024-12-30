<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotAdmin();

// Create
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $prodi_id = $_POST['prodi_id'];
    $stmt = $conn->prepare("INSERT INTO mahasiswa (nama_mahasiswa, prodi_id) VALUES (:nama_mahasiswa, :prodi_id)");
    $stmt->bindParam(':nama_mahasiswa', $nama_mahasiswa);
    $stmt->bindParam(':prodi_id', $prodi_id);
    $stmt->execute();
}

// Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $prodi_id = $_POST['prodi_id'];
    $stmt = $conn->prepare("UPDATE mahasiswa SET nama_mahasiswa = :nama_mahasiswa, prodi_id = :prodi_id WHERE id = :id");
    $stmt->bindParam(':nama_mahasiswa', $nama_mahasiswa);
    $stmt->bindParam(':prodi_id', $prodi_id);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Read
$result = $conn->query("SELECT mahasiswa.id, mahasiswa.nama_mahasiswa, prodi.nama_prodi FROM mahasiswa JOIN prodi ON mahasiswa.prodi_id = prodi.id");
$prodi_result = $conn->query("SELECT * FROM prodi");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mahasiswa - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">CRUD Mahasiswa</h1>
        
        <!-- Form Create -->
        <form method="POST" class="mb-6">
            <div class="mb-4">
                <label for="nama_mahasiswa" class="block text-sm font-medium text-gray-700">Nama Mahasiswa</label>
                <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="prodi_id" class="block text-sm font-medium text-gray-700">Program Studi</label>
                <select name="prodi_id" id="prodi_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php while ($row = $prodi_result->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_prodi']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" name="create" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Tambah Mahasiswa</button>
        </form>

        <!-- Table Read -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Nama Mahasiswa</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Program Studi</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['id']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_mahasiswa']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_prodi']; ?></td>
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
            $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <form method="POST" class="mt-6">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-4">
                    <label for="nama_mahasiswa" class="block text-sm font-medium text-gray-700">Nama Mahasiswa</label>
                    <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" value="<?php echo $row['nama_mahasiswa']; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="prodi_id" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <select name="prodi_id" id="prodi_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <?php
                        $prodi_result = $conn->query("SELECT * FROM prodi");
                        while ($prodi = $prodi_result->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo $prodi['id']; ?>" <?php echo ($prodi['id'] == $row['prodi_id']) ? 'selected' : ''; ?>><?php echo $prodi['nama_prodi']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" name="update" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update Mahasiswa</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>