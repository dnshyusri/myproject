<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            .custom-margin {
                margin-top: 75px;
                margin-bottom: 25px;
            }
            .card-custom {
                width: 100%;
                max-width: 500px;
                margin: auto;
            }
            /* Center vertically */
            .vh-100 {
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        </style>
    </head>
    <body>
        <script src="<?= base_url('assets/js/jquery-3.7.1.js') ?>"></script>
        <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="//cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
        
        <div class="container vh-100">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    <div class="card card-custom">
                        <div class="card-header text-center">
                            <h2>Sistem Pengurusan Fail DOSM (SPF)</h2>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" action="<?= base_url('login') ?>" method="post">
                                <div class="form-group col-md-12">
                                    <label for="username">ID</label>
                                    <input type="text" name="username" id="username" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="password">Katalaluan</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary mt-2">Log Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
