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
            $contact_person = "";
            $hp = "";
            $sales = "";
            $jenis = "";
            $ts = "";
            $lat = "";
            $lang = "";

            $nama = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $telp = $_POST['telp'];
            $contact_person = $_POST['contact_person'];
            $hp = $_POST['hp'];
            $sales = $_POST['idsales'];
            $jenis = $_POST['idjenis_toko'];
            $ts = $_POST['idts'];
            $lat = $_POST['latitude'];
            $lang = $_POST['longitude'];
	    $idgroup_customer = $_POST['idgroup_customer']; 

            //Pembuatan Syntax SQL
            $sql = "INSERT INTO master_customer (nama, alamat, telp, contact_person, hp, idsales, idjenis_toko, timestamp, idts, latitude, longitude, idgroup_customer) VALUES 
            ('$nama', '$alamat', '$telp', '$contact_person', '$hp', '$sales', '$jenis', now(), '$ts', '$lat', '$lang', '$idgroup_customer');";
             
            
             
            //Eksekusi Query database
            if(mysqli_query($con,$sql)){
                $cekkunjungan = "select idtransaksi_kunjungan from transaksi_kunjungan where idvisitor='$sales' and end_at='2000-01-01 00:00:01' limit 1";
                // echo $sql;
                echo 'Berhasil Menambahkan Customer - '.mysqli_insert_id($con)." - ".mysqli_num_rows(mysqli_query($con, $cekkunjungan));
            }else{
            echo $sql;
              echo 'Gagal Menambahkan Customer';
            }
             // echo $sql;
            mysqli_close($con);
        }
    }
?>
