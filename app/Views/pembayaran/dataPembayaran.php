<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">No.</th>
            <th class="text-center">Tanggal Invoice</th>
            <th class="text-center">Nomor Invoice</th>
            <th class="text-center">Tanggal Jatuh Tempo</th>
            <th class="text-center">Total Tagihan</th>
            <th class="text-center">Tanggal Barang Masuk</th>
            <th class="text-center">Status Pembayaran</th>
            <th class="text-center">Tanggal Pembayaran</th>
            <th class="text-center">Jumlah Pembayaran</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($result as $value) { ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= ($value['tanggal_invoice']) ? date('d-m-Y', strtotime($value['tanggal_invoice'])) : NULL; ?></td>
                <td><?= $value['nomor_invoice']; ?></td>
                <td class="text-center"><?= ($value['tanggal_jt_bayar']) ? date('d-m-Y', strtotime($value['tanggal_jt_bayar'])) : NULL; ?></td>
                <td class="text-right"><?= number_format($value['grand_total'], 0, ',', '.'); ?></td>
                <td class="text-center"><?= ($value['tanggal']) ? date('d-m-Y', strtotime($value['tanggal'])) : NULL; ?></td>
                <td><?= $value['status_pembayaran']; ?></td>
                <td class="text-center"><?= ($value['tanggal_bayar']) ? date('d-m-Y', strtotime($value['tanggal_bayar'])) : NULL; ?></td>
                <td class="text-right"><?= number_format($value['total_bayar'], 0, ',', '.'); ?></td>
                <td class="text-center col-action">
                    <a href="javascript:void(0)" class="btn btn-info btn-sm btn-detail" data-id="<?= $value['t_inventori_bahan_lab_keluar_masuk']; ?>"><i class="fas fa-list"></i></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $('.btn-detail').click(function() {
        let id = $(this).data('id');
        $.ajax({
            url: "pembayaran/detailPembayaran/" + id,
            success: function(data) {
                $('#modal_view').html(data);
                $('#detail_pembayaran').modal('show');
            }
        })
    });
</script>