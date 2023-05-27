<?php 
// mulai session
session_start();

if(!isset($_SESSION['login'])){ // jika belum login maka balikan ke halaman login.php
    header('Location: login.php');
    exit;
}

require 'functions.php'; // memanggil file functions
// Pagination
// Konfigurasi
$jumlahDataPerHalaman = 3;
$jumlahData = count(query("SELECT * FROM mahasiswa"));// jumlah seluruh data
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
// round = untuk membulatkan data ke bilangan bulat terdekat
// floor = untuk membulatkan data ke bilangan bulat kebawah
// ceil = untuk membulatkan data ke bilangan bulat keatas
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");// LIMIT untuk membatasi data yang di tampilkan

//jika button cari di tekan maka hilangkan pagination
if(isset($_POST['cari'])){
    $jumlahHalaman = false;
    
}

// ketika tombol cari ditekan
if(isset($_POST['cari'])){
    $mahasiswa = cari($_POST['keyword']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
    <a href="logout.php" style="text-align : right;">Logout</a>
    <h1>Daftar Mahasiswa</h1>
   
    <a href="tambah.php">Tambah</a><br><br>
        <form action="" method="post">
            <input type="text" name="keyword" size="40" autofocus placeholder="Masukan Keyword..." autocomplete="off">
                <button type="submit" name="cari" >Cari</button>
        </form>
        <br>
        <br>
       <!-- Navigasi -->
       <?php if($halamanAktif > 1): ?> 
       <a href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
       <?php endif; ?>

       <?php for($i =1; $i <= $jumlahHalaman; $i++) : ?>
            <?php if($i == $halamanAktif) : ?>
                <a href="?halaman=<?= $i; ?>" style="font-weight: bold ; color: red;"><?= $i; ?></a>
            <?php else : ?>
                <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
        <?php endif; ?>
        <?php endfor; ?>

        <?php if($halamanAktif < $jumlahHalaman): ?> 
       <a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
       <?php endif; ?>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>gambar</th>
            <th>NRP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>
<?php $i = 1; ?>
        <?php foreach($mahasiswa as $mhs) : ?>
           
        <tr>
            <td><?= $i; ?></td>
            <td>
                <a href="ubah.php?id=<?= $mhs['id'] ?>">Edit</a> 
                <a href="hapus.php?id=<?= $mhs['id'] ?>" onclick="return confirm('Apakah anda Yakin?')">Delete</a>
            </td>
            <td><img src="img/<?= $mhs['gambar'] ?>" width="50" alt=""></td>
            <td><?= $mhs['nrp']; ?></td>
            <td><?= $mhs['nama']; ?></td>
            <td><?= $mhs['email']; ?></td>
            <td><?= $mhs['jurusan']; ?></td>
        </tr>
        <?php $i++ ?>
        <?php endforeach; ?>
    </table>


</body>
</html>