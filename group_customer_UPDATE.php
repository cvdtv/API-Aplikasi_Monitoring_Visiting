<?php

    require_once('koneksi.php');

    $iddevice = "";
    if (isset($_POST['iddevice'])) $iddevice=$_POST['iddevice'];
    $cekakses = "select * from sales where iddevice='$iddevice'";
    $cr = mysqli_query($con, $cekakses);
    $result=array();
    if (mysqli_num_rows($cr)==0){

        mysqli_close($con);
        echo "Anda Tidak Punya Akses!!!";
        return;

    }else{

        if($_SERVER['REQUEST_METHOD']=='POST'){

            //Mendapatkan Nilai Variable
            $nama = "";
            $alamat = "";
            $nptelp ="";
            $nohp = "";

            $id = $_POST['idgroup_customer'];
            $nama = str_replace(',','\,', $_POST['nama']);
            $alamat = str_replace(',','\,', $_POST['alamat']);
            $notelp = $_POST['notelp'];
            $nohp = $_POST['nohp'];
     
            //Pembuatan Syntax SQL
            $sql = "UPDATE group_customer set nama='$nama', alamat='$alamat', notelp='$notelp', nohp='$nohp' where idgroup_customer='$id';";
             
            //Eksekusi Query database
            if(mysqli_query($con,$sql)){
                // echo $sql;
                echo 'Berhasil Menambahkan Customer - '.mysqli_insert_id($con);
            }else{
            echo $sql;
              echo 'Gagal Menambahkan Customer';
            }
             // echo $sql;
            mysqli_close($con);
        }
    }
?>
