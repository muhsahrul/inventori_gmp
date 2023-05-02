<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" type="image/png" href="<?= base_url(); ?>/assets/img/beaker.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- <link rel="stylesheet" href="<?= base_url(); ?>/vendor/select2/css/select2.min.css"> -->
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>/vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> -->
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/adminlte.min.css"> -->

    <!-- <script src="<?= base_url(); ?>/vendor/jquery/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <title>Inventori Bahan Kimia</title>
    <style>
        .modal-dialog-custom {
            overflow-y: initial !important
        }

        .modal-body-custom {
            /* min-height: 34.375rem; */
            max-height: 75vh;
            overflow-y: auto;
        }

        body {
            font-size: 14px;
        }

        .col-action {
            width: 1%;
            white-space: nowrap;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/product" class="nav-link">Produk</a>
                </li> -->
            </ul>

            <!-- User Menu Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <span class="d-none d-lg-inline text-gray-600"><?= session()->get('user_name'); ?></span>
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="<?= site_url() ?>logout" type="button" class="dropdown-item text-center dropdown-header" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="<?= site_url() ?>" class="brand-link">
                <img src="<?= site_url() ?>assets/img/experimental.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">INVENTORI KIMIA</span>
            </a>
            <?= $this->include('layout/sidebar'); ?>
        </aside>

        <?= $this->renderSection('content'); ?>

        <footer class="main-footer text-center">
            <span>&copy; <?= date('Y'); ?> PT Graha Mutu Persada.</span>
        </footer>
    </div>
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notification!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>Apakah anda ingin keluar?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <a href="<?= site_url() ?>login/logout" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div id="alert_view"></div>

    <!-- CDN Assets -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript" charset="utf8"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script> -->
    <script src="<?= base_url(); ?>/vendor/datatables/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.18.1/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <!-- Local Assets -->
    <!-- <script src="<?= base_url(); ?>/vendor/bootstrap/js/bootstrap.min.js"></script> -->
    <!-- <script src="<?= base_url(); ?>/vendor/select2/js/select2.min.js"></script> -->
    <!-- <script src="<?= base_url(); ?>/vendor/moment/moment.min.js"></script> -->
    <!-- <script src="<?= base_url(); ?>/vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
    <!-- <script src="<?= base_url(); ?>/assets/js/adminlte.min.js"></script> -->
    <!-- <script src="<?= base_url(); ?>/vendor/fullcalendar/main.min.js"></script> -->
    <?= $this->include('layout/function_js'); ?>
    <?php if (session()->getFlashdata('msg')) { ?>
        <script>
            $(function() {
                successAlert("<?= session()->getFlashdata('msg'); ?>");
            })
        </script>
    <?php }
    if (session()->getFlashdata('err')) { ?>
        <script>
            $(function() {
                errorAlert("<?= session()->getFlashdata('err'); ?>");
            })
        </script>
    <?php } ?>
</body>

</html>