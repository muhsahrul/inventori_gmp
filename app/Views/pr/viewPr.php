<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>PR Purchasing</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Purchasing</a></li>
                        <li class="breadcrumb-item active">PR Purchasing</li>
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
                            <h3 class="card-title m-0">Filter</h3>
                            <div class="card-tools ml-auto pr-2">
                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="" method="POST" id="form_filter">
                                <div class="form-group row col-md-8 px-0">
                                    <label for="bulan" class="col-sm-2 col-form-label">Tanggal PR</label>
                                    <div class="col-md-4">
                                        <div class="input-group date date-default" id="tglawal" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="tglawal" data-toggle="datetimepicker" data-target="#tglawal" value="<?= ($filter_tglawal) ? date('d-m-Y', strtotime($filter_tglawal)) : ''; ?>" autocomplete="off" />
                                            <div class="input-group-append" data-target="#tglawal" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group date date-default" id="tglakhir" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="tglakhir" data-toggle="datetimepicker" data-target="#tglakhir" value="<?= ($filter_tglakhir) ? date('d-m-Y', strtotime($filter_tglakhir)) : ''; ?>" autocomplete="off" />
                                            <div class="input-group-append" data-target="#tglakhir" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row col-md-8 px-0">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary px-5" title="Filter PR" id="btn_filter">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
        datepickerDefault();
        loadDataPr();
    });

    $('#btn_filter').click(function() {
        loadDataPr();
    });

    $('#btn_create').click(function() {
        $.ajax({
            url: "pr/createPr",
            success: function(data) {
                $('#modal_view').html(data);
                $('#create_pr').modal('show');
            }
        })
    });

    function loadDataPr() {
        let data_filter = $('#form_filter').serialize();
        $.ajax({
            url: "pr/loadDataPr",
            data: data_filter,
            success: function(data) {
                $('#table_view').html(data);
                datatableDefault();
            }
        })
    }
</script>
<?= $this->endSection(); ?>