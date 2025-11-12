<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php 
                if(session()->getFlashdata('statusindexfp'))
                {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?= session()->getFlashdata('statusindexfp'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                }
            ?>
            <div class="card">
                <div class="card-header">
                    <h2>Kemaskini Fail Peribadi
                    <a href="<?= base_url('failPeribadi/add') ?>" class="btn btn-primary btn-sm float-end">Daftar Baru</a>
                    </h2>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tableFP">
                                <thead class="table-dark">
                                    <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 150px;">Nama</th>
                                    <th style="width: 120px;">No. KP</th>
                                    <th style="width: 150px;">Jawatan</th>
                                    <th style="width: 150px;">Bahagian / Cawangan</th>
                                    <th style="width: 100px;">No. Fail</th>
                                    <th style="width: 100px;">No. Jilid</th>
                                    <th style="width: 120px;">Tarikh</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 200px;">Catatan</th>
                                    <th style="width: 150px;">Lokasi Fail</th>
                                    <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  if($failPeribadi): ?>
                                        <?php  foreach($failPeribadi as $row): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['NAMA']; ?></td>
                                                <td><?php echo $row['NOKP']; ?></td>
                                                <td><?php echo $row['JAWATAN']; ?></td>
                                                <td><?php echo $row['BAHAGIAN_CAWANGAN']; ?></td>
                                                <td><?php echo $row['NOFAIL']; ?></td>
                                                <td><?php echo $row['NOJILID']; ?></td>
                                                <td><?php echo $row['TARIKH']; ?></td>
                                                <td><?php echo $row['STATUS']; ?></td>
                                                <td><?php echo $row['CATITAN']; ?></td>
                                                <td><?php echo $row['LOKASI_FAIL']; ?></td>
                                                <td>
                                                    <a href="<?= base_url('failPeribadi/edit/'.$row['id']) ?>"class="btn btn-primary btn-sm">Kemaskini</a>
                                                    <button type="button" value="<?= $row['id']; ?>" class="delete_btn btn btn-danger btn-sm">Hapus</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    table
        th, td {
            vertical-align: top;
        }
    .table-responsive {
        overflow-x: auto;
    }
    .custom-margin {
        margin-top: 75px;
        margin-bottom: 25px;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function(){
      $('.delete_btn').click(function(e){
        e.preventDefault();
        var id = $(this).val();
        if (confirm("Adakah anda mahu membuang data ini?")){
            $.ajax({
                url: "/failPeribadi/delete/"+id,
                success: function(response){
                    window.location.reload();
                    alert("Data sudah dibuang");
                }
            })
        }
      });
    });
</script>
<?= $this->endSection() ?>