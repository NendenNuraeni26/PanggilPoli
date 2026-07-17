<?php

$host     = "localhost";
$user     = "root";
$password = "Uban";
$database = "asdf";

$koneksi = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$koneksi) {
    die("Koneksi gagal : " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8");
