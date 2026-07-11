<?php
include 'config/koneksi.php';


$kd_poli_list = ['U0001']; 


$in = "'" . implode("','", $kd_poli_list) . "'";

$sql = "
SELECT
    a.no_rawat,
    a.kd_poli,
    a.kd_dokter,
    rp.no_reg,
    p.nm_pasien,
    pl.nm_poli
FROM antripoli a
INNER JOIN reg_periksa rp ON rp.no_rawat = a.no_rawat
INNER JOIN pasien p ON p.no_rkm_medis = rp.no_rkm_medis
INNER JOIN poliklinik pl ON pl.kd_poli = rp.kd_poli
WHERE a.status = '1'
AND TRIM(rp.kd_poli) IN ($in)
ORDER BY a.no_rawat ASC
";

$query = mysqli_query($koneksi, $sql);

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);