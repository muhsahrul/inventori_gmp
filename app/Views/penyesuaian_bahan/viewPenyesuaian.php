<?php
$this->extend('layout/template');
$this->section('content');
if (session()->getFlashdata('msg')) { ?>
    <script>
        $(function() {
            successAlert("<?= session()->getFlashdata('msg') ?>");
        })
    </script>
<?php } elseif (session()->getFlashdata('err')) { ?>
    <script>
        $(function() {
            errorAlert("<?= session()->getFlashdata('err') ?>");
        })
    </script>
<?php } ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Penyesuaian Stok</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                        <li class="breadcrumb-item active">Penyesuaian Stok</li>
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
                            <div class="card-tools ml-auto pr-2">
                                <a href="<?= site_url(); ?>master/penyesuaian/createPenyesuaian" type="button" class="btn btn-sm btn-success" id="btn_create"><i class="fas fa-plus"></i> Tambah</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div id="table_view"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="modal_view"></div>
<script>
    $(function() {
        loadPenyesuaian();
    });

    function loadPenyesuaian() {
        $.ajax({
            url: "penyesuaian/loadPenyesuaian",
            success: function(data) {
                $('#table_view').html(data);
                datatableDefault();
            }
        })
    }
</script>
<?= $this->endSection(); ?>