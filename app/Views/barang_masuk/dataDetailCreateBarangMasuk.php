<?php

use App\Helpers\QueryTransaksi;

$query = new QueryTransaksi();

foreach ($id_po as $value) {
    $bahan = $query->getDetailPo($value)->getResultArray();
    $data_po = $query->getPo($value)->getRowArray();
?>
    <hr>
    <div class="form-row d-flex justify-content-between">
        <div class="form-group col-md-3">
            <label for="nomor_po">Nomor PO</label>
            <input type="text" class="form-control" name="nomor_po_<?= $value; ?>" value="<?= $data_po['nomor']; ?>" readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="tanggal_po">Tanggal PO</label>
            <input type="text" class="form-control" name="tanggal_po_<?= $value; ?>" value="<?= ($data_po['tanggal']) ? date('d-m-Y', strtotime($data_po['tanggal'])) : ''; ?>" readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="vendor">Supplier</label>
            <input type="hidden" name="vendor_<?= $value; ?>" value="<?= $data_po['m_vendor']; ?>">
            <input type="text" class="form-control" name="nama_vendor_<?= $value; ?>" value="<?= $data_po['nama_vendor']; ?>" readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="grand_total">Total harga</label>
            <input type="text" class="form-control text-right" value="<?= number_format($data_po['grand_total'], 0, ',', '.'); ?>" readonly>
            <input type="hidden" name="grand_total_<?= $value; ?>" value="<?= $data_po['grand_total']; ?>">
        </div>
    </div>
    <table class="table table-responsive table-bordered" id="table_bahan">
        <thead>
            <tr>
                <th width="25%" class="text-center">Bahan</th>
                <th width="15%" class="text-center">No. katalog</th>
                <th width="5%" class="text-center">Gramasi</th>
                <th width="15%" class="text-center">Harga Satuan</th>
                <th width="5%" class="text-center">Jumlah Pesanan</th>
                <th width="15%" class="text-center">Harga Total</th>
                <th width="7%" class="text-center">Total Masuk</th>
                <th width="10%" class="text-center">Jumlah Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_harga = 0;
            foreach ($bahan as $subvalue) {
            ?>
                <tr>
                    <input type="hidden" name="bahan_<?= $value; ?>[]" value="<?= $subvalue['m_inventori_bahan_lab']; ?>">
                    <input type="hidden" name="harga_<?= $value; ?>[]" value="<?= $subvalue['harga']; ?>">
                    <input type="hidden" name="subtotal_<?= $value; ?>[]" value="<?= $subvalue['total_harga']; ?>">
                    <input type="hidden" name="no_katalog_<?= $value; ?>[]" value="<?= $subvalue['m_inventori_bahan_lab_katalog']; ?>">
                    <td><textarea class="form-control" readonly><?= $subvalue['alias']; ?></textarea></td>
                    <td><input type="text" class="form-control" value="<?= $subvalue['no_katalog']; ?>" readonly></td>
                    <td><input type="text" class="form-control" name="gramasi_<?= $value; ?>[]" value="<?= $subvalue['gramasi']; ?>" readonly></td>
                    <td><input type="text" class="form-control text-right" value="<?= number_format($subvalue['harga'], 0, ',', '.'); ?>" readonly></td>
                    <td><input type="text" class="form-control text-right" name="jumlah_<?= $value; ?>[]" value="<?= $subvalue['jumlah']; ?>" readonly></td>
                    <td><input type="text" class="form-control text-right" value="<?= number_format($subvalue['total_harga'], 0, ',', '.'); ?>" readonly></td>
                    <?php
                    $data_barangmasuk = $query->getBarangMasukByPo($value)->getResultArray();

                    $total_masuk = 0;
                    if ($data_barangmasuk) {
                        foreach ($data_barangmasuk as $bmkey => $bmvalue) {
                            $detail_barangmasuk = $query->getTotalMasukBarang($bmvalue['id'], $subvalue['m_inventori_bahan_lab'], $subvalue['jumlah'])->getRowArray();
                            if ($detail_barangmasuk) {
                                $total_masuk += $detail_barangmasuk['jumlah_masuk'];
                            } else {
                                $total_masuk += 0;
                            }
                        }
                    }; ?>
                    <td><input type="text" class="form-control text-right" name="total_masuk_<?= $value; ?>[]" value="<?= $total_masuk; ?>" readonly></td>
                    <td><input type="text" class="form-control text-right" name="jumlah_masuk_<?= $value; ?>[]" min="0" max="<?= $subvalue['jumlah'] - $total_masuk; ?>" <?= ($subvalue['jumlah'] == $total_masuk) ? 'readonly' : ''; ?>></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>