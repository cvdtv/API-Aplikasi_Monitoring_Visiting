<?php 
  
    require_once('koneksi.php');

    // $iddevice = "10459713-e19f-4233-ad0f-ab880a2b8fcc";
    // if (isset($_POST['iddevice'])) $iddevice=$_POST['iddevice'];
    // $cekakses = "select * from sales where iddevice='$iddevice'";
    // $cr = mysqli_query($con, $cekakses);
    // $result=array();
    // if (mysqli_num_rows($cr)==0){

    //     mysqli_close($con);
    //     echo "Anda Tidak Punya Akses!!!";
    //     return;

    // }else{

        $jabatan = "spv";
        $idsales = "";
        $sql = "";
        $idcustomer = "";
        $valuefilter = "1";
        $filter = "editcustomer";

        if (isset($_POST['idsales'])) $idsales = $_POST['idsales'];
        if (isset($_POST['jabatan'])) $jabatan = $_POST['jabatan'];

    //POST ID MASTER CUSTOMER
        if (isset($_POST['idgroup_customer'])) $idgroup_customer = $_POST['idgroup_customer'];
        if (isset($_POST['valuefilter'])) $valuefilter = $_POST['valuefilter'];

        $strfilter = "";
        $filter = "";
        if(isset($_POST['filter']))
        {
            $filter = $_POST['filter'];
            if($filter=="editcustomer")
            {
                $strfilter = " where a.idgroup_customer=".$valuefilter;
            }
        }

        if ($filter == "editcustomer") {
            $sql = "SELECT * FROM group_customer a".$strfilter;

            $r = mysqli_query($con, $sql);
            $result = array();
            
            while($row = mysqli_fetch_array($r)){
                array_push($result, array(
                "idgroup_customer"=>$row['idgroup_customer'],
                "nama"=>$row['nama'],
                "alamat"=>$row['alamat'],
                "notelp"=>$row['notelp'],
                "nohp"=>$row['nohp']
                ));
            }

        }
    //END POST ID MASTER CUSTOMER
        else
        {
            if($jabatan=="spv")
            {
                $sql = "SELECT * FROM group_customer;";
            }
            
            else if($jabatan=="sales")
            {
                $sql = "SELECT * FROM group_customer;";
            }
            
            else if($jabatan=="ts")
            {
                $sql = "SELECT * FROM group_customer;";
            }

            $r = mysqli_query($con, $sql);
             
            //Membuat Array Kosong 
            $result = array();
             
            while($row = mysqli_fetch_array($r)){
                 
                //Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
                array_push($result,array(
                    "idgroup_customer"=>$row['idgroup_customer'],
                    "nama"=>$row['nama'],
                    "alamat"=>$row['alamat'],
                    "notelp"=>$row['notelp'],
                    "nohp"=>$row['nohp']
                ));
            }
        }
         
        //Menampilkan Array dalam Format JSON
        echo json_encode(array('result'=>$result));
        // echo  $sql;
        mysqli_close($con);
    // }
 
?>
