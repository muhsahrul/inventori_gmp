<div class="modal fade" id="edit_po" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah PO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_edit_po">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="card-body py-0">
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="nama">Tanggal PO</label>
                                <div class="input-group date date-default" id="tanggal" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tanggal" data-toggle="datetimepicker" data-target="#tanggal" value="<?= ($po['tanggal']) ? date('d-m-Y', strtotime($po['tanggal'])) : ''; ?>" autocomplete="off" />
                                    <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nomor">Nomor PO</label>
                                <input type="text" class="form-control" name="nomor" value="<?= $po['nomor']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nama">Supplier</label>
                                <select class="form-control select2-full" name="vendor" data-placeholder="-- Pilih Supplier --" style="width: 100%">
                                    <option></option>
                                    <?php foreach ($vendor as $value) { ?>
                                        <option value="<?= $value['id']; ?>" <?= ($value['id'] == $po['m_vendor']) ? 'selected' : ''; ?>><?= $value['nama']; ?></option>
                                    <?php } ?>
                                </select>
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

        $('.select2-full').select2({
            dropdownParent: $('#edit_po'),
        });
    });

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_edit_po').serialize();
        let id = "<?= $po['id']; ?>";
        $.ajax({
            url: "po/updatePo/" + id,
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#edit_po').modal('hide');
                    loadDataPo();
                }
            }
        })
    });
</script>