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
            //validasi file
            if(!empty($_FILES['fileToUpload']["name"])){
                $target_dir = "../media/";
                $photo=basename($_FILES["fileToUpload"]["name"]);
                $target_file = $target_dir . $photo;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                  if($check !== false) {
                    $err["fileToUpload"]= "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                  } else {
                    $err["fileToUpload"]= "File is not an image.";
                    $uploadOk = 0;
                  }
                }
      
                // Check if file already exists
                if (file_exists($target_file)) {
                  $err["fileToUpload"]= "Sorry, file already exists.";
                  $uploadOk = 0;
                }
      
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 1048576) {
                  $err["fileToUpload"]= "Sorry, your file is too large.";
                  $uploadOk = 0;
                }
      
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                  $err["fileToUpload"]= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                  $uploadOk = 0;
                }
      
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 1) {
                  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    //$err["fileToUpload"]= "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                    $_POST['photo']=$photo;
                    if(isset($_POST['photo_old']) && $_POST['photo_old']!=''){
                        unlink($target_dir.$_POST['photo_old']);
                    }
                  } else {
                    $err["fileToUpload"]= "Sorry, there was an error uploading your file.";
                  }
                }
              }
            if(!isset($err)){
                $id_pegawai=$_SESSION['login']['id'];
                if(!empty($_POST['id_dokter'])){
                    //update
                    if(isset($_POST['photo'])){
                        $sql="update dokter set nama_dokter='$_POST[nama_dokter]',no_peserta_idi='$_POST[no_id]', nip='$_POST[nip]',id_pendidikan='$_POST[id_pendidikan]',
                    id_spesialis='$_POST[id_spesialisasi]',id_pegawai=$id_pegawai, photo='$_POST[photo]' where md5(id_dokter)='$_POST[id_dokter]'";
                    }else{
                    $sql="update dokter set nama_dokter='$_POST[nama_dokter]',no_peserta_idi='$_POST[no_id]', nip='$_POST[nip]',id_pendidikan='$_POST[id_pendidikan]',
                    id_spesialis='$_POST[id_spesialisasi]',id_pegawai=$id_pegawai where md5(id_dokter)='$_POST[id_dokter]'";
                    }
                }else{
                    //save
                    if(isset($_POST['photo'])){
                        $sql = "INSERT INTO dokter (nama_dokter, no_peserta_idi, nip,id_pendidikan,id_spesialis,id_pegawai,photo) 
                    VALUES ('$_POST[nama_dokter]','$_POST[no_id]','$_POST[nip]','$_POST[id_pendidikan]','$_POST[id_spesialisasi]',$id_pegawai,'$_POST[photo]')";
                    }else{
                        $sql = "INSERT INTO dokter (nama_dokter, no_peserta_idi, nip,id_pendidikan,id_spesialis,id_pegawai) 
                        VALUES ('$_POST[nama_dokter]','$_POST[no_id]','$_POST[nip]','$_POST[id_pendidikan]','$_POST[id_spesialisasi]',$id_pegawai)";
                    }
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