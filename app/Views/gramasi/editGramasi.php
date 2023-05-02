<div class="modal fade" id="edit_gramasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Gramasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_edit_gramasi">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="card-body py-0">
                        <div class="form-group">
                            <label for="gramasi">Nama Bahan</label>
                            <div id="lbl_bahan"></div>
                        </div>
                        <div class="form-group">
                            <label for="bahan">Nama Bahan (Vendor)</label>
                            <select class="form-control select2-full" name="bahan" id="bahan" data-placeholder="-- Pilih Bahan --" style="width: 100%">
                                <option></option>
                                <?php foreach ($bahan as $value) { ?>
                                    <option value="<?= $value['id']; ?>" data-bahan="<?= $value['nama']; ?>" <?= ($value['id'] == $row['m_inventori_bahan_lab']) ? 'selected' : ''; ?>><?= $value['alias']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gramasi">Gramasi</label>
                            <input type="number" class="form-control" name="gramasi" value="<?= $row['gramasi']; ?>" autocomplete="off">
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
<script>
    $(function() {
        $('.select2-full').select2({
            dropdownParent: $('#edit_gramasi'),
        });
    })
    
    $('#bahan').change(function() {
        let bahan = $(this).find(':selected').data('bahan')
        $('#lbl_bahan').text(bahan);
    });

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_edit_gramasi').serialize();
        let id = "<?= $row['id']; ?>";
        $.ajax({
            url: "gramasi/updateGramasi/" + id,
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#edit_gramasi').modal('hide');
                    loadDataGramasi();
                }
            }
        })
    });
</script>