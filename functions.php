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
  $gambar = htmlspecialchars($data['gambar']);

  $query = "INSERT INTO mahasiswa VALUES 
  ('','$nama','$nrp','$email','$jurusan','$gambar')";

  mysqli_query($conn,$query);

  return mysqli_affected_rows($conn);

}

function hapus($id){
   global $conn;
   mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id ");
   return mysqli_affected_rows($conn);
}

function ubah($data){
   global $conn;
   
   $id = $data['id'];
  $nrp = htmlspecialchars($data['nrp']);
  $nama = htmlspecialchars($data['nama']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $email = htmlspecialchars($data['email']);
  $gambar = htmlspecialchars($data['gambar']);

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

?>