<?php 
session_start();
if(isset($_SESSION['login'])) :
    echo "<script>window.location.href = 'login.php';</script>";
endif;

require 'functions.php';

$id = $_GET['id'];

if( hapus($id) > 0 ) {
    echo "<script> confirm('Data berhasil dihapus!');
    document.location.href = 'index.php'; </script>";
}else{
    echo "<script> alert('Data gagal dihapus!');
    document.location.href = 'index.php'; </script>";
}

?>