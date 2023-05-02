<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">No.</th>
            <th class="text-center">Tanggal PO</th>
            <th class="text-center">Nomor PO</th>
            <th class="text-center">Supplier</th>
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
        foreach ($result as $value) {
            $data_param = $query->getBahanDetailPr($value['id'])->getResultArray();
            foreach ($data_param as $subvalue) { ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td class="text-center"><?= ($value['tanggal']) ? date('d-m-Y', strtotime($value['tanggal'])) : NULL; ?></td>
                    <td class="text-left"><?= $value['nomor']; ?></td>
                    <td class="text-left"><?= $value['nama_vendor']; ?></td>
                    <td class="text-left"><?= $subvalue['alias']; ?></td>
                    <td class="text-center"><?= $subvalue['no_katalog']; ?></td>
                    <td class="text-center"><?= $subvalue['gramasi']; ?></td>
                    <td class="text-right"><?= number_format($subvalue['harga'], 0, ',', '.'); ?></td>
                    <td class="text-center"><?= $subvalue['jumlah']; ?></td>
                    <td class="text-right"><?= number_format($subvalue['total_harga'], 0, ',', '.'); ?></td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>
<a href="<?= site_url(); ?>purchasing/po/exportExcelPo?tglawal=<?= $filter_tglawal; ?>&tglakhir=<?= $filter_tglakhir; ?>" class="btn btn-default">Export ke Excel</a>
<div class="overlay-wrapper" hidden>
    <div class="overlay">
        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
    </div>
</div>