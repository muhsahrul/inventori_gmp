<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <style>
        table {
            font-size: 14px;
        }
    </style>
    <?php if (session()->getFlashdata('msg')) { ?>
        <div class="toast toasts-top-right fixed bg-success" data-animation="true" data-delay="3000" id="myToast" style="right: 1%; top: 2.5%;">
            <div class="toast-header">
                <strong class="mr-auto">NOTIFICATION</strong>
            </div>
            <div class="toast-body">
                <div><?= session()->getFlashdata('msg') ?></div>
            </div>
        </div>
    <?php }; ?>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stok Akhir Bahan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                        <li class="breadcrumb-item active">Stok Akhir Bahan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title m-0"><?= $title; ?></h3>
                        </div>
                        <div class="card-body table-responsive">
                            <div id="showData"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="showModal"></div>
<script>
    $(function() {
        loadDataStokAkhir();
    });

    function loadDataStokAkhir() {
        $.ajax({
            url: "stokAkhir/loadDataStokAkhir",
            success: function(data) {
                $('#showData').html(data);
                $('#data-table').DataTable();
            }
        })
    }
</script>
<?= $this->endSection(); ?>