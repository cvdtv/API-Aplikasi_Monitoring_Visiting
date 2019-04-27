<?php 
  
    require_once('koneksi.php');

   $iddevice = "5313f2c8-039a-4a0b-a6af-fd299ebf518c";
    if (isset($_POST['iddevice'])) $iddevice=$_POST['iddevice'];
    $cekakses = "select * from sales where iddevice='$iddevice'";
    $cr = mysqli_query($con, $cekakses);
    $result=array();
    if (mysqli_num_rows($cr)==0){

        mysqli_close($con);
        echo "Anda Tidak Punya Akses!!!";
        return;

    }else{

        $jabatan = "spv";
        $idsales = "26";
        $sql = "";
        $idcustomer = "";
        $valuefilter = "";
        $filter = "";

        if (isset($_POST['idsales'])) $idsales = $_POST['idsales'];
        if (isset($_POST['jabatan'])) $jabatan = $_POST['jabatan'];

    //POST ID MASTER CUSTOMER
        if (isset($_POST['idmaster_customer'])) $idmaster_customer = $_POST['idmaster_customer'];
        if (isset($_POST['valuefilter'])) $valuefilter = $_POST['valuefilter'];

        $strfilter = "";
 //       $filter = "";
        if(isset($_POST['filter']))
        {
            $filter = $_POST['filter'];
            if($filter=="editcustomer")
            {
                $strfilter = " AND a.idmaster_customer=".$valuefilter;
            }
        }

        $rk = 0;
        if($valuefilter!="")
        {
            $cekkunjungan = "select * from transaksi_kunjungan where selesai=0 and idvisitor='' and idmaster_customer=$valuefilter";
            $r = mysqli_query($con, $cekkunjungan);
            if (mysqli_num_rows($r)==0) $rk = 1;
        }

        if ($filter == "editcustomer") {
            $sql = "SELECT a.*, b.idjenis_toko, b.nama as jenis_toko, IFNULL((SELECT nama FROM sales WHERE sales.idsales=a.idsales), '') AS sales, IFNULL((SELECT nama FROM  sales WHERE sales.idsales=a.idts), '') AS ts, gc.nama as namacus, a.idgroup_customer FROM master_customer a, jenis_toko b, group_customer gc WHERE a.idjenis_toko=b.idjenis_toko and gc.idgroup_customer=a.idgroup_customer".$strfilter;

            $r = mysqli_query($con, $sql);
            $result = array();
            if (mysqli_num_rows($r)==0) {
                array_push($result, array(
                    "idmaster_customer"=>"",
                    "nama"=>"",
                    "alamat"=>"",
                    "telp"=>"",
                    "contact_person"=>"",   
                    "hp"=>"",
                    "idjenis_toko"=>"",
                    "jenis_toko"=>"",
                    "idsales"=>"",
                    "sales"=>"",
                    "idts"=>"",
                    "ts"=>"",
                    "latitude"=>"",
                    "longitude"=>"",
                    "rk"=>"",
                    "namacus" => "",
                    "idgroup_customer"=>"",
                ));
            }
            else
            {
                while($row = mysqli_fetch_array($r)){
                    array_push($result, array(
                        
                    "idmaster_customer"=>$row['idmaster_customer'],
                    "nama"=>$row['nama'],
                    "alamat"=>$row['alamat'],
                    "telp"=>$row['telp'],
                    "contact_person"=>$row['contact_person'],   
                    "hp"=>$row['hp'],
                    "idjenis_toko"=>$row['idjenis_toko'],
                    "jenis_toko"=>$row['jenis_toko'],
                    "idsales"=>$row['idsales'],
                    "sales"=>$row['sales'],
                    "idts"=>$row['idts'],
                    "ts"=>$row['ts'],
                    "latitude"=>$row['latitude'],
                    "longitude"=>$row['longitude'],
                    "rk"=>$rk,
                    "namacus" => $row['namacus'],
                    "idgroup_customer" => $row['idgroup_customer']
                    ));
                }
            }
        }
    //END POST ID MASTER CUSTOMER
        else
        {
            if($jabatan=="spv")
            {
                $sql = "SELECT mc.idmaster_customer, mc.nama, mc.alamat, mc.idsales, IFNULL((SELECT nama FROM sales WHERE sales.idsales=mc.idsales), '') AS sales, IFNULL((SELECT nama FROM  sales WHERE sales.idsales=mc.idts), '') AS ts, mc.idts as idts, jt.nama as jenis_toko, gc.nama as namacus, mc.idgroup_customer FROM master_customer mc, sales, jenis_toko jt, group_customer gc where (mc.idsales=sales.idsales or mc.idts=sales.idsales) and jt.idjenis_toko=mc.idjenis_toko and gc.idgroup_customer=mc.idgroup_customer GROUP BY idmaster_customer order by mc.nama;";
            }
            
            else if($jabatan=="sales")
            {
                $sql = "SELECT mc.idmaster_customer as idmaster_customer, mc.nama as nama, mc.alamat as alamat, jt.nama as jenis_toko, mc.idsales as idsales, IFNULL((SELECT nama FROM sales WHERE sales.idsales=mc.idsales), '') AS sales, IFNULL((SELECT nama FROM  sales WHERE sales.idsales=mc.idts), '') AS ts, mc.idts as idts, gc.nama as namacus, mc.idgroup_customer from master_customer mc, sales, jenis_toko jt, group_customer gc where mc.idsales='$idsales' and jt.idjenis_toko=mc.idjenis_toko and mc.idsales=sales.idsales and gc.idgroup_customer=mc.idgroup_customer order by mc.nama;";
            }
            
            else if($jabatan=="ts")
            {
                $sql = "SELECT mc.idmaster_customer as idmaster_customer, mc.nama as nama, mc.alamat as alamat, mc.idsales as idsales, IFNULL((SELECT nama FROM sales WHERE sales.idsales=mc.idsales), '') AS sales, IFNULL((SELECT nama FROM  sales WHERE sales.idsales=mc.idts), '') AS ts, mc.idts as idts, jt.nama as jenis_toko, gc.nama as namacus, mc.idgroup_customer FROM master_customer mc, sales, jenis_toko jt, group_customer gc where mc.idts='$idsales' and jt.idjenis_toko=mc.idjenis_toko and mc.idts=sales.idsales and gc.idgroup_customer=mc.idgroup_customer order by mc.nama;";
            }

            $r = mysqli_query($con, $sql);
             
            //Membuat Array Kosong 
            $result = array();
             
            while($row = mysqli_fetch_array($r)){
                 
                //Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
                array_push($result,array(
                    "idmaster_customer" => $row['idmaster_customer'],
                    "nama"=> $row['nama'],
                    "alamat"=>$row['alamat'],
                    "idsales"=>$row['idsales'],
                    "sales"=>$row['sales'],
                    "ts"=>$row['ts'],
                    "idts"=>$row['idts'],
                    "jenis_toko"=>$row['jenis_toko'],
                    "namacus" => $row['namacus'],
                    "idgroup_customer" => $row['idgroup_customer']
                ));
            }
        }
         
        //Menampilkan Array dalam Format JSON
        echo json_encode(array('result'=>$result));
	
//        echo $jabatan.$sql;
        mysqli_close($con);
    }
 
?>
