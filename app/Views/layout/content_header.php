<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= $header['title']; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php if (isset($header['breadcrumb'])) {; ?>
                        <li class="breadcrumb-item"><a href="#"><?= $header['breadcrumb']; ?></a></li>
                    <?php } ?>
                    <li class="breadcrumb-item active"><?= $header['title']; ?></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>