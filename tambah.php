<?php 
// mulai session
session_start();

if(!isset($_SESSION['login'])){ // jika belum login maka balikan ke halaman login.php
    header('Location: login.php');
    exit;
}
// koneksi databases
require "functions.php";

//cek apakah tombol submit sudah di tekan / belum
if(isset($_POST["submit"])){
    // ambil data dari tiap elemen di form
   
    //query insert data
  

    // cek apakah data berhasil di tambahkan / tidak
   if(tambah($_POST) > 0 ){
     echo "<script> alert('Data berhasil di tambahakan!');
     document.location.href = 'index.php'; </script>";
   } else {
    echo "<script> alert('Data gagal di tambahkan!') </script>";
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nrp">NRP :</label>
                    <input type="text" name="nrp" id="nrp" required>
            </li>
            <li>
                <label for="nama">Nama :</label>
                    <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="email">Email :</label>
                    <input type="text" name="email" id="email" required>
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                    <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li>
                <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" id="gambar" >
            </li>
            <li>
                <button type="submit" name="submit">Tambahkan!</button>
            </li>
        </ul>
    </form>
    <a href="index.php">Kembali</a>

</body>
</html>