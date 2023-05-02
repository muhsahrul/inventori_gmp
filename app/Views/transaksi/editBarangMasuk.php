<div class="modal fade" id="editBarangMasuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Barang Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_edit_barang_masuk">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="card-body py-0">
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nama">Tanggal Barang Masuk</label>
                                <div class="input-group date date-default" id="tanggal" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tanggal" value="<?= ($barangmasuk['tanggal']) ? date('d-m-Y', strtotime($barangmasuk['tanggal'])) : ''; ?>" data-toggle="datetimepicker" data-target="#tanggal" autocomplete="off" />
                                    <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nomor_invoice">Nomor Invoice</label>
                                <input type="text" class="form-control" name="nomor_invoice" value="<?= $barangmasuk['nomor_invoice']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tgl_invoice">Tanggal Invoice</label>
                                <div class="input-group date date-default" id="tanggalinv" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tgl_invoice" value="<?= ($barangmasuk['tanggal_invoice']) ? date('d-m-Y', strtotime($barangmasuk['tanggal_invoice'])) : ''; ?>" data-toggle="datetimepicker" data-target="#tanggalinv" autocomplete="off" />
                                    <div class="input-group-append" data-target="#tanggalinv" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nama">Supplier</label>
                                <input type="text" class="form-control" name="vendor" value="<?= $barangmasuk['nama_vendor']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tgl_jatuh_tempo">Tanggal Jatuh Tempo</label>
                                <div class="input-group date date-default" id="tanggaljt" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tgl_jatuh_tempo" value="<?= ($barangmasuk['tanggal_jt_bayar']) ? date('d-m-Y', strtotime($barangmasuk['tanggal_jt_bayar'])) : ''; ?>" data-toggle="datetimepicker" data-target="#tanggaljt" autocomplete="off" />
                                    <div class="input-group-append" data-target="#tanggaljt" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        datepickerDefault();
    });

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_edit_barang_masuk').serialize();
        let id = "<?= $barangmasuk['id']; ?>";
        $.ajax({
            url: "barangMasuk/updateBarangMasuk/" + id,
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    toastr.error(response.message);
                } else {
                    toastr.success(response.message);
                    $('#editBarangMasuk').modal('hide');
                    loadDataBarangMasuk();
                }
            }
        })
    });
</script>