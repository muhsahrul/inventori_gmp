<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">No.</th>
            <th class="text-center">Tanggal PO</th>
            <th class="text-center">Nomor PO</th>
            <th class="text-center">Supplier</th>
            <th class="text-center">Tanggal Barang Masuk</th>
            <th class="text-center">Tanggal Invoice</th>
            <th class="text-center">Nomor Invoice</th>
            <th class="text-center">Total Tagihan</th>
            <th class="text-center">Tanggal Jatuh Tempo</th>
            <th class="text-center">Status Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($jatuhtempo as $value) { ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= ($value['tanggal_po']) ? date('d-m-Y', strtotime($value['tanggal_po'])) : NULL; ?></td>
                <td><?= $value['nomor_po']; ?></td>
                <td><?= $value['nama_vendor']; ?></td>
                <td class="text-center"><?= ($value['tanggal']) ? date('d-m-Y', strtotime($value['tanggal'])) : NULL; ?></td>
                <td class="text-center"><?= ($value['tanggal_invoice']) ? date('d-m-Y', strtotime($value['tanggal_invoice'])) : NULL; ?></td>
                <td><?= $value['nomor_invoice']; ?></td>
                <td class="text-right"><?= number_format($value['grand_total'], 0, ',', '.'); ?></td>
                <td class="text-center"><?= ($value['tanggal_jt_bayar']) ? date('d-m-Y', strtotime($value['tanggal_jt_bayar'])) : NULL; ?></td>
                <td class="text-center"><?= $value['status_pembayaran']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<a href="<?= site_url(); ?>report/JatuhTempo/exportExcelReportJatuhTempo?tglawal=<?= $filter_tglawal; ?>&tglakhir=<?= $filter_tglakhir; ?>&status_pembayaran=<?= $filter_status_pembayaran; ?>" class="btn btn-default">Export ke Excel</a>