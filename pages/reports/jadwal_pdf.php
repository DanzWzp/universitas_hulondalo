<?php
require '../../vendor/autoload.php';
use Dompdf\Dompdf;

include '../../includes/db.php'; // Pastikan file ini sudah menggunakan PDO
include '../../includes/auth.php';

// Redirect jika tidak login
if (!isLoggedIn()) {
    header('Location: /universitas_hulondalo/pages/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Ambil data jadwal berdasarkan role
try {
    if ($role == 'mahasiswa') {
        $sql = "
            SELECT jadwal.id, mata_kuliah.nama_matkul, ruangan.nama_ruangan, jadwal.hari, jadwal.jam_mulai, jadwal.jam_selesai 
            FROM jadwal 
            JOIN mata_kuliah ON jadwal.mata_kuliah_id = mata_kuliah.id 
            JOIN ruangan ON jadwal.ruangan_id = ruangan.id 
            JOIN nilai ON mata_kuliah.id = nilai.mata_kuliah_id 
            
        ";
    } elseif ($role == 'dosen') {
        $sql = "
            SELECT jadwal.id, mata_kuliah.nama_matkul, ruangan.nama_ruangan, jadwal.hari, jadwal.jam_mulai, jadwal.jam_selesai 
            FROM jadwal 
            JOIN mata_kuliah ON jadwal.mata_kuliah_id = mata_kuliah.id 
            JOIN ruangan ON jadwal.ruangan_id = ruangan.id 
           
        ";
    } else {
        // Redirect jika role tidak valid
        header('Location: /universitas_hulondalo');
        exit();
    }

    // Siapkan dan eksekusi query
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Buat HTML untuk PDF
    $html = '<h1 style="text-align: center; font-size: 24px; margin-bottom: 20px;">Jadwal Kuliah</h1>';
    $html .= '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
    $html .= '<tr>
                <th style="background-color: #f3f4f6; font-weight: bold;">Mata Kuliah</th>
                <th style="background-color: #f3f4f6; font-weight: bold;">Ruangan</th>
                <th style="background-color: #f3f4f6; font-weight: bold;">Hari</th>
                <th style="background-color: #f3f4f6; font-weight: bold;">Jam Mulai</th>
                <th style="background-color: #f3f4f6; font-weight: bold;">Jam Selesai</th>
              </tr>';

    // Fetch data dan tambahkan ke HTML
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['nama_matkul']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_ruangan']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['hari']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['jam_mulai']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['jam_selesai']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    // Generate PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("jadwal_kuliah.pdf", array("Attachment" => false));
} catch (PDOException $e) {
    // Tangani error database
    echo "Error: " . $e->getMessage();
}
?>