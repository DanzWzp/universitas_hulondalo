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

// Ambil data KRS berdasarkan role
try {
    if ($role == 'mahasiswa') {
        $sql = "
            SELECT mata_kuliah.nama_matkul, prodi.nama_prodi 
            FROM nilai 
            JOIN mata_kuliah ON nilai.mata_kuliah_id = mata_kuliah.id 
            JOIN prodi ON mata_kuliah.prodi_id = prodi.id 
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
    $html = '<h1 style="text-align: center; font-size: 24px; margin-bottom: 20px;">Kartu Rencana Studi (KRS)</h1>';
    $html .= '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
    $html .= '<tr>
                <th style="background-color: #f3f4f6; font-weight: bold;">Mata Kuliah</th>
                <th style="background-color: #f3f4f6; font-weight: bold;">Program Studi</th>
              </tr>';

    // Fetch data dan tambahkan ke HTML
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['nama_matkul']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_prodi']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    // Generate PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("krs.pdf", array("Attachment" => false));
} catch (PDOException $e) {
    // Tangani error database
    echo "Error: " . $e->getMessage();
}
?>