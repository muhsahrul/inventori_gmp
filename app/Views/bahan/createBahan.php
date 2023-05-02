<div class="modal fade" id="create_bahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Bahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_create_bahan">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="card-body py-0">
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control" name="kode" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="alias">Nama Alias untuk Vendor</label>
                            <input type="text" class="form-control" name="alias" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select class="form-control select2-min" name="satuan" data-placeholder="-- Pilih Satuan --" style="width: 100%">
                                <option></option>
                                <?php foreach ($satuan as $value) { ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                <?php } ?>
                            </select>
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
        select2Min();
    })

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_create_bahan').serialize();
        $.ajax({
            url: "bahan/saveBahan",
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#create_bahan').modal('hide');
                    loadDataBahan();
                }
            }
        })
    });
</script>