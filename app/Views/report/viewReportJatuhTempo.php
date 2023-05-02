<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Jatuh Tempo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Report</a></li>
                        <li class="breadcrumb-item active">Jatuh Tempo</li>
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
                                    <label for="bulan" class="col-sm-2 col-form-label">Tanggal</label>
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
                                <div class="form-group row col-md-8 px-0 align-items-center">
                                    <label for="bulan" class="col-sm-2 col-form-label">Status Pembayaran</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2-min" name="status_pembayaran">
                                            <option value="">-- Tampil Semua --</option>
                                            <?php foreach ($status_pembayaran as $value) { ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                            <?php } ?>
                                        </select>
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
<script>
    $(function() {
        select2Min();
        datepickerDefault();

        loadDataJatuhTempo();
    });

    $('#btn_filter').click(function() {
        loadDataJatuhTempo();
    });

    function loadDataJatuhTempo() {
        let data_filter = $('#form_filter').serialize();
        $.ajax({
            url: "jatuhTempo/loadDatajatuhTempo",
            data: data_filter,
            success: function(data) {
                $('#table_view').html(data);
                datatableDefault();
            }
        })
    }
</script>
<?= $this->endSection(); ?>