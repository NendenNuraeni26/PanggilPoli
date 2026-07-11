<?php
include 'config/koneksi.php';

$no_rawat = $_POST['no_rawat'];

$sql = "
UPDATE antripoli
SET status = '2'
WHERE no_rawat = '$no_rawat'
";

mysqli_query($koneksi, $sql);

echo json_encode([
    "success" => true
]);