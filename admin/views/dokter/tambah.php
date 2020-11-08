<h4>Tambah Data</h4>
<hr>
<form action="index.php?mod=dokter&page=save" method="POST" enctype="multipart/form-data">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Nama Dokter</label>
            <input type="text" name="nama_dokter" required value="<?=(isset($_POST['nama_dokter']))?$_POST['nama_dokter']:'';?>" class="form-control">
            <input type="hidden" name="id_dokter"  value="<?=(isset($_POST['id_dokter']))?$_POST['id_dokter']:'';?>" class="form-control">
            <input type="hidden" name="photo_old"  value="<?=(isset($_POST['photo']))?$_POST['photo']:'';?>" >
            <span class="text-danger"><?=(isset($err['nama_dokter']))?$err['nama_dokter']:'';?></span>
        </div>
        <div class="form-group">
        <label for="">No IDI</label>
            <input type="number" name="no_id" value="<?=(isset($_POST['no_id']))?$_POST['no_id']:'';?>" class="form-control">
            <span class="text-danger"><?=(isset($err['no_id']))?$err['no_id']:'';?></span>
        </div>
        <div class="form-group">
        <label for="">NIP</label>
            <input type="number" name="nip" value="<?=(isset($_POST['nip']))?$_POST['nip']:'';?>" class="form-control">
            <span class="text-danger"><?=(isset($err['nip']))?$err['nip']:'';?></span>
        </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
            <label for="">Pendidikan Terakhir</label>
            <select name="id_pendidikan" class="form-control" required id="" >
            <option value="">Pilih Spesialisasi</option>
                <?php if($pendidikan != NULL){
                    foreach($pendidikan as $row){?>
                        <option <?=(isset($_POST['id_pendidikan']) && $_POST['id_pendidikan']==$row['id_pendidikan'] )?"selected":'';?> value="<?=$row['id_pendidikan'];?>"> <?=$row['pendidikan'];?></option>
                    <?php }
                }?>
            </select>
            <span class="text-danger"><?=(isset($err['id_pendidikan']))?$err['id_pendidikan']:'';?></span>
    </div>
    <div class="form-group">
            <label for="">Spesialisasi</label>
            <select name="id_spesialisasi" class="form-control" required id="">
                <option value="">Pilih Spesialisasi</option>
                <?php if($spesialis != NULL){
                    foreach($spesialis as $row){?>
                        <option <?=(isset($_POST['id_spesialisasi']) && $_POST['id_spesialisasi']==$row['id_spesialisasi'] )?"selected":'';?> value="<?=$row['id_spesialisasi'];?>"> <?=$row['nama_spesialisasi'];?></option>
                    <?php }
                }?>
            </select>
            <span class="text-danger"><?=(isset($err['id_spesialisasi']))?$err['id_spesialisasi']:'';?></span>
    </div>
    <div class="form-group">
    <label for="">Photo</label>
    <img src="../media/<?=$_POST['photo']?>" width="100">
    <input type="file" name="fileToUpload" class="form-control">
    <span class="text-danger"><?=(isset($err['fileToUpload']))?$err['fileToUpload']:'';?></span>
    </div>
    <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
    </div>
    </div>
</form>