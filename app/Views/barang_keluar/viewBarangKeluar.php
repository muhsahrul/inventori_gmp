<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Barang Keluar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                        <li class="breadcrumb-item active">Barang Keluar</li>
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
                                <div class="form-group row col-md-8 px-0 align-items-center">
                                    <label for="bulan" class="col-sm-2 col-form-label">Tanggal Barang Keluar</label>
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
                                        <button type="button" class="btn btn-primary px-5" title="Filter PO" id="btn_filter">Cari</button>
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
        loadDataBarangKeluar();
    });

    $('#btn_filter').click(function() {
        loadDataBarangKeluar();
    })

    $('#btn_create').click(function() {
        $.ajax({
            url: "barangKeluar/createBarangKeluar",
            success: function(data) {
                $('#modal_view').html(data);
                $('#create_barang_keluar').modal('show');
            }
        })
    });

    function loadDataBarangKeluar() {
        let data_filter = $('#form_filter').serialize();
        $.ajax({
            url: "barangKeluar/loadDataBarangKeluar",
            data: data_filter,
            success: function(data) {
                $('#table_view').html(data);
                datatableDefault();
            }
        })
    }
</script>
<?= $this->endSection(); ?>