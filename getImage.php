<?php
 require_once('koneksi.php');
 
 $sql = "select path1 from transaksi_kunjungan";
 
 $res = mysqli_query($con,$sql);
 
 $result = array();
 
 while($row = mysqli_fetch_array($res)){
 array_push($result,array('url'=>$row['path1']));
 }
 
 echo json_encode(array("result"=>$result));
 
 mysqli_close($con);