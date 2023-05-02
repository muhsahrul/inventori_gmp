<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bahan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                        <li class="breadcrumb-item active">Bahan</li>
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
        loadDataBahan();

        var table = $('#data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('bahan/ajaxList') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });
    });

    $('#btn_create').click(function() {
        $.ajax({
            url: "bahan/createBahan",
            success: function(data) {
                $('#modal_view').html(data);
                $('#create_bahan').modal('show');
            }
        })
    });

    function loadDataBahan() {
        $.ajax({
            url: "bahan/loadDataBahan",
            success: function(data) {
                $('#table_view').html(data);
                datatableDefault();
            }
        })
    }
</script>
<?= $this->endSection(); ?>