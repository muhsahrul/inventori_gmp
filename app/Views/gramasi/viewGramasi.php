<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gramasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                        <li class="breadcrumb-item active">Gramasi</li>
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
                                <a href="javascript:void(0)" type="button" class="btn btn-sm btn-success" id="btn_create"><i class="fas fa-plus"></i> Tambah</a>
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
        loadDataGramasi();
    });

    $('#btn_create').click(function() {
        $.ajax({
            url: "gramasi/createGramasi",
            success: function(data) {
                $('#modal_view').html(data);
                $('#create_gramasi').modal('show');
            }
        })
    });

    function loadDataGramasi() {
        $.ajax({
            url: "gramasi/loadDataGramasi",
            success: function(data) {
                $('#table_view').html(data);
                datatableDefault();
            }
        })
    }
</script>
<?= $this->endSection(); ?>