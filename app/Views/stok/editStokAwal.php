<div class="modal fade" id="edit_stok_awal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Stok Awal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_edit_stok_awal">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="card-body py-0">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <div><?= $row['nama']; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Stok Awal</label>
                            <div class="input-group date date-default" id="tanggal" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="tanggal" data-toggle="datetimepicker" data-target="#tanggal" value="<?= $row['tgl_stok_awal'] ? date('d-m-Y', strtotime($row['tgl_stok_awal'])) : ''; ?>" autocomplete="off" />
                                <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Stok Awal</label>
                            <input type="text" class="form-control" name="jumlah" value="<?= $row['stok_awal']; ?>" autocomplete="off" required>
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
        let data = $('#form_edit_stok_awal').serialize();
        let id = "<?= $row['id']; ?>";
        $.ajax({
            url: "stokAwal/updateStokAwal/" + id,
            data: data,
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#edit_stok_awal').modal('hide');
                    loadDataStokAwal();
                }
            }
        })
    });
</script>