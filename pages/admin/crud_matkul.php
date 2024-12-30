<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotAdmin();

// Create
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $nama_matkul = $_POST['nama_matkul'];
    $prodi_id = $_POST['prodi_id'];
    $dosen_id = $_POST['dosen_id'];
    $stmt = $conn->prepare("INSERT INTO mata_kuliah (nama_matkul, prodi_id, dosen_id) VALUES (:nama_matkul, :prodi_id, :dosen_id)");
    $stmt->bindParam(':nama_matkul', $nama_matkul);
    $stmt->bindParam(':prodi_id', $prodi_id);
    $stmt->bindParam(':dosen_id', $dosen_id);
    $stmt->execute();
}

// Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_matkul = $_POST['nama_matkul'];
    $prodi_id = $_POST['prodi_id'];
    $dosen_id = $_POST['dosen_id'];
    $stmt = $conn->prepare("UPDATE mata_kuliah SET nama_matkul = :nama_matkul, prodi_id = :prodi_id, dosen_id = :dosen_id WHERE id = :id");
    $stmt->bindParam(':nama_matkul', $nama_matkul);
    $stmt->bindParam(':prodi_id', $prodi_id);
    $stmt->bindParam(':dosen_id', $dosen_id);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM mata_kuliah WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Read
$result = $conn->query("
    SELECT mata_kuliah.id, mata_kuliah.nama_matkul, prodi.nama_prodi, dosen.nama_dosen 
    FROM mata_kuliah 
    JOIN prodi ON mata_kuliah.prodi_id = prodi.id 
    JOIN dosen ON mata_kuliah.dosen_id = dosen.id
");
$prodi_result = $conn->query("SELECT * FROM prodi");
$dosen_result = $conn->query("SELECT * FROM dosen");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mata Kuliah - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">CRUD Mata Kuliah</h1>
        
        <!-- Form Create -->
        <form method="POST" class="mb-6">
            <div class="mb-4">
                <label for="nama_matkul" class="block text-sm font-medium text-gray-700">Nama Mata Kuliah</label>
                <input type="text" name="nama_matkul" id="nama_matkul" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="prodi_id" class="block text-sm font-medium text-gray-700">Program Studi</label>
                <select name="prodi_id" id="prodi_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php while ($row = $prodi_result->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_prodi']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="dosen_id" class="block text-sm font-medium text-gray-700">Dosen</label>
                <select name="dosen_id" id="dosen_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php while ($row = $dosen_result->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_dosen']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" name="create" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Tambah Mata Kuliah</button>
        </form>

        <!-- Table Read -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Nama Mata Kuliah</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Program Studi</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Dosen</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['id']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_matkul']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_prodi']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_dosen']; ?></td>
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
            $stmt = $conn->prepare("SELECT * FROM mata_kuliah WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <form method="POST" class="mt-6">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-4">
                    <label for="nama_matkul" class="block text-sm font-medium text-gray-700">Nama Mata Kuliah</label>
                    <input type="text" name="nama_matkul" id="nama_matkul" value="<?php echo $row['nama_matkul']; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
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
                <div class="mb-4">
                    <label for="dosen_id" class="block text-sm font-medium text-gray-700">Dosen</label>
                    <select name="dosen_id" id="dosen_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <?php
                        $dosen_result = $conn->query("SELECT * FROM dosen");
                        while ($dosen = $dosen_result->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo $dosen['id']; ?>" <?php echo ($dosen['id'] == $row['dosen_id']) ? 'selected' : ''; ?>><?php echo $dosen['nama_dosen']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" name="update" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update Mata Kuliah</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>