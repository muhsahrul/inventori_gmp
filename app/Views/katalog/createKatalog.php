<div class="modal fade" id="create_katalog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Katalog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_create_katalog">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="card-body py-0">
                        <div class="form-group">
                            <label for="katalog">No. Katalog</label>
                            <input type="text" class="form-control" name="katalog" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="bahan">Nama Bahan (Vendor)</label>
                            <select class="form-control select2-full" name="bahan" id="bahan" data-placeholder="-- Pilih Bahan --" style="width: 100%">
                                <option></option>
                                <?php foreach ($bahan as $value) { ?>
                                    <option value="<?= $value['id']; ?>" data-kode="<?= $value['kode']; ?>" data-bahan="<?= $value['nama']; ?>"><?= $value['alias']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Bahan</label>
                            <div id="lbl_bahan"></div>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode Bahan</label>
                            <div id="lbl_kode"></div>
                        </div>
                        <div class="form-group">
                            <label for="vendor">Nama Vendor</label>
                            <select class="form-control select2-full" name="vendor" data-placeholder="-- Pilih Vendor --" style="width: 100%">
                                <option></option>
                                <?php foreach ($vendor as $value) { ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gramasi">Gramasi</label>
                            <input type="number" min="0" class="form-control" name="gramasi" autocomplete="off">
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
            dropdownParent: $('#create_katalog'),
        });
    })

    $('#bahan').change(function() {
        let bahan = $(this).find(':selected').data('bahan')
        let kode = $(this).find(':selected').data('kode')
        $('#lbl_bahan').text(bahan);
        $('#lbl_kode').text(kode);
    });

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_create_katalog').serialize();
        $.ajax({
            url: "katalog/saveKatalog",
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#create_katalog').modal('hide');
                    loadDataKatalog();
                }
            }
        })
    });
</script>