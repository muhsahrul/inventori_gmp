<div class="modal fade" id="detail_list_pr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail PR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body py-0">
                    <div class="form-row d-flex justify-content-between">
                        <div class="form-group col-md-6">
                            <label for="nomor_pr">Nomor PR</label>
                            <input type="text" class="form-control" name="nomor_pr" id="nomor_pr" value="<?= $row['nomor']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal">Tanggal PR</label>
                            <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= ($row['tanggal']) ? date('d-m-Y', strtotime($row['tanggal'])) : ''; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row d-flex justify-content-between">
                        <div class="form-group col-md-3">
                            <label for="total">Total</label>
                            <input type="text" class="form-control text-right" name="total" id="total" value="<?= number_format($row['total'], 0, ',', '.'); ?>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="diskon_rupiah">Diskon (<?= $row['diskon_persen']; ?>%)</label>
                            <input type="text" class="form-control text-right" name="diskon_rupiah" id="diskon_rupiah" value="<?= number_format($row['diskon_rupiah'], 0, ',', '.'); ?>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="ppn_invoice">PPN (<?= $row['ppn'] ? '11' : '0'; ?>%)</label>
                            <input type="text" class="form-control text-right" name="ppn_invoice" id="ppn_invoice" value="<?= number_format($row['ppn'], 0, ',', '.'); ?>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="grand_total_invoice">Grand Total</label>
                            <input type="text" class="form-control text-right" name="grand_total_invoice" id="grand_total_invoice" value="<?= number_format($row['grand_total'], 0, ',', '.'); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row d-flex justify-content-between">
                        <div class="form-group col-md-6">
                            <label for="total">Catatan :</label>
                            <textarea class="form-control" readonly><?= $row['note']; ?></textarea>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $subvalue) {
                            ?>
                                <tr>
                                    <td><textarea class="form-control text-left" readonly><?= $subvalue['alias']; ?></textarea></td>
                                    <td><input type="text" class="form-control text-left" value="<?= $subvalue['no_katalog']; ?>" readonly></td>
                                    <td><input type="text" class="form-control text-right" value="<?= number_format($subvalue['harga'], 0, ',', '.'); ?>" readonly></td>
                                    <td><input type="text" class="form-control text-right" name="jumlah[]" value="<?= $subvalue['jumlah']; ?>" readonly></td>
                                    <td><input type="text" class="form-control text-right" value="<?= number_format($subvalue['total_harga'], 0, ',', '.'); ?>" readonly></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>