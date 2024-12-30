<?php
include '../../includes/db.php';
include '../../includes/auth.php';

redirectIfNotProdi();

$prodi_id = $_SESSION['prodi_id'];

// Create
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $mata_kuliah_id = $_POST['mata_kuliah_id'];
    $ruangan_id = $_POST['ruangan_id'];
    $dosen_id = $_POST['dosen_id'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    $stmt = $pdo->prepare("INSERT INTO jadwal (mata_kuliah_id, ruangan_id, dosen_id, hari, jam_mulai, jam_selesai) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$mata_kuliah_id, $ruangan_id, $dosen_id, $hari, $jam_mulai, $jam_selesai]);
}

// Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $mata_kuliah_id = $_POST['mata_kuliah_id'];
    $ruangan_id = $_POST['ruangan_id'];
    $dosen_id = $_POST['dosen_id'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    $stmt = $pdo->prepare("UPDATE jadwal SET mata_kuliah_id = ?, ruangan_id = ?,dosen_id = ? , hari = ?, jam_mulai = ?, jam_selesai = ? WHERE id = ?");
    $stmt->execute([$mata_kuliah_id, $ruangan_id,  $dosen_id, $hari, $jam_mulai, $jam_selesai, $id]);
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM jadwal WHERE id = ?");
    $stmt->execute([$id]);
}

// Read
$stmt = $pdo->prepare("
    SELECT jadwal.id, mata_kuliah.nama_matkul, ruangan.nama_ruangan, dosen.nama_dosen, jadwal.hari, jadwal.jam_mulai, jadwal.jam_selesai 
    FROM jadwal 
    JOIN mata_kuliah ON jadwal.mata_kuliah_id = mata_kuliah.id 
    JOIN ruangan ON jadwal.ruangan_id = ruangan.id 
    JOIN dosen ON jadwal.dosen_id = dosen.id
");
$stmt->execute();
$jadwal_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$matkul_stmt = $pdo->prepare("SELECT id, nama_matkul FROM mata_kuliah");
$matkul_stmt->execute();
$matkul_result = $matkul_stmt->fetchAll(PDO::FETCH_ASSOC);

$ruangan_stmt = $pdo->prepare("SELECT id, nama_ruangan FROM ruangan");
$ruangan_stmt->execute();
$ruangan_result = $ruangan_stmt->fetchAll(PDO::FETCH_ASSOC);

$dosen_stmt = $pdo->prepare("SELECT id, nama_dosen FROM dosen");
$dosen_stmt->execute();
$dosen_result = $dosen_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal Kuliah - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Kelola Jadwal Kuliah</h1>
        
        <!-- Form Create -->
        <form method="POST" class="mb-6">
            <div class="mb-4">
                <label for="mata_kuliah_id" class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                <select name="mata_kuliah_id" id="mata_kuliah_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php foreach ($matkul_result as $matkul): ?>
                        <option value="<?php echo $matkul['id']; ?>"><?php echo $matkul['nama_matkul']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="ruangan_id" class="block text-sm font-medium text-gray-700">Ruangan</label>
                <select name="ruangan_id" id="ruangan_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php foreach ($ruangan_result as $ruangan): ?>
                        <option value="<?php echo $ruangan['id']; ?>"><?php echo $ruangan['nama_ruangan']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="dosen_id" class="block text-sm font-medium text-gray-700">Dosen</label>
                <select name="dosen_id" id="dosen_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <?php foreach ($dosen_result as $dosen): ?>
                        <option value="<?php echo $dosen['id']; ?>"><?php echo $dosen['nama_dosen']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
                <select name="hari" id="hari" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="jam_selesai" class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <button type="submit" name="create" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Tambah Jadwal</button>
        </form>

        <!-- Table Read -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Mata Kuliah</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Ruangan</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Dosen</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Hari</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Jam Mulai</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Jam Selesai</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jadwal_result as $row): ?>
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_matkul']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_ruangan']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['nama_dosen']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['hari']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['jam_mulai']; ?></td>
                        <td class="px-6 py-4 border-b border-gray-300"><?php echo $row['jam_selesai']; ?></td>
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
            $stmt = $pdo->prepare("SELECT * FROM jadwal WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <form method="POST" class="mt-6">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-4">
                    <label for="mata_kuliah_id" class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                    <select name="mata_kuliah_id" id="mata_kuliah_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <?php foreach ($matkul_result as $matkul): ?>
                            <option value="<?php echo $matkul['id']; ?>" <?php echo ($matkul['id'] == $row['mata_kuliah_id']) ? 'selected' : ''; ?>><?php echo $matkul['nama_matkul']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="ruangan_id" class="block text-sm font-medium text-gray-700">Ruangan</label>
                    <select name="ruangan_id" id="ruangan_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <?php foreach ($ruangan_result as $ruangan): ?>
                            <option value="<?php echo $ruangan['id']; ?>" <?php echo ($ruangan['id'] == $row['ruangan_id']) ? 'selected' : ''; ?>><?php echo $ruangan['nama_ruangan']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="dosen_id" class="block text-sm font-medium text-gray-700">Dosen</label>
                    <select name="dosen_id" id="dosen_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <?php foreach ($dosen_result as $dosen): ?>
                            <option value="<?php echo $dosen['id']; ?>" <?php echo ($dosen['id'] == $row['dosen_id']) ? 'selected' : ''; ?>><?php echo $dosen['nama_dosen']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
                    <select name="hari" id="hari" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="Senin" <?php echo ($row['hari'] == 'Senin') ? 'selected' : ''; ?>>Senin</option>
                        <option value="Selasa" <?php echo ($row['hari'] == 'Selasa') ? 'selected' : ''; ?>>Selasa</option>
                        <option value="Rabu" <?php echo ($row['hari'] == 'Rabu') ? 'selected' : ''; ?>>Rabu</option>
                        <option value="Kamis" <?php echo ($row['hari'] == 'Kamis') ? 'selected' : ''; ?>>Kamis</option>
                        <option value="Jumat" <?php echo ($row['hari'] == 'Jumat') ? 'selected' : ''; ?>>Jumat</option>
                        <option value="Sabtu" <?php echo ($row['hari'] == 'Sabtu') ? 'selected' : ''; ?>>Sabtu</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" value="<?php echo $row['jam_mulai']; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="jam_selesai" class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" value="<?php echo $row['jam_selesai']; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <button type="submit" name="update" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update Jadwal</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>