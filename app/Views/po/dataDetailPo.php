<div class="card-body table-responsive p-0">
    <table class="table table-hover table-bordered" id="data-table">
        <thead>
            <tr>
                <th width="1%">No.</th>
                <th class="text-center">Nama Bahan</th>
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
                    <td class="text-left"><?= $value['alias']; ?></td>
                    <td class="text-center"><?= $value['no_katalog']; ?></td>
                    <td class="text-center"><?= $value['gramasi']; ?></td>
                    <td class="text-right"><?= number_format($value['harga'], 0, ',', '.'); ?></td>
                    <td class="text-center"><?= $value['jumlah']; ?></td>
                    <td class="text-right"><?= number_format($value['total_harga'], 0, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<table class="table table-borderless">
    <tr>
        <td rowspan="4" class="pl-0">
            <label>Catatan :</label>
            <textarea rows="3" class="form-control" readonly><?= $row['note']; ?></textarea>
        </td>
        <th class="text-right"><label class="text-right">Total</label></th>
        <td width="18%" class="pr-0 pb-0"><input type="text" class="form-control text-right" name="total" id="total" value="<?= number_format($row['total'], 0, ',', '.'); ?>" readonly></td>
    </tr>
    <tr>
        <th class="text-right"><label class="text-right">Diskon (<?= $row['diskon_persen']; ?>%)</label></th>
        <td class="pr-0 pb-0"><input type="text" class="form-control text-right" name="diskon_rupiah" id="diskon_rupiah" value="<?= number_format($row['diskon_rupiah'], 0, ',', '.'); ?>" readonly></td>
    </tr>
    <tr>
        <th class="text-right"><label class="text-right">PPN (<?= $row['ppn'] ? '11' : '0'; ?>%)</label></th>
        <td class="pr-0 pb-0"><input type="text" class="form-control text-right" name="ppn" id="ppn" value="<?= number_format($row['ppn'], 0, ',', '.'); ?>" readonly></td>
    </tr>
    <tr>
        <th class="text-right"><label class="text-right">Grand Total</label></th>
        <td class="pr-0 pb-0"><input type="text" class="form-control text-right" name="grand_total" id="grand_total" value="<?= number_format($row['grand_total'], 0, ',', '.'); ?>" readonly></td>
    </tr>
</table>