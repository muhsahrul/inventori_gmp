<div class="modal fade" id="edit_pembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_edit_pembayaran">
                <div class="modal-body modal-body-custom">
                    <div class="card-body py-0">
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="tanggal_bayar">Tanggal Pembayaran</label>
                                <input type="date" class="form-control" name="tanggal_bayar" value="<?= $data['tanggal_bayar']; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nomor_po">Nomor PO</label>
                                <input type="text" class="form-control" name="nomor_po" id="nomor_po" value="<?= $data['nomor_po']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_po">Tanggal PO</label>
                                <input type="date" class="form-control" name="tanggal_po" id="tanggal_po" value="<?= $data['tanggal_po']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nomor_invoice">Nomor Invoice</label>
                                <input type="text" class="form-control" name="nomor_invoice" id="nomor_invoice" value="<?= $data['nomor_invoice']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_invoice">Tanggal Invoice</label>
                                <input type="date" class="form-control" name="tanggal_invoice" id="tanggal_invoice" value="<?= $data['tanggal_invoice']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="vendor">Supplier</label>
                                <input type="text" class="form-control" name="vendor" id="vendor" value="<?= $data['nama_vendor']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo Pembayaran</label>
                                <input type="date" class="form-control" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" value="<?= $data['tanggal_jt_bayar']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="total_harga">Total Tagihan</label>
                                <input type="text" class="form-control text-right" name="total_harga_view" id="total_harga_view" value="<?= number_format($data['total_harga'], 0, ',', '.'); ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="text" class="form-control text-right" name="jumlah_bayar" id="jumlah_bayar" value="<?= number_format($data['jumlah'], 0, ',', '.'); ?>" readonly>
                            </div>
                        </div>
                        <hr class="my-1">
                        <table class="table table-responsive table-bordered" id="table_bahan">
                            <thead>
                                <tr>
                                    <th width="15%" class="text-center">Bahan</th>
                                    <th width="15%" class="text-center">No. Katalog</th>
                                    <th width="15%" class="text-center">Harga Satuan</th>
                                    <th width="15%" class="text-center">Jumlah Pesanan</th>
                                    <th width="15%" class="text-center">Harga Total</th>
                                </tr>
                            </thead>
                            <tbody id="table_body">
                                <?php foreach ($data_bahan as $value) { ?>
                                    <tr>
                                        <td><input type="text" class="form-control" name="nama_bahan[]" value="<?= $value['nama_bahan']; ?>" readonly></td>
                                        <td><input type="text" class="form-control" name="no_katalog[]" value="<?= $value['no_katalog']; ?>" readonly></td>
                                        <td><input type="text" class="form-control text-right" name="harga[]" value="<?= number_format($value['harga'], 0, ',', '.'); ?>" readonly></td>
                                        <td><input type="text" class="form-control text-right" name="jumlah[]" value="<?= $value['jumlah']; ?>" readonly></td>
                                        <td><input type="text" class="form-control text-right" name="subtotal[]" value="<?= number_format($value['total_harga'], 0, ',', '.'); ?>" readonly></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btn_submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_edit_pembayaran').serialize();
        let id = "<?= $data['id']; ?>";
        $.ajax({
            url: "pembayaran/updatePembayaran/" + id,
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#edit_pembayaran').modal('hide');
                    loadDataPembayaran();
                }
            }
        })
    });
</script>