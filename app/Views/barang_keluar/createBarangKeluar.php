<div class="modal fade" id="create_barang_keluar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-custom modal-xl" style="overflow-y: scroll;max-width:1455px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form action="" method="POST" id="form_create_barang_keluar">
                <?= csrf_field(); ?>
                <div class="modal-body modal-body-custom">
                    <div class="card-body">
                        <div class="form-group col-4 px-0">
                            <label for="tgl_barang_keluar">Tanggal</label>
                            <div class="input-group date date-today" id="tanggal" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="tanggal" data-toggle="datetimepicker" data-target="#tanggal" autocomplete="off" />
                                <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered" id="table_bahan">
                            <thead>
                                <tr>
                                    <th width="27%" class="text-center">Bahan</th>
                                    <th width="10%" class="text-center">Satuan</th>
                                    <th width="15%" class="text-center">Jumlah Keluar</th>
                                    <th width="27%" class="text-center">Parameter</th>
                                    <th width="15%" class="text-center">Keterangan</th>
                                    <th width="1%" class="text-center"><button type="button" class="btn btn-primary btn-sm" id="add_row"><i class="fas fa-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row_1">
                                    <td>
                                        <select class="form-control select2-full" name="bahan[]" data-placeholder="-- Pilih Bahan --" data-row-id="1" id="bahan_1" onchange="getDetailBahan(1)" style="width: 100%">
                                            <option></option>
                                            <?php foreach ($bahan as $value) { ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['kode'] . ' | ' . $value['nama']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="satuan[]" id="satuan_1" readonly></td>
                                    <td><input type="text" class="form-control" name="jumlah[]" id="jumlah_1" value="0" autocomplete="off"></td>
                                    <td>
                                        <select class="form-control select2-full" name="parameter[]" data-placeholder="-- Pilih Parameter --" data-row-id="1" id="parameter_1" style="width: 100%">
                                            <option></option>
                                            <?php foreach ($parameter as $value) { ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td><textarea type="text" class="form-control" name="keterangan[]" id="keterangan_1"></textarea></td>
                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(1)"><i class="fas fa-times"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
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
        datepickerToday();
        $('.select2-full').select2({
            dropdownParent: $('#create_barang_keluar'),
        });
    })

    $("#add_row").unbind('click').bind('click', function() {
        let count_table_tbody_tr = $("#table_bahan tbody tr").length;
        let row_id = count_table_tbody_tr + 1;
        $.ajax({
            url: "barangKeluar/loadDataBahan",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                let html =
                    '<tr id="row_' + row_id + '">' +
                    '<td><select class="form-control select2-full" name="bahan[]" data-placeholder="-- Pilih Bahan --" data-row-id="' + row_id + '" id="bahan_' + row_id + '" onchange="getDetailBahan(' + row_id + ')" style="width: 100%">' +
                    '<option></option>';
                $.each(data.data_bahan, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.kode + ' | ' + value.nama + '</option>';
                });
                html += '</select></td>' +
                    '<td><input type="text" class="form-control" name="satuan[]" id="satuan_' + row_id + '" readonly></td>' +
                    '<td><input type="text" class="form-control" name="jumlah[]" id="jumlah_' + row_id + '" value="0" autocomplete="off"></td>' +
                    '<td><select class="form-control select2-full" name="parameter[]" data-placeholder="-- Pilih Parameter --"  style="width: 100%;" data-row-id="' + row_id + '" id="parameter_' + row_id + '">' +
                    '<option></option>';
                $.each(data.data_parameter, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.nama + '</option>';
                });
                html += '</select></td>' +
                    '<td><textarea type="text" class="form-control" name="keterangan[]" id="keterangan_' + row_id + '"></textarea></td>' +
                    '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(\'' + row_id + '\')"><i class="fas fa-times"></i></button></td>' +
                    '</tr>';

                if (count_table_tbody_tr >= 1) {
                    $("#table_bahan tbody tr:last").after(html);
                    $('.select2-full').select2({
                        dropdownParent: $('#create_barang_keluar'),
                    });
                } else {
                    $("#table_bahan tbody").html(html);
                    $('.select2-full').select2({
                        dropdownParent: $('#create_barang_keluar'),
                    });
                }
            }
        })
    })

    function removeRow(tr_id) {
        $("#table_bahan tbody tr#row_" + tr_id).remove();
    }

    function getDetailBahan(row_id) {
        let id_bahan = $("#bahan_" + row_id).val();
        $.ajax({
            url: "barangKeluar/loadDetailBahan",
            data: {
                id_bahan: id_bahan
            },
            dataType: "JSON",
            success: function(data) {
                $("#satuan_" + row_id).val(data.nama_satuan);
            }
        });
    }

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_create_barang_keluar').serialize();
        $.ajax({
            url: "barangKeluar/saveBarangKeluar",
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#create_barang_keluar').modal('hide');
                    loadDataBarangKeluar();
                }
            }
        })
    });
</script>