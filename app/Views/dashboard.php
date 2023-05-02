<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <?php contentHeader(isset($content_header), $header); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fas fa-check"></i>
                            <?= $content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>