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
            $telp ="";
            $hp = "";

            $nama = str_replace(',','\,', $_POST['nama']);
            $alamat = str_replace(',','\,', $_POST['alamat']);
            $telp = $_POST['telp'];
            $hp = $_POST['hp'];
     
            //Pembuatan Syntax SQL
            $sql = "INSERT INTO group_customer (nama, alamat, notelp, nohp, timestamp) VALUES ('$nama', '$alamat', '$telp', '$hp', now());";
             
            //Eksekusi Query database
            if(mysqli_query($con,$sql)){
                // echo $sql;
                echo 'Berhasil Menambahkan Customer';
            }else{
            echo $sql;
              echo 'Gagal Menambahkan Customer';
            }
             // echo $sql;
            mysqli_close($con);
        }
    }
?>
