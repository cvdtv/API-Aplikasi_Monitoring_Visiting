<?php 
    require_once('koneksi.php');
// CEK ID DEVICE UNTUK BUKA PHP
    $iddevice = "10459713-e19f-4233-ad0f-ab880a2b8fcc";
    if (isset($_POST['iddevice'])) $iddevice=$_POST['iddevice'];
    $cekakses = "select * from sales where iddevice='$iddevice'";
    $cr = mysqli_query($con, $cekakses);
    $result=array();
    if (mysqli_num_rows($cr)==0){

        mysqli_close($con);
        echo "Anda Tidak Punya Akses!!!";
        return;

    }else{

      $idsales = "";
      $jabatan = "";
      $sql="";
      $sql1="";
      $strsales="";
      $keysales="";

      if(isset($_POST['idsales'])) $idsales = $_POST["idsales"];
      if(isset($_POST['jabatan'])) $jabatan = $_POST["jabatan"];
      if (isset($_POST['keysales'])) $keysales = $_POST['keysales'];
  //	$idsales="2";

            if(strtoupper($keysales)=="M"){        
      }else{
          $strsales = " AND OP_SALES='$keysales'";
          $strgrupsales = ", OP_SALES";
      }

	//kunjungan = after sales
      if($jabatan=="spv")
      {
        $sql = "SELECT idvisitor, count(idtransaksi_kunjungan) as KUNJUNGAN, ".
             "IFNULL(sum(case when idjenis_kunjungan=1 and selesai=1 then 1 else 0 end),0) BARU,".
             "IFNULL(sum(case when idjenis_kunjungan=2 and selesai=1 then 1 else 0 end),0) FOLLOWUP,".
             "IFNULL(sum(case when idjenis_kunjungan=3 and selesai=1 then 1 else 0 end),0) DEAL,".
             "IFNULL(sum(case when idjenis_kunjungan=4 and selesai=1 then 1 else 0 end),0) AFTERSALES,".
             "IFNULL(sum(case when idjenis_kunjungan>4 and selesai=1 then 1 else 0 end),0) OTHER,".
             "IFNULL(sum(case when tipe='TUGAS' and selesai=1 and idvisitor<>'' then 1 else 0 end),0) TUGASSELESAI,".
             "IFNULL(sum(case when tipe='TUGAS' and selesai=0 and idvisitor<>'' then 1 else 0 end),0) TUGASBELUM,".
             "IFNULL(sum(case when selesai=0 and idvisitor='' and tipe='TUGAS' then 1 else 0 end),0) REQUESTKUNJUNGAN".
             " from transaksi_kunjungan a";

         $sql1 = "SELECT '' as bulan, OP_SALES AS SALES, produk.JENIS, jenis_produk.NAMA, SUM(det_op.KUBIK) AS kubik, round(SUM(OP_NETTO+OP_PPN)/1000000,0) AS netto, count(op.OP_ID) as jumlahtransaksi FROM op, det_op, produk, jenis_produk WHERE op.OP_ID=det_op.OP_ID AND det_op.PV_ID=produk.PV_ID AND produk.JENIS=jenis_produk.ID AND YEAR(INV_TGL)=YEAR(NOW())".$strsales." and JENIS in ('001', '002', '003', '010', '011') GROUP BY produk.JENIS;";
      }
      else if($jabatan=="sales")
      {
        $sql = "SELECT idvisitor, KUNJUNGAN, BARU, FOLLOWUP, DEAL, AFTERSALES, OTHER, TUGASSELESAI, TUGASBELUM, REQUESTKUNJUNGAN FROM (select idvisitor, count(idtransaksi_kunjungan) as KUNJUNGAN, ".
             "IFNULL(sum(case when idjenis_kunjungan=1 and selesai=1 then 1 else 0 end),0) BARU,".
             "IFNULL(sum(case when idjenis_kunjungan=2 and selesai=1 then 1 else 0 end),0) FOLLOWUP,".
             "IFNULL(sum(case when idjenis_kunjungan=3 and selesai=1 then 1 else 0 end),0) DEAL,".
             "IFNULL(sum(case when idjenis_kunjungan=4 and selesai=1 then 1 else 0 end),0) AFTERSALES,".
             "IFNULL(sum(case when idjenis_kunjungan>4 and selesai=1 then 1 else 0 end),0) OTHER,".
             "IFNULL(sum(case when tipe='TUGAS' and selesai=1 and idvisitor<>'' then 1 else 0 end),0) TUGASSELESAI,".
             "IFNULL(sum(case when tipe='TUGAS' and selesai=0 and idvisitor<>'' then 1 else 0 end),0) TUGASBELUM, 0 as REQUESTKUNJUNGAN".
             " from transaksi_kunjungan a where a.idvisitor=$idsales)a";

         $sql1 = "SELECT '' as bulan, OP_SALES AS SALES, produk.JENIS, jenis_produk.NAMA, SUM(det_op.KUBIK) AS kubik, round(SUM(OP_NETTO+OP_PPN)/1000000,0) AS netto, count(op.OP_ID) as jumlahtransaksi FROM op, det_op, produk, jenis_produk WHERE op.OP_ID=det_op.OP_ID AND det_op.PV_ID=produk.PV_ID AND produk.JENIS=jenis_produk.ID AND YEAR(INV_TGL)=YEAR(NOW())".$strsales." and JENIS in ('001', '002', '003', '010', '011') GROUP BY produk.JENIS;";
      }
      else if($jabatan=="ts")
      {
        $sql = "SELECT idvisitor, AFTERSALES, BARU, FOLLOWUP, DEAL, KUNJUNGAN, OTHER, TUGASSELESAI, TUGASBELUM, REQUESTKUNJUNGAN FROM (select idvisitor, count(idtransaksi_kunjungan) as KUNJUNGAN, ".
             "IFNULL(sum(case when idjenis_kunjungan=1 and selesai=1 then 1 else 0 end),0) BARU,".
             "IFNULL(sum(case when idjenis_kunjungan=2 and selesai=1 then 1 else 0 end),0) FOLLOWUP,".
             "IFNULL(sum(case when idjenis_kunjungan=3 and selesai=1 then 1 else 0 end),0) DEAL,".
             "IFNULL(sum(case when idjenis_kunjungan=4 and selesai=1 then 1 else 0 end),0) AFTERSALES,".
             "IFNULL(sum(case when idjenis_kunjungan>4 and selesai=1 then 1 else 0 end),0) OTHER,".
             "IFNULL(sum(case when tipe='TUGAS' and selesai=1 and idvisitor<>'' then 1 else 0 end),0) TUGASSELESAI,".
             "IFNULL(sum(case when tipe='TUGAS' and selesai=0 and idvisitor<>'' then 1 else 0 end),0) TUGASBELUM, 0 as REQUESTKUNJUNGAN".
             " from transaksi_kunjungan a WHERE idvisitor=$idsales)a";

         $sql1 = "SELECT '' as bulan, OP_SALES AS SALES, produk.JENIS, jenis_produk.NAMA, SUM(det_op.KUBIK) AS kubik, round(SUM(OP_NETTO+OP_PPN)/1000000,0) AS netto, count(op.OP_ID) as jumlahtransaksi FROM op, det_op, produk, jenis_produk WHERE op.OP_ID=det_op.OP_ID AND det_op.PV_ID=produk.PV_ID AND produk.JENIS=jenis_produk.ID AND YEAR(INV_TGL)=YEAR(NOW())".$strsales." and JENIS in ('001', '002', '003', '010', '011') GROUP BY produk.JENIS;";
      }

      $r = mysqli_query($con, $sql);
      $result = array();

     if(mysqli_num_rows($r)==0){
        array_push($result,array(
          "KUNJUNGAN"=>0,
          "BARU"=>0,
          "FOLLOWUP"=>0,
          "DEAL"=>0,
          "TUGASSELESAI"=>0,
          "TUGASBELUM"=>0,
          "OTHER"=>0,          
          "REQUESTKUNJUNGAN"=>0,
          "AFTERSALES"=>0
        ));

      }
      else
      {
         while($row = mysqli_fetch_array($r))
        {
            array_push($result,array(
                "KUNJUNGAN"=>$row['KUNJUNGAN'],
                "AFTERSALES"=>$row['AFTERSALES'],
                "BARU"=>$row['BARU'],
                "FOLLOWUP"=>$row['FOLLOWUP'],
                "DEAL"=>$row['DEAL'],
                "TUGASSELESAI"=>$row['TUGASSELESAI'],
                "TUGASBELUM"=>$row['TUGASBELUM'],
                "OTHER"=>$row['OTHER'],
                "REQUESTKUNJUNGAN"=>$row['REQUESTKUNJUNGAN']
            ));
        }
      }


      $r = mysqli_query($conGE, $sql1);
      $resultpie = array();
      if (mysqli_num_rows($r)==0) {
          array_push($resultpie, array(
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
              array_push($resultpie, array(
              "bulan"=>$row['bulan'],
              "kubik"=>$row['kubik'],
              "netto"=>$row['netto'],
              "jumlahtransaksi"=>$row['jumlahtransaksi'],
              "jenis_produk"=>$row['JENIS']
              ));
          }
      }

      // echo json_encode(array('result'=>$result, 'pie'=>$arraypie, 'penjualan'=>$arraypenjualan , 'piutang'=>$arraypiutang));
      echo json_encode(array('result'=>$result, 'pie'=>$resultpie));
      // echo $sql;
      mysqli_close($con);
  }
// END CEK ID DEVICE FOR OPEN PHP
?>
