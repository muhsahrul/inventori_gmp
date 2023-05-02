<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th width="1%">No.</th>
            <th class="text-center">Tanggal Barang Masuk</th>
            <th class="text-center">Kode Bahan</th>
            <th class="text-center">Nama Bahan (Vendor)</th>
            <th class="text-center">No. Katalog</th>
            <th class="text-center">Gramasi</th>
            <th class="text-center">Harga Satuan</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($result as $value) { ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($value['tanggal'])); ?></td>
                <td class="text-center"><?= $value['kode']; ?></td>
                <td><?= $value['alias']; ?></td>
                <td><?= $value['no_katalog']; ?></td>
                <td class="text-right"><?= $value['gramasi']; ?></td>
                <td class="text-right"><?= $value['jumlah']; ?></td>
                <td class="text-right"><?= number_format($value['harga'], 0, ",", "."); ?></td>
                <td class="text-right"><?= number_format($value['total_harga'], 0, ",", "."); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<a href="<?= site_url(); ?>report/reportBarangMasuk/exportExcelReportBarangMasuk?tglawal=<?= $filter_tglawal; ?>&tglakhir=<?= $filter_tglakhir; ?>" class="btn btn-default">Export ke Excel</a>