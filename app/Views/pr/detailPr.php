<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail PR</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Purchasing</a></li>
                        <li class="breadcrumb-item active">Detail PR</li>
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
                                <a href="<?= site_url(); ?>purchasing/pr/printPr/<?= $row['id']; ?>" type="button" class="btn btn-sm btn-success" target="_blank"><i class="fas fa-print"></i> Cetak</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 px-0">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="25%">Tanggal PR<span class="float-right"> :</span></th>
                                        <td><?= ($row['tanggal']) ? date('d-m-Y', strtotime($row['tanggal'])) : NULL; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor PR<span class="float-right"> :</span></th>
                                        <td><?= $row['nomor']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Supplier<span class="float-right"> :</span></th>
                                        <td><?= $row['nama_vendor']; ?></td>
                                    </tr>
                                </table>
                                <button type="button" class="btn btn-primary btn-sm mb-3" id="btn_create"><i class="fas fa-plus"></i> Tambah Bahan</button>
                            </div>
                            <div id="detail_view"></div>
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
<div id="modal_view"></div>
<script>
    $(function() {
        loadDataDetailPr();
    })

    $('#btn_create').click(function() {
        let id_po = <?= $row['id']; ?>;
        $.ajax({
            url: "<?= site_url(); ?>purchasing/pr/createBahanPr",
            data: {
                id_po: id_po
            },
            success: function(data) {
                $('#modal_view').html(data);
                $('#create_bahan_pr').modal('show');
            }
        })
    });

    function loadDataDetailPr() {
        let id_po = <?= $row['id']; ?>;
        $.ajax({
            url: "<?= site_url(); ?>purchasing/pr/loadDataDetailPr/" + id_po,
            success: function(data) {
                $('#detail_view').html(data);
                datatableDefault();
            }
        });
    };
</script>
<?= $this->endSection(); ?>