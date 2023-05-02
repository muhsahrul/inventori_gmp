<?php

use App\Helpers\QueryGa;

$query = new QueryGa();
?>
<div class="modal fade" id="detail_invoice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body py-0">
                    <div class="form-row d-flex justify-content-between">
                        <div class="form-group col-md-6">
                            <label for="nomor_invoice">Nomor Invoice</label>
                            <input type="text" class="form-control" name="nomor_invoice" id="nomor_invoice" value="<?= $row['nomor_invoice']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal_invoice">Tanggal Invoice</label>
                            <input type="text" class="form-control" name="tanggal_invoice" id="tanggal_invoice" value="<?= ($row['tanggal_invoice']) ? date('d-m-Y', strtotime($row['tanggal_invoice'])) : ''; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row d-flex justify-content-between">
                        <div class="form-group col-md-2">
                            <label for="grand_total_invoice">Total Tagihan</label>
                            <?php
                            $total = 0;
                            foreach ($result as $subvalue) {
                                $detail_po = $query->getTotalByDetailPo($subvalue['id'])->getRowArray();
                                $total += $detail_po['subtotal'];
                            }
                            $ppn = $total * 0.11;
                            $grand_total = $total + $ppn; ?>
                            <input type="text" class="form-control text-right" id="total_invoice" value="<?= number_format($total, 0, ',', '.'); ?>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="ppn_invoice">PPN (11%)</label>
                            <input type="text" class="form-control text-right" name="ppn_invoice" id="ppn_invoice" value="<?= number_format($ppn, 0, ',', '.'); ?>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="grand_total_invoice">Grand Total</label>
                            <input type="text" class="form-control text-right" name="grand_total_invoice" id="grand_total_invoice" value="<?= number_format($grand_total, 0, ',', '.'); ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo Pembayaran</label>
                            <input type="text" class="form-control" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" value="<?= ($row['tanggal_jt_bayar']) ? date('d-m-Y', strtotime($row['tanggal_jt_bayar'])) : ''; ?>" readonly>
                        </div>
                    </div>
                    <?php
                    $grand_total_invoice = 0;
                    foreach ($result as $value) {
                        $bahan = $query->getBahanDetailBarangMasuk($value['id'])->getResultArray();
                        $grand_total_invoice += $value['grand_total']; ?>
                        <hr>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-4">
                                <label for="nomor_po">Nomor PO</label>
                                <input type="text" class="form-control" name="nomor_po[]" value="<?= $value['nomor_po']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tanggal_po">Tanggal PO</label>
                                <input type="text" class="form-control" name="tanggal_po[]" value="<?= ($value['tanggal_po']) ? date('d-m-Y', strtotime($value['tanggal_po'])) : ''; ?>" readonly>
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
                                foreach ($bahan as $subvalue) {
                                ?>
                                    <tr>
                                        <td><textarea class="form-control text-left" readonly><?= $subvalue['nama_bahan']; ?></textarea></td>
                                        <td><input type="text" class="form-control text-left" value="<?= $subvalue['no_katalog']; ?>" readonly></td>
                                        <td><input type="text" class="form-control text-right" value="<?= number_format($subvalue['harga'], 0, ',', '.'); ?>" readonly></td>
                                        <td><input type="text" class="form-control text-right" name="jumlah[]" value="<?= $subvalue['jumlah']; ?>" readonly></td>
                                        <td><input type="text" class="form-control text-right" value="<?= number_format($subvalue['total_harga'], 0, ',', '.'); ?>" readonly></td>
                                        <td class="text-center"><input type="text" class="form-control text-right" value="<?= $subvalue['jumlah_masuk']; ?>" readonly></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>