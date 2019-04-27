<?php
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 //$idtransaksi = "";
 //$jenis = "kunjungan";

 $image = $_POST['foto'];
 //$idtransaksi = $_POST['idtransaksi'];
 //$jenis = $_POST['jenis'];

 require_once('koneksi.php');
 
 $sql ="SELECT max(idfoto) as maxid FROM foto";
 
 $res = mysqli_query($con,$sql);
 
 $id = 0;
 
 while($row = mysqli_fetch_array($res)){
 $id = $row['maxid']+1;
 }
 
 $path = "foto/$id.jpg";
 
 $actualpath = "http://localhost/android/visiting/$path";
 
 $sql = "INSERT INTO foto (path1) VALUES ('$actualpath')";
 
 if(mysqli_query($con,$sql)){
 file_put_contents($path,base64_decode($image));
 echo "Successfully Uploaded";
 }
 
 mysqli_close($con);
 }else{
 echo "Error";
 }