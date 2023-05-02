<div class="modal fade" id="create_bahan_barang_masuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-custom modal-xl" style="overflow-y: scroll;">
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
            <form method="POST" id="form_create_bahan_barang_masuk">
                <?= csrf_field(); ?>
                <div class="modal-body modal-body-custom">
                    <div class="card-body py-0">
                        <input type="hidden" name="id_barang_masuk" value="<?= $barangmasuk['id']; ?>">
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-4">
                                <label for="nama">Tanggal Barang Masuk</label>
                                <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered" id="table_bahan">
                            <thead>
                                <tr>
                                    <th width="15%" class="text-center">Bahan</th>
                                    <th width="5%" class="text-center">Satuan</th>
                                    <th width="10%" class="text-center">Jumlah Masuk</th>
                                    <th width="10%" class="text-center">Harga</th>
                                    <th width="10%" class="text-center">Keterangan</th>
                                    <th width="1%" class="text-center"><button type="button" class="btn btn-primary btn-sm" id="add_row"><i class="fas fa-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row_1">
                                    <td>
                                        <select class="form-control select2-full" name="bahan[]" id="bahan_1" data-placeholder="-- Pilih Bahan --" data-row-id="1" id="bahan_1" onchange="getDetailBahan(1)" style="width: 100%">
                                            <option></option>
                                            <?php foreach ($bahan as $value) { ?>
                                                <option value="<?= $value['id']; ?>"><?= '[' . $value['kode'] . '] ' . $value['alias']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="satuan[]" id="satuan_1" readonly></td>
                                    <td><input type="text" class="form-control" name="jumlah[]" id="jumlah_1" value="0" autocomplete="off"></td>
                                    <td><input type="text" class="form-control" name="harga[]" id="harga_1" value="0" autocomplete="off"></td>
                                    <td><textarea class="form-control" name="keterangan[]" id="keterangan_1"></textarea></td>
                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(1)"><i class="fas fa-times"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" id="btn_submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.select2-full').select2({
            dropdownParent: $('#create_bahan_barang_masuk'),
        });
    })

    $("#add_row").unbind('click').bind('click', function() {
        let count_table_tbody_tr = $("#table_bahan tbody tr").length;
        let row_id = count_table_tbody_tr + 1;
        $.ajax({
            url: "<?= site_url(); ?>transaksi/barangMasuk/loadDataBahan",
            type: "get",
            dataType: "json",
            success: function(data) {
                let html = '<tr id="row_' + row_id + '">' +
                    '<td><select class="form-control select2-full" name="bahan[]" data-placeholder="-- Pilih Bahan --" data-row-id="' + row_id + '" id="bahan_' + row_id + '" onchange="getDetailBahan(' + row_id + ')" style="width: 100%">' +
                    '<option></option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">[' + value.kode + '] ' + value.alias + '</option>';
                });
                html += '</select></td>' +
                    '<td><input type="text" class="form-control" name="satuan[]" id="satuan_' + row_id + '" readonly></td>' +
                    '<td><input type="text" class="form-control" name="jumlah[]" id="jumlah_' + row_id + '" value="0" autocomplete="off"></td>' +
                    '<td><input type="text" class="form-control" name="harga[]" id="harga_' + row_id + '" value="0" autocomplete="off"></td>' +
                    '<td><textarea class="form-control" name="keterangan[]" id="keterangan_' + row_id + '"></textarea></td>' +
                    '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(\'' + row_id + '\')"><i class="fas fa-times"></i></button></td>' +
                    '</tr>';

                if (count_table_tbody_tr >= 1) {
                    $("#table_bahan tbody tr:last").after(html);
                } else {
                    $("#table_bahan tbody").html(html);
                }
                $('.select2-full').select2({
                    dropdownParent: $('#create_bahan_barang_masuk'),
                });
            }
        })
    })

    function removeRow(tr_id) {
        $("#table_bahan tbody tr#row_" + tr_id).remove();
    }

    function getDetailBahan(row_id) {
        let id_bahan = $("#bahan_" + row_id).val();
        $.ajax({
            url: '<?= site_url(); ?>transaksi/barangMasuk/loadDetailBahan',
            data: {
                id_bahan: id_bahan
            },
            dataType: 'json',
            success: function(data) {
                $("#satuan_" + row_id).val(data.nama_satuan);
            }
        });
    }

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_create_bahan_barang_masuk').serialize();
        $.ajax({
            url: "<?= site_url(); ?>transaksi/barangMasuk/saveBahanBarangMasuk",
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#create_bahan_barang_masuk').modal('hide');
                    loadDataDetailBarangMasuk();
                }
            }
        })
    });
</script>