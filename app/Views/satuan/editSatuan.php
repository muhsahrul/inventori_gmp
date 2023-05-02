<div class="modal fade" id="edit_satuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_edit_satuan">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="card-body py-0">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?= $row['nama']; ?>" autocomplete="off">
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
    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_edit_satuan').serialize();
        let id = "<?= $row['id']; ?>";
        $.ajax({
            url: "satuan/updateSatuan/" + id,
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#edit_satuan').modal('hide');
                    loadDataSatuan();
                }
            }
        })
    });
</script>