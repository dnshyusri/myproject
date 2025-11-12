<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php 
                if(session()->getFlashdata('statusindexfa'))
                {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?= session()->getFlashdata('statusindexfa'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                }
            ?>
            <div class="card">
                <div class="card-header">
                    <h2>Kemaskini Fail Am
                    <a href="<?= base_url('failAm/add') ?>" class="btn btn-primary btn-sm float-end">Daftar Baru</a>
                    </h2>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table">
                                <thead class="table-dark">
                                    <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 50px;">Abjad</th>
                                    <th style="width: 120px;">Kod Subjek</th>
                                    <th style="width: 150px;">Subjek</th>
                                    <th style="width: 80px;">Bil</th>
                                    <th style="width: 200px;">Tajuk Fail</th>
                                    <th style="width: 150px;">Rujuk Fail Lama</th>
                                    <th style="width: 150px;">Rujuk Fail Baru</th>
                                    <th style="width: 80px;">Jilid</th>
                                    <th style="width: 140px;">Tarikh Buka</th>
                                    <th style="width: 140px;">Tarikh Tutup</th>
                                    <th style="width: 140px;">Tarikh Kandungan Pertama</th>
                                    <th style="width: 140px;">Tarikh Kandungan Akhir</th>
                                    <th style="width: 100px;">Lokasi Fail</th>
                                    <th style="width: 200px;">Catatan</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  if($failAm): ?>
                                        <?php  foreach($failAm as $row): ?>
                                            <tr>
                                                <td><?php echo $row['ID']; ?></td>
                                                <td><?php echo $row['Abjad']; ?></td>
                                                <td><?php echo $row['KodSubjek']; ?></td>
                                                <td><?php echo $row['Subjek']; ?></td>
                                                <td><?php echo $row['Bil']; ?></td>
                                                <td><?php echo $row['TajukFail']; ?></td>
                                                <td><?php echo $row['RujukFailLama']; ?></td>
                                                <td><?php echo $row['RujukFailBaru']; ?></td>
                                                <td><?php echo $row['Jilid']; ?></td>
                                                <td><?php echo $row['tkhBuka']; ?></td>
                                                <td><?php echo $row['tkhTutup']; ?></td>
                                                <td><?php echo $row['tkhkandungtama']; ?></td>
                                                <td><?php echo $row['tkhkandungakhir']; ?></td>
                                                <td><?php echo $row['LokasiFail']; ?></td>
                                                <td><?php echo $row['Catatan']; ?></td>
                                                <td>
                                                    <a href="<?= base_url('failAm/edit/'.$row['ID']) ?>"class="btn btn-primary btn-sm">Kemaskini</a>
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
                url: "/failAm/delete/"+id,
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