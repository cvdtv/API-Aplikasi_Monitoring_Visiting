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

        $jabatan = "";
        // $idsales = "";
        $sql = "";
        $jenisproduk = "";
        $filter = "";
        $keysales = "";

        // if (isset($_POST['idsales'])) $idsales = $_POST['idsales'];
        if (isset($_POST['jabatan'])) $jabatan = $_POST['jabatan'];
        if (isset($_POST['jenisproduk'])) $jenisproduk = $_POST['jenisproduk'];
        if (isset($_POST['keysales'])) $keysales = $_POST['keysales'];
        if (isset($_POST['filter'])) $filter = $_POST['filter'];

        $strsales = "";
        $strgrupsales = "";

        if(strtoupper($keysales)=="M"){
        
        }else{
            $strsales = " AND OP_SALES='$keysales'";
            $strgrupsales = ", OP_SALES";
        }

        if ($filter=="dashboard")
        {
         $sql = "SELECT '' as bulan, OP_SALES AS SALES, produk.JENIS, jenis_produk.NAMA, SUM(det_op.KUBIK) AS kubik, round(SUM(OP_NETTO+OP_PPN)/1000000,0) AS netto, count(op.OP_ID) as jumlahtransaksi FROM op, det_op, produk, jenis_produk WHERE op.OP_ID=det_op.OP_ID AND det_op.PV_ID=produk.PV_ID AND produk.JENIS=jenis_produk.ID AND YEAR(INV_TGL)=YEAR(NOW())".$strsales." and JENIS in ('001', '002', '003', '010', '011') GROUP BY produk.JENIS;";
        }
        else
        {
         $sql = "SELECT DATE_FORMAT(INV_TGL, '%m-%Y') AS bulan, OP_SALES AS SALES, produk.JENIS, jenis_produk.NAMA, SUM(det_op.KUBIK) AS kubik, SUM(OP_NETTO+OP_PPN) AS netto, count(op.OP_ID) as jumlahtransaksi, '' as JENIS FROM op, det_op, produk, jenis_produk WHERE op.OP_ID=det_op.OP_ID AND det_op.PV_ID=produk.PV_ID AND produk.JENIS=jenis_produk.ID AND YEAR(INV_TGL)=YEAR(NOW()) and produk.JENIS='$jenisproduk'".$strsales." GROUP BY DATE_FORMAT(INV_TGL, '%m-%Y')".$strgrupsales.", produk.JENIS;";

//         $sql = "SELECT CONCAT(MONTH(INV_TGL),'-',YEAR(INV_TGL)) AS bulan, OP_SALES AS SALES, produk.JENIS, jenis_produk.NAMA, SUM(det_op.KUBIK) AS kubik, SUM(OP_NETTO+OP_PPN) AS netto, count(op.OP_ID) as jumlahtransaksi, '' as JENIS FROM op, det_op, produk, jenis_produk WHERE op.OP_ID=det_op.OP_ID AND det_op.PV_ID=produk.PV_ID AND produk.JENIS=jenis_produk.ID AND YEAR(INV_TGL)=YEAR(NOW()) and produk.JENIS='$jenisproduk'".$strsales." GROUP BY CONCAT(MONTH(INV_TGL),'-',YEAR(INV_TGL))".$strgrupsales.", produk.JENIS;";
        }
        
        $r = mysqli_query($conGE, $sql);
        $result = array();
        if (mysqli_num_rows($r)==0) {
            array_push($result, array(
                "bulan"=>"",
                "kubik"=>"",
                "netto"=>"",
                "jumlahtransaksi"=>"",
                "jenis_produk"=>""
            ));
        }
        else
        {
            while($row = mysqli_fetch_array($r)){
                array_push($result, array(
                "bulan"=>$row['bulan'],
                "kubik"=>$row['kubik'],
                "netto"=>$row['netto'],
                "jumlahtransaksi"=>$row['jumlahtransaksi'],
                "jenis_produk"=>$row['JENIS']
                ));
            }
        }

        echo json_encode(array('result'=>$result));
        //echo  $sql;
        mysqli_close($conGE);
    }
 
?>
