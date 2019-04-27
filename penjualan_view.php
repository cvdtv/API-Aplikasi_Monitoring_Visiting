<?php 
 
    require_once('koneksi.php');

    $iddevice = "";
    if (isset($_POST['iddevice']))$iddevice=$_POST['iddevice'];
    $cekakses = "select * from sales where iddevice='$iddevice'";
    $cr = mysqli_query($con, $cekakses);
    $result=array();
    if (mysqli_num_rows($cr)==0){

        mysqli_close($con);
        echo "Anda Tidak Punya Akses!!!";
        return;

    }else{

        $idcustomer = "";
        $valuefilter = "";
        $filter = "";

        if (isset($_POST['idcustomer'])) $idmaster_customer = $_POST['idcustomer'];
        if (isset($_POST['stanggal'])) $stanggal = $_POST['stanggal'];
        if (isset($_POST['etanggal'])) $etanggal = $_POST['etanggal'];
        if (isset($_POST['valuefilter'])) $valuefilter = $_POST['valuefilter'];

        $strfilter = "";
        // $filter = "";
        if(isset($_POST['filter']))
        {
            $filter = $_POST['filter'];

            if($filter=="customer")
            {
                $strfilter = " AND a.idcustomer=".$valuefilter;
            }
            else if($filter=="editpenjualan")
            {
                $strfilter = " AND a.id_do=".$valuefilter;
            }
            else if($filter=="laporanpenjualan")
            {
                if($idmaster_customer=="")
                    $strfilter = " AND a.tgl between '$stanggal' and '$etanggal'";
                else
                    $strfilter = " AND a.idcustomer='$idmaster_customer' AND a.tgl between '$stanggal' and '$etanggal'";
            }
        }
        $strsales = "";
        $query = "";

        if($filter=="editpenjualan")
        {
            $query = "SELECT a.id_do, a.tgl, a.no_sistem, a.keysales, a.idcustomer, a.tgl, a.no_do, c.CUS_NAMA, a.keterangan, a.tujuan, a.total FROM a_do a, customer c where a.idcustomer=c.CUS_ID".$strsales.$strfilter;
            $r = mysqli_query($conGE,$query);

            if($row=mysqli_fetch_array($r))
            {
                $id_do = $row['id_do'];
                $tgl = $row['tgl'];
                $no_sistem =$row['no_sistem'];
                $keysales = $row['keysales'];
                $idcustomer = $row['idcustomer'];
                $tanggal = $row['tgl'];
                $no_do = $row['no_do'];
                $customer = $row['CUS_NAMA'];
                $keterangan = $row['keterangan'];
                $tujuan = $row['tujuan'];
                $total = $row['total'];
            }



            $nmbrg = array("", "","","");
            $idbrg = array(0,0,0);
            $hs = array(0,0,0);
            $pcs = array(0,0,0);
            $kbk = array(0,0,0);

            $i=0;
            $query = "SELECT a.barang, a.pcs, a.harga_satuan, b.PV_NAMA as namabarang, b.PV_KUBIK from a_det_do a, produk b where a.barang=b.PV_ID and a.id_do=".$id_do;
            $r = mysqli_query($conGE,$query);

            while($row=mysqli_fetch_array($r))
            {
                $idbrg[$i] = $row['barang'];
                $nmbrg[$i] = $row['namabarang'];
                $pcs[$i] = $row['pcs'];
                $kbk[$i] = $row['PV_KUBIK'];
                $hs[$i] = $row['harga_satuan'];
                $i++;
            }


            $r = mysqli_query($conGE,$query);
            $result = array();

            if($id_do=="")
            {
                array_push($result,array(
                        "id_do" => "",
                        "keysales" => "",
                        "tgl" => "",
                        "no_sistem" => "",
                        "idcustomer" => "",
                        "no_do"=>"",
                        "customer"=>"",
                        "keterangan"=>"",
                        "tujuan"=>"",
                        "total"=>"",
                        "pcs"=>"",
                        "harga_satuan"=>""
                ));

            } else{   
                    array_push($result,array(
                        "id_do" => $id_do,
                        "tgl" => $tgl,
                        "no_sistem" => $no_sistem,
                        "keysales" => $keysales,
                        "idcustomer" => $idcustomer,
                        "no_do"=> $no_do,
                        "customer"=>$customer,
                        "tgl"=>$tanggal,
                        "keterangan"=>$keterangan,
                        "tujuan"=>$tujuan,
                        "barang1"=>$idbrg[0],
                        "namabarang1"=>$nmbrg[0],
                        "kubik1"=>$kbk[0],
                        "pcs1"=>$pcs[0],
                        "harga_satuan1"=>$hs[0],
                        "barang2"=>$idbrg[1],
                        "namabarang2"=>$nmbrg[1],
                        "kubik2"=>$kbk[1],
                        "pcs2"=>$pcs[1],
                        "harga_satuan2"=>$hs[1],
                        "barang3"=>$idbrg[2],
                        "namabarang3"=>$nmbrg[2],
                        "kubik3"=>$kbk[2],
                        "pcs3"=>$pcs[2],
                        "harga_satuan3"=>$hs[2],
                        "total"=>$total
                    ));
            }
            
        }
        else
        {
            $query = "SELECT a.id_do, a.no_sistem, a.keysales, a.idcustomer, a.no_do, c.CUS_NAMA, a.tgl, a.tujuan, a.keterangan, a.total FROM a_do a, customer c where a.idcustomer=c.CUS_ID".$strsales.$strfilter;

            $r = mysqli_query($conGE,$query);
            $result = array();

            if(mysqli_num_rows($r)==0)
            {
                array_push($result,array(
                        "id_do" => "",
                        "tgl" => "",
                        "no_sistem" => "",
                        "keysales" => "",
                        "idcustomer" => "",
                        "no_do"=>"",
                        "CUS_NAMA"=>"",
                        "tujuan"=>"",
                        "total"=>""
                ));

            } else{   
                while($row = mysqli_fetch_array($r)){
                    array_push($result,array(
                        "id_do" => $row['id_do'],
                        "keysales" => $row['keysales'],
                        "idcustomer" => $row['idcustomer'],
                        "no_do"=> $row['no_do'],
                        "CUS_NAMA"=>$row['CUS_NAMA'],
                        "tgl" => $row['tgl'],
                        "no_sistem" => $row['no_sistem'],
                        "keterangan"=>$row['keterangan'],
                        "tujuan"=>$row['tujuan'],
                        "total"=>$row['total']
                    ));
                }
            }
        }
        echo json_encode(array('result'=>$result));
        // echo $query;
        mysqli_close($conGE);
    }
?>
