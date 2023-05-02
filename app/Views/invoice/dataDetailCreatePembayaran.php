<?php

use App\Helpers\QueryGa;

$query = new QueryGa();

$total = 0;
foreach ($data_po as $key => $value) {
?>
    <hr>
    <input type="hidden" name="id_inv[]" value="<?= $value['id']; ?>">
    <input type="hidden" name="id_purchasing[]" value="<?= $value['t_po_purchasing']; ?>">
    <div class="form-row d-flex justify-content-between">
        <div class="form-group col-md-4">
            <label for="nomor_po">Nomor PO</label>
            <input type="text" class="form-control" name="nomor_po[]" value="<?= $value['nomor_po']; ?>" readonly>
        </div>
        <div class="form-group col-md-4">
            <label for="tanggal_po">Tanggal PO</label>
            <input type="date" class="form-control" name="tanggal_po[]" value="<?= $value['tanggal_po']; ?>" readonly>
        </div>
        <div class="form-group col-md-4">
            <label for="vendor">Supplier</label>
            <input type="hidden" name="vendor[]" value="<?= $value['m_vendor']; ?>">
            <input type="text" class="form-control" name="nama_vendor[]" value="<?= $value['nama_vendor']; ?>" readonly>
        </div>
    </div>
    <table class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th width="25%" class="text-center">Bahan</th>
                <th width="15%" class="text-center">No. katalog</th>
                <th width="15%" class="text-center">Harga Satuan</th>
                <th width="5%" class="text-center">Jumlah Pesanan</th>
                <th width="15%" class="text-center">Harga Total</th>
                <th width="5%" class="text-center">Jumlah Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $bahan = $query->getBahanDetailBarangMasuk($value['id'])->getResultArray();
            foreach ($bahan as $subvalue) {
                $total += $subvalue['total_harga'];
            ?>
                <tr>
                    <input type="hidden" name="bahan[]" value="<?= $subvalue['m_inventori_bahan_lab']; ?>">
                    <input type="hidden" name="harga[]" value="<?= $subvalue['harga']; ?>">
                    <input type="hidden" name="subtotal[]" value="<?= $subvalue['total_harga']; ?>">
                    <td><textarea class="form-control text-left" readonly><?= $subvalue['nama_bahan']; ?></textarea></td>
                    <td><input type="text" class="form-control text-left" value="<?= $subvalue['no_katalog']; ?>" readonly></td>
                    <td><input type="text" class="form-control text-right" value="<?= number_format($subvalue['harga'], 0, ',', '.'); ?>" readonly></td>
                    <td><input type="text" class="form-control text-right" name="jumlah[]" value="<?= $subvalue['jumlah']; ?>" readonly></td>
                    <td><input type="text" class="form-control text-right" value="<?= number_format($subvalue['total_harga'], 0, ',', '.'); ?>" readonly></td>
                    <td class="text-center"><input type="text" class="form-control text-right" value="<?= $subvalue['jumlah_masuk']; ?>" readonly></td>
                </tr>
            <?php } ?>
            <input type="hidden" name="total_po[]" value="<?= $value['grand_total']; ?>">
        </tbody>
    </table>
<?php } ?>
<input type="hidden" id="total" value="<?= $total; ?>">