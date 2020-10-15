<?php
$con->auth();
$conn=$con->koneksi();
switch (@$_GET['page']){
    case 'add':
        $pendidikan="select * from ref_pendidikan";
        $pendidikan=$conn->query($pendidikan);
        $sql="select * from ref_spesialisasi";
        $spesialis=$conn->query($sql);
        $content="views/dokter/tambah.php";
        include_once 'views/template.php';
    break;
    case 'save':
        if($_SERVER['REQUEST_METHOD']=="POST"){
            //validasi
            if(empty($_POST['nama_dokter'])){
                $err['nama_dokter']="Nama Dokter Wajib";
            }
            if(!is_numeric($_POST['no_id'])){
                $err['no_id']="No IDI Wajib Angka";
            }
            if(!is_numeric($_POST['id_pendidikan'])){
                $err['id_pendidikan']="Pendidikan Wajib Terisi";
            }
            if(!is_numeric($_POST['id_spesialisasi'])){
                $err['id_spesialisasi']="Pendidikan Wajib Terisi";
            }
            if(!isset($err)){
                $id_pegawai=$_SESSION['login']['id'];
                if(!empty($_POST['id_dokter'])){
                    //update
                    $sql="update dokter set nama_dokter='$_POST[nama_dokter]',no_peserta_idi='$_POST[no_id]', nip='$_POST[nip]',id_pendidikan='$_POST[id_pendidikan]',
                    id_spesialis='$_POST[id_spesialisasi]',id_pegawai=$id_pegawai where md5(id_dokter)='$_POST[id_dokter]'";
                }else{
                    //save
                    $sql = "INSERT INTO dokter (nama_dokter, no_peserta_idi, nip,id_pendidikan,id_spesialis,id_pegawai) 
                    VALUES ('$_POST[nama_dokter]','$_POST[no_id]','$_POST[nip]','$_POST[id_pendidikan]','$_POST[id_spesialisasi]',$id_pegawai)";
                }
                    if ($conn->query($sql) === TRUE) {
                        header('Location: '.$con->site_url().'/admin/index.php?mode=dokter');
                    } else {
                        $err['msg']= "Error: " . $sql . "<br>" . $conn->error;
                    }
            }
        }else{
            $err['msg']="tidak diijinkan";
        }
        if(isset($err)){
            $pendidikan="select * from ref_pendidikan";
            $pendidikan=$conn->query($pendidikan);
            $sql="select * from ref_spesialisasi";
            $spesialis=$conn->query($sql);
            $content="views/dokter/tambah.php";
            include_once 'views/template.php';
        }
    break;
    case 'edit':
        $dokter ="select * from dokter where md5(id_dokter)='$_GET[id]'";
        $dokter=$conn->query($dokter);
        $_POST=$dokter->fetch_assoc();
        $_POST['no_id']=$_POST['no_peserta_idi'];
        $_POST['id_dokter']=md5($_POST['id_dokter']);
        //var_dump($dokter);
        $pendidikan="select * from ref_pendidikan";
        $pendidikan=$conn->query($pendidikan);
        $sql="select * from ref_spesialisasi";
        $spesialis=$conn->query($sql);
        $content="views/dokter/tambah.php";
        include_once 'views/template.php';
    break;
    case 'delete';
        $dokter ="delete from dokter where md5(id_dokter)='$_GET[id]'";
        $dokter=$conn->query($dokter);
        header('Location: '.$con->site_url().'/admin/index.php?mode=dokter');
    break;
    default:
        $sql ="Select * from dokter inner join ref_pendidikan on ref_pendidikan.id_pendidikan=dokter.id_pendidikan
        inner join ref_spesialisasi on ref_spesialisasi.id_spesialisasi=dokter.id_spesialis";
        $dokter=$conn->query($sql);
        $conn->close();
        $content="views/dokter/tampil.php";
        include_once 'views/template.php';
}
?>