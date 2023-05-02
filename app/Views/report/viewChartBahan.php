<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chart Report Bahan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Report</a></li>
                        <li class="breadcrumb-item active">Chart Report Bahan</li>
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
                                <div class="form-row">
                                    <div class="form-group row col-md-8">
                                        <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                                        <div class="col-sm-4">
                                            <select class="form-control select2-min" name="tahun">
                                                <option value="2022" <?= ($filter_tahun == '2022') ? 'selected' : ''; ?>>2022</option>
                                                <option value="2021" <?= ($filter_tahun == '2021') ? 'selected' : ''; ?>>2021</option>
                                                <option value="2020" <?= ($filter_tahun == '2020') ? 'selected' : ''; ?>>2020</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group row col-md-8">
                                        <label for="bahan" class="col-sm-2 col-form-label">Bahan</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2-default" name="bahan" data-placeholder="-- Pilih Bahan --">
                                                <option></option>
                                                <?php foreach ($bahan as $value) { ?>
                                                    <option value="<?= $value['id']; ?>"><?= $value['kode'] . ' | ' . $value['nama']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
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
        select2Default();

        loadDataChartBahan();
    });

    $('#btn_filter').click(function() {
        loadDataChartBahan();
    })

    function loadDataChartBahan() {
        let data_filter = $('#form_filter').serialize();
        $.ajax({
            url: "chartBahan/loadChartBahan",
            data: data_filter,
            success: function(data) {
                $('#table_view').html(data);
                $('#data-table').DataTable();
            }
        })
    }
</script>
<?= $this->endSection(); ?>