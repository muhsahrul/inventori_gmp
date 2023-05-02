<div class="card-body table-responsive p-0">
    <table class="table table-borderless">
        <tr>
            <th width="25%">Nomor PO<span class="float-right"> :</span></th>
            <td><?= ($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : NULL; ?></td>
        </tr>
    </table>
    <table class="table table-hover table-bordered" id="table_bahan">
        <thead>
            <tr>
                <th width="1%">No.</th>
                <th>Kode</th>
                <th>Bahan</th>
                <th>Satuan</th>
                <th>No. Katalog</th>
                <th>Harga Satuan</th>
                <th>Jumlah Pesanan</th>
                <th>Harga Total</th>
                <th>Jumlah Masuk</th>
                <!-- <th width="1%"></th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($detail as $key => $value) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="text-center"><?= $value['kode']; ?></td>
                    <td class="text-left"><?= $value['nama_bahan']; ?></td>
                    <td class="text-left"><?= $value['nama_satuan']; ?></td>
                    <td class="text-left"><?= $value['no_katalog']; ?></td>
                    <td class="text-right"><?= number_format($value['harga'], 0, ',', '.'); ?></td>
                    <td class="text-right"><?= $value['jumlah']; ?></td>
                    <td class="text-right"><?= number_format($value['total_harga'], 0, ',', '.'); ?></td>
                    <td class="text-right"><?= $value['jumlah_masuk']; ?></td>
                    <!-- <td class="text-center">
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id="<?= $value['id']; ?>"><i class="fas fa-trash-alt"></i></a>
                    </td> -->
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    // $('.btn-delete').click(function() {
    //     var x = confirm("Apakah ingin dihapus?");
    //     if (x) {
    //         const id = $(this).data('id');
    //         $.ajax({
    //             url: "<?= site_url(); ?>transaksi/barangMasuk/deleteBahanBarangMasuk/" + id,
    //             success: function(msg) {
    //                 alert(msg);
    //                 loadDataDetailBarangMasuk()
    //             }
    //         })
    //     }
    // });
</script>