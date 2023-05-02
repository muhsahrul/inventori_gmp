<?php

use App\Helpers\QueryTransaksi;

$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Barang Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                        <li class="breadcrumb-item active">Detail Barang Masuk</li>
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
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 px-0">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="20%">Tanggal Barang Masuk<span class="float-right"> :</span></th>
                                        <td><?= ($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : NULL; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nomo Invoice<span class="float-right"> :</span></th>
                                        <td><?= $data['nomor_invoice']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Invoice<span class="float-right"> :</span></th>
                                        <td><?= ($data['tanggal_invoice']) ? date('d-m-Y', strtotime($data['tanggal_invoice'])) : NULL; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Supplier<span class="float-right"> :</span></th>
                                        <td><?= $data['nama_vendor']; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- <div id="showDetail"></div> -->
                            <hr>
                            <?php
                            $total = 0;
                            foreach ($detail as $key => $value) {
                            ?>
                                <div class="col-md-12 px-0">
                                    <table class="table table-borderless mb-0 mt-2">
                                        <tr>
                                            <th width="10%">Nomor PO<span class="float-right"> :</span></th>
                                            <th><button class="btn btn-default btn-sm"><?= $value['nomor_po']; ?></button></th>
                                        </tr>
                                    </table>
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="1%">No.</th>
                                                <th class="text-center" width="5%">Kode</th>
                                                <th class="text-center" width="30%">Bahan</th>
                                                <th class="text-center" width="5%">Satuan</th>
                                                <th class="text-center" width="15%">No. Katalog</th>
                                                <th class="text-center" width="10%">Harga Satuan</th>
                                                <th class="text-center" width="5%">Jumlah Pesanan</th>
                                                <th class="text-center" width="10%">Harga Total</th>
                                                <th class="text-center" width="10%">Jumlah Masuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query = new QueryTransaksi();
                                            $bahan = $query->getBahanDetailBarangMasuk($value['id'])->getResultArray();
                                            $subtotal = 0;
                                            foreach ($bahan as $subkey => $subvalue) {
                                                $subtotal += $subvalue['harga'] * $subvalue['jumlah_masuk']; ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td class="text-center"><?= $subvalue['kode']; ?></td>
                                                    <td class="text-left"><?= $subvalue['nama_bahan']; ?></td>
                                                    <td class="text-center"><?= $subvalue['nama_satuan']; ?></td>
                                                    <td class="text-center"><?= $subvalue['no_katalog']; ?></td>
                                                    <td class="text-right"><?= number_format($subvalue['harga'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?= $subvalue['jumlah']; ?></td>
                                                    <td class="text-right"><?= number_format($subvalue['total_harga'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?= $subvalue['jumlah_masuk']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                                $total += $subtotal;
                            }
                            $ppn = $total * 0.11;
                            ?>
                            <table class="table table-borderless">
                                <tr>
                                    <th colspan="4" class="text-right"><label class="text-right">Total</label></th>
                                    <td width="18%" class="pr-0 pb-0"><input type="text" class="form-control text-right" name="total" id="total" value="<?= number_format($total, 0, ',', '.'); ?>" readonly></td>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right"><label class="text-right">PPN (11%)</label></th>
                                    <td class="pr-0 pb-0"><input type="text" class="form-control text-right" name="ppn" id="ppn" value="<?= number_format($ppn, 0, ',', '.'); ?>" readonly></td>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right"><label class="text-right">Grand Total</label></th>
                                    <td class="pr-0 pb-0"><input type="text" class="form-control text-right" name="grand_total" id="grand_total" value="<?= number_format($total + $ppn, 0, ',', '.'); ?>" readonly></td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="" onclick=" return window.close()" class="btn btn-default">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="showModal"></div>
<script>
    // $(function() {
    //     loadDataDetailBarangMasuk();
    // })

    // function loadDataDetailBarangMasuk() {
    //     var invoice = <?= $data['nomor_invoice']; ?>;
    //     $.ajax({
    //         url: "<?= site_url(); ?>transaksi/barangMasuk/loadDataDetailBarangMasuk",
    //         data: {
    //             invoice: invoice
    //         },
    //         success: function(data) {
    //             $('#showDetail').html(data);
    //             $('#data-table').DataTable();
    //         }
    //     });
    // };
</script>
<?= $this->endSection(); ?>