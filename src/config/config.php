<?php
$config = mysqli_connect("localhost", "root", "", "colbase");
if (!$config) {
    die("Gagal terhubung ke MySQLi : " . mysqli_connect_error());
}
