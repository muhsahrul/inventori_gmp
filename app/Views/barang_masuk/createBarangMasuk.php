<div class="modal fade" id="create_barang_masuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-custom modal-xl" style="overflow-y: scroll;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_create_barang_masuk">
                <?= csrf_field(); ?>
                <div class="modal-body modal-body-custom">
                    <div class="card-body py-0">
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="tgl_barang_masuk">Tanggal Barang Masuk</label>
                                <div class="input-group date date-today" id="tanggal" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tgl_barang_masuk" data-toggle="datetimepicker" data-target="#tanggal" autocomplete="off" />
                                    <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tgl_jatuh_tempo">Tanggal Jatuh Tempo Pembayaran</label>
                                <div class="input-group date date-default" id="tanggaljt" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tgl_jatuh_tempo" data-toggle="datetimepicker" data-target="#tanggaljt" autocomplete="off" />
                                    <div class="input-group-append" data-target="#tanggaljt" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nomor_invoice">Nomor Invoice</label>
                                <input type="text" class="form-control" name="nomor_invoice" id="nomor_invoice" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_invoice">Tanggal Invoice</label>
                                <div class="input-group date date-default" id="tanggalinv" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tgl_invoice" data-toggle="datetimepicker" data-target="#tanggalinv" autocomplete="off" />
                                    <div class="input-group-append" data-target="#tanggalinv" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nomor_po">Pilih PO</label>
                                <select class="form-control select2-full" multiple="multiple" name="select_po[]" id="select_po" data-placeholder="-- Pilih Nomor PO --" style="width: 100%">
                                    <option></option>
                                    <?php foreach ($po as $value) { ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['nomor']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="po_table_view"></div>
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
        datepickerDefaultClear();
        datepickerToday();

        $('.select2-full').select2({
            dropdownParent: $('#create_barang_masuk'),
        });
    })

    function numberFormat(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    $('#select_po').val('value').change(function() {
        let id_po = $("#select_po").val();
        if (id_po != "") {
            $.ajax({
                url: "barangMasuk/loadDataPo",
                data: {
                    id_po: id_po
                },
                success: function(data) {
                    $('#po_table_view').html(data);
                    $('#select_po').focusin();
                }
            })
        } else if (id_po == "") {
            $('#po_table_view').empty();
        }
    })

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_create_barang_masuk').serialize();
        $.ajax({
            url: "barangMasuk/saveBarangMasuk",
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#create_barang_masuk').modal('hide');
                    loadDataBarangMasuk();
                }
            }
        })
    });
</script>