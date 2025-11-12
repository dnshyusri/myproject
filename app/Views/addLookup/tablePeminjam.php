<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php 
                if(session()->getFlashdata('statusindexpeminjam'))
                {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?= session()->getFlashdata('statusindexpeminjam'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                }
            ?>
            <div class="card">
                <div class="card-header">
                    <h2>Senarai Peminjam
                    <a href="<?= base_url('addLookup/addPeminjam') ?>" class="btn btn-primary btn-sm float-end">Daftar Baru</a>
                    </h2>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table">
                                <thead class="table-dark">
                                    <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 120px;">Nama</th>
                                    <th style="width: 120px;">No. Tel.</th>
                                    <th style="width: 150px;">Email</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  if($peminjam): ?>
                                        <?php  foreach($peminjam as $row): ?>
                                            <tr>
                                                <td><?php echo $row['ID']; ?></td>
                                                <td><?php echo $row['user']; ?></td>
                                                <td><?php echo $row['phone']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td>
                                                    <a href="<?= base_url('addLookup/editPeminjam/'.$row['ID']) ?>"class="btn btn-primary btn-sm">Kemaskini</a>
                                                    <button type="button" value="<?= $row['ID']; ?>" class="delete_btn btn btn-danger btn-sm">Hapus</button>
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
                url: "/addLookup/deletePeminjam/"+id,
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