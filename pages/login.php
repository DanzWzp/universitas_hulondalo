<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data pengguna dari database menggunakan PDO
    try {
        
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Simpan data pengguna ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['prodi_id'] = $prodi_id;

            // Redirect ke dashboard sesuai role
            switch ($user['role']) {
                case 'admin':
                    header('Location: /universitas_hulondalo/pages/admin/index.php');
                    break;
                case 'prodi':
                    header('Location: /universitas_hulondalo/pages/prodi/index.php');
                    break;
                case 'dosen':
                    header('Location: /universitas_hulondalo/pages/dosen/index.php');
                    break;
                case 'mahasiswa':
                    header('Location: /universitas_hulondalo/pages/mahasiswa/index.php');
                    break;
                default:
                    header('Location: /universitas_hulondalo/index.php');
                    break;
            }
            exit();
        } else {
            $error = "Username atau password salah.";
        }
    } catch (PDOException $e) {
        $error = "Terjadi kesalahan saat login. Silakan coba lagi. Error: " . $e->getMessage();
    }

    if (!isset($_SESSION['prodi_id'])) {
        header('Location: /path/to/login.php'); // Redirect ke halaman login
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Universitas Hulondalo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Login</button>
        </form>
        <div class="mt-4 text-center">
            <p class="text-gray-600">Belum punya akun? <a href="/universitas_hulondalo/pages/signup.php" class="text-indigo-600 hover:text-indigo-900">Signup</a></p>
        </div>
    </div>
</body>
</html>