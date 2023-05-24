<?php 

// koneksi ke databases
$conn = mysqli_connect("localhost","root","","phpdasar");//mysqli_connect(host,username,password,nama database)

function query($query){
    global $conn;
 $result = mysqli_query( $conn,$query);
 $rows = [];
 while($row = mysqli_fetch_assoc($result)){
    $rows[]= $row;
 }
 return $rows;
}

function tambah($data){
  
   global $conn;
  $nrp = htmlspecialchars($data['nrp']);
  $nama = htmlspecialchars($data['nama']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $email = htmlspecialchars($data['email']);

  // Upload Gambar
  $gambar = upload();
  if (!$gambar){
   return false;
  }

  $query = "INSERT INTO mahasiswa VALUES 
  ('','$nama','$nrp','$email','$jurusan','$gambar')";

  mysqli_query($conn,$query);

  return mysqli_affected_rows($conn);

}

function upload(){

   $namaFile = $_FILES['gambar']['name'];
   $ukuranFile = $_FILES['gambar']['size'];
   $error = $_FILES['gambar']['error'];
   $tmpName = $_FILES['gambar']['tmp_name'];

   // cek apakah tidak ada gambar yang di upload

   if($error === 4){
      echo "<script> 
      alert('Pilih Gambar Terlebih dahulu!')
       </script>";
       return false;
   }

   // cek apakah yang di upload adalah gambar
   $ekstensiGambarValid = ['jpg','jpeg','png'];
   $ekstensiGambar = explode('.', $namaFile);
   $ekstensiGambar = strtolower(end($ekstensiGambar));

   if(!in_array($ekstensiGambar,$ekstensiGambarValid)){
      echo "<script> 
      alert('Yang anda Upload Bukan Gambar!')
       </script>";
       return false;
   }

   // cek jika ukurannya terlalu besar
   if($ukuranFile > 1000000){
      echo "<script> 
      alert('Ukuran Gambar Terlalu Besar!')
       </script>";
       return false;
   }

   //lolos pengecekan gambar siap diupload!
   // generate nama gambar baru

   $namaFileBaru = uniqid();
   $namaFileBaru .= ".";
   $namaFileBaru .= $ekstensiGambar;


   move_uploaded_file($tmpName,'img/'. $namaFileBaru);

   return $namaFileBaru;

}

function hapus($id){
   global $conn;
   mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id ");
   return mysqli_affected_rows($conn);
}

function ubah($data){
   global $conn;
   
   $id      = $data['id'];
  $nrp      = htmlspecialchars($data['nrp']);
  $nama     = htmlspecialchars($data['nama']);
  $jurusan  = htmlspecialchars($data['jurusan']);
  $email    = htmlspecialchars($data['email']);
$gambarLama = htmlspecialchars($data['gambarLama']);

//cek apakah user pilih gambar baru / tidak
   if($_FILES['gambar']['error'] === 4){
      $gambar = $gambarLama;
   }else{
      $gambar = upload();
   }

  $query = "UPDATE mahasiswa SET 
               nama = '$nama',
               nrp = '$nrp',
               jurusan = '$jurusan',
               email = '$email',
               gambar = '$gambar'

               WHERE id = $id
  ";

  mysqli_query($conn,$query);

  return mysqli_affected_rows($conn);
} 

function cari($keyword){
   $query = "SELECT * FROM mahasiswa
   WHERE
   nama LIKE '%$keyword%' OR
   nrp LIKE '%$keyword%' OR
   email LIKE '%$keyword%' OR
   jurusan LIKE '%$keyword%'
   ";
   return query($query);
}

function registrasi($data){
   global $conn;

   $username = strtolower(stripslashes($data['username']));
   $password = mysqli_real_escape_string($conn, $data['password']);
   $password2 = mysqli_real_escape_string($conn, $data['password2']);

   if($password !== $password2){
      echo "<script> 
      alert('Konfirmasi password tidak sesuai!')
            </script>";
            return false;
   }
   // cek username sudah ada / belum
   $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' ");
   if(mysqli_fetch_assoc($result)){
      echo "<script> 
         alert('Username Sudah Terdaftar')
      </script>";
      return false;
   }
   // encripsi password
   $password = password_hash($password, PASSWORD_DEFAULT);
 
   
   // tambahkan user baru ke database
   mysqli_query($conn, "INSERT INTO user VALUES('','$username','$password')");

   return mysqli_affected_rows($conn);
}

?>