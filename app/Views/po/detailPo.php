<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail PO</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Purchasing</a></li>
                        <li class="breadcrumb-item active">Detail PO</li>
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
                                <a href="<?= site_url(); ?>purchasing/po/printPo/<?= $row['id']; ?>" type="button" class="btn btn-sm btn-success" target="_blank"><i class="fas fa-print"></i> Cetak</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 px-0">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="25%">Tanggal PO<span class="float-right"> :</span></th>
                                        <td><?= ($row['tanggal']) ? date('d-m-Y', strtotime($row['tanggal'])) : NULL; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor PO<span class="float-right"> :</span></th>
                                        <td><?= $row['nomor']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Supplier<span class="float-right"> :</span></th>
                                        <td><?= $row['nama_vendor']; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="table_view"></div>
                        </div>
                        <div class="card-footer">
                            <button type="button" onclick=" return window.close()" class="btn btn-default">Kembali</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="showModal"></div>
<script>
    $(function() {
        loadDataDetailPo();
    })

    function loadDataDetailPo() {
        let id_po = <?= $row['id']; ?>;
        $.ajax({
            url: "<?= site_url(); ?>purchasing/po/loadDataDetailPo/" + id_po,
            success: function(data) {
                $('#table_view').html(data);
                datatableDefault();
            }
        });
    };
</script>
<?= $this->endSection(); ?>