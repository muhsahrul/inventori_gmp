<div class="modal fade" id="createBarangMasuk" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-custom modal-xl" style="overflow-y: scroll;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="form_create_barang_masuk">
                <?= csrf_field(); ?>
                <div class="modal-body modal-body-custom">
                    <div class="card-body py-0">
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nama">Tanggal Barang Masuk</label>
                                <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo Pembayaran</label>
                                <input type="date" class="form-control" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nomor_invoice">Nomor Invoice</label>
                                <input type="text" class="form-control" name="nomor_invoice" id="nomor_invoice">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_invoice">Tanggal Invoice</label>
                                <input type="date" class="form-control" name="tanggal_invoice" id="tanggal_invoice">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-3">
                                <label for="nomor_po">Nomor PO</label>
                                <input type="hidden" class="form-control" name="nomor_po" id="nomor_po">
                                <select class="form-control select2-full" name="id_po" id="id_po" data-placeholder="- Pilih Nomor PO -">
                                    <option></option>
                                    <?php foreach ($po as $key => $value) { ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['nomor']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="tanggal_po">Tanggal PO</label>
                                <input type="date" class="form-control" name="tanggal_po" id="tanggal_po" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="vendor">Supplier</label>
                                <input type="text" class="form-control" name="vendor" id="vendor" readonly>
                                <input type="hidden" name="id_vendor" id="id_vendor">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="total_harga">Total harga</label>
                                <input type="text" class="form-control text-right" name="total_harga_view" id="total_harga_view" readonly>
                                <input type="hidden" name="total_harga" id="total_harga">
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered" id="table_bahan">
                            <thead>
                                <tr>
                                    <th width="25%" class="text-center">Bahan</th>
                                    <th width="15%" class="text-center">No. katalog</th>
                                    <th width="15%" class="text-center">Harga Satuan</th>
                                    <th width="5%" class="text-center">Jumlah Pesanan</th>
                                    <th width="15%" class="text-center">Harga Total</th>
                                    <th width="7%" class="text-center">Total Masuk</th>
                                    <th width="10%" class="text-center">Jumlah Masuk</th>
                                </tr>
                            </thead>
                            <tbody id="table_body">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.select2-full').select2({
            dropdownParent: $('#createBarangMasuk'),
            theme: 'bootstrap4',
            // minimumResultsForSearch: Infinity,
        });
    })

    function numberFormat(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    $('#id_po').change(function() {
        var id = $("#id_po").val();
        $.ajax({
            url: "barangMasuk/loadDataPo/" + id,
            dataType: "json",
            success: function(data) {
                var id_po = data.data_po.id;
                var barangmasuk = data.data_barangmasuk;
                $('#nomor_po').val(data.data_po.nomor);
                $('#tanggal_po').val(data.data_po.tanggal);
                // if (data.data_master_barangmasuk) {
                //     $('#nomor_invoice').val(data.data_master_barangmasuk.nomor_invoice);
                //     $('#tanggal_invoice').val(data.data_master_barangmasuk.tanggal_invoice);
                //     $('#tanggal_jatuh_tempo').val(data.data_master_barangmasuk.tanggal_jt_bayar);
                // }
                $('#vendor').val(data.data_po.nama_vendor);
                $('#id_vendor').val(data.data_po.m_vendor);

                $('#total_harga').val(data.data_po.grand_total);
                $('#total_harga_view').val(numberFormat(data.data_po.grand_total));
                $.ajax({
                    url: "barangMasuk/loadDataDetailPo/" + id_po,
                    data: {
                        id_po: id_po,
                        barangmasuk: barangmasuk,
                    },
                    success: function(data_bahan) {
                        $('#table_body').html(data_bahan);
                    }
                })
            }
        })
    })

    $('#btn_submit').click(function() {
        var data = $('#form_create_barang_masuk').serialize();
        $.ajax({
            url: "barangMasuk/saveBarangMasuk",
            data: data,
            type: "POST",
            success: function(msg) {
                alert(msg);
                $('#createBarangMasuk').modal('hide');
                loadDataBarangMasuk();
            },
            error: function(msg) {
                alert(msg.responseJSON);
                // alert(msg.responseText);
            }
        })
    });
</script>