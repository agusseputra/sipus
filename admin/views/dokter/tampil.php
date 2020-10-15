<div class="row">
    <div class="pull-left">
        <h4>Daftar Dokter</h4>
    </div>
    <div class="pull-right">
        <a href="index.php?mod=dokter&page=add">
            <button class="btn btn-primary">Add</button>
        </a>
    </div>
</div>
<div class="row">
    <table class="table">
        <thead>
            <tr>
                <td>
                    #
                </td>
                <td>Nama</td><td>ID</td><td>NIK</td><th>Pendidikan</th><th>Spesialis</th><td>Aksi</td>
            </tr>
        </thead>
        <tbody>
            <?php if($dokter != NULL){ 
                $no=1;
                foreach($dokter as $row){?>
                    <tr>
                        <td><?=$no;?></td><td><?=$row['nama_dokter']?></td><td><?=$row['no_peserta_idi'];?></td><td><?=$row['nik']?></td>
                        <td><?=$row['pendidikan']?></td><td><?=$row['nama_spesialisasi']?></td>                        
                        <td>
                            <a href="index.php?mod=dokter&page=edit&id=<?=md5($row['id_dokter'])?>"><i class="fa fa-pencil"></i> </a>
                            <a href="index.php?mod=dokter&page=delete&id=<?=md5($row['id_dokter'])?>"><i class="fa fa-trash"></i> </a>
                        </td>
                    </tr>
               <?php $no++; }
            }?>
        </tbody>
    </table>
</div>