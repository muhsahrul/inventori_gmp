<div class="modal fade" id="create_pembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-custom modal-xl" style="overflow-y: scroll;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_create_pembayaran">
                <?= csrf_field(); ?>
                <div class="modal-body modal-body-custom">
                    <div class="card-body py-0">
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="tgl_bayar">Tanggal Pembayaran</label>
                                <div class="input-group date date-today" id="tanggal" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tgl_bayar" data-toggle="datetimepicker" data-target="#tanggal" autocomplete="off" />
                                    <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo Pembayaran</label>
                                <input type="text" class="form-control" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" readonly>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nomor_invoice">Nomor Invoice</label>
                                <select class="form-control select2-full" name="select_invoice" id="select_invoice" data-placeholder="-- Pilih Nomor Invoice --" style="width: 100%">
                                    <option></option>
                                    <?php foreach ($invoice as $value) { ?>
                                        <option value="<?= $value['nomor_invoice']; ?>"><?= $value['nomor_invoice']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_invoice">Tanggal Invoice</label>
                                <input type="text" class="form-control" name="tanggal_invoice" id="tanggal_invoice" readonly>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-2">
                                <label for="grand_total_invoice">Total Tagihan</label>
                                <input type="text" class="form-control text-right" id="total_invoice" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="ppn_invoice">PPN (11%)</label>
                                <input type="text" class="form-control text-right" name="ppn_invoice" id="ppn_invoice" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="grand_total_invoice">Grand Total</label>
                                <input type="text" class="form-control text-right" id="grand_total_invoice_view" readonly>
                                <input type="hidden" name="grand_total_invoice" id="grand_total_invoice">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="text" class="form-control text-right" name="jumlah_bayar" id="jumlah_bayar" autocomplete="off">
                            </div>
                        </div>
                        <div id="data_po"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" id="btn_submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        datepickerToday();

        $('.select2-full').select2({
            dropdownParent: $('#create_pembayaran'),
        });
    })

    function numberFormat(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    $('#select_invoice').change(function() {
        let invoice = $("#select_invoice").val();
        $.ajax({
            url: "invoice/loadDataInvoiceCreatePembayaran",
            data: {
                invoice: invoice
            },
            dataType: "JSON",
            success: function(data) {
                $('#tanggal_invoice').val(data.invoice.tanggal_invoice);
                $('#tanggal_jatuh_tempo').val(data.invoice.tanggal_jt_bayar);
                $.ajax({
                    url: "invoice/loadDataDetailInvoice",
                    data: {
                        invoice: data.nomor_invoice
                    },
                    success: function(data_po) {
                        $('#data_po').html(data_po);
                        let total_invoice = document.getElementById("total").value;
                        let ppn = total_invoice * 0.11;
                        let grand_total = parseFloat(total_invoice) + parseFloat(ppn);
                        $('#total_invoice').val(numberFormat(total_invoice));
                        $('#ppn_invoice').val(numberFormat(ppn));
                        $('#grand_total_invoice_view').val(numberFormat(grand_total));
                        $('#grand_total_invoice').val(grand_total);
                        $('#jumlah_bayar').val(grand_total);
                    }
                })
            }
        })
    })

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_create_pembayaran').serialize();
        $.ajax({
            url: "invoice/savePembayaran",
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#create_pembayaran').modal('hide');
                    loadDataInvoice();
                }
            }
        })
    });
</script>