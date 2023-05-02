<div class="modal fade" id="create_bahan_pr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-custom modal-xl" style="overflow-y: scroll; max-width:1455px">
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
            <form action="" method="POST" id="form_create_bahan_pr">
                <?= csrf_field(); ?>
                <div class="modal-body modal-body-custom">
                    <div class="card-body py-0">
                        <input type="hidden" name="id_po" value="<?= $row['id']; ?>">
                        <input type="hidden" name="total" value="<?= $row['total']; ?>">
                        <table class="table table-responsive table-bordered" id="table_bahan">
                            <thead>
                                <tr>
                                    <th width="30%" class="text-center">Nama Bahan (Vendor)</th>
                                    <th width="25%" class="text-center">No. Katalog</th>
                                    <th width="10%" class="text-center">Gramasi</th>
                                    <th width="15%" class="text-center">Harga Satuan</th>
                                    <th width="9%" class="text-center">Jumlah</th>
                                    <th width="15%" class="text-center">Harga Total</th>
                                    <th width="1%" class="text-center"><button type="button" class="btn btn-primary btn-sm" id="add_row"><i class="fas fa-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row_1">
                                    <td>
                                        <select class="form-control select2-full" name="bahan[]" id="bahan_1" data-placeholder="-- Pilih Bahan --" data-row-id="1" id="bahan_1" onchange="getDetailBahan(1)" style="width: 100%">
                                            <option></option>
                                            <?php foreach ($bahan as $value) { ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['kode'] . ' | ' . $value['alias']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select2-full" name="no_katalog[]" id="no_katalog_1" data-placeholder="-- Pilih No. Katalog --" onchange="getGramasi(1)" style="width: 100%">
                                            <option></option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control text-right" name="gramasi[]" id="gramasi_1" readonly></td>
                                    <td><input type="text" class="form-control text-right" name="harga[]" id="harga_1" value="0" onkeyup="getSubtotal(1)" autocomplete="off"></td>
                                    <td><input type="text" class="form-control text-right" name="jumlah[]" id="jumlah_1" value="0" onkeyup="getSubtotal(1)" autocomplete="off"></td>
                                    <td><input type="text" class="form-control text-right" name="subtotal[]" id="subtotal_1" value="0" readonly></td>
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
<script type="text/javascript">
    $(function() {
        $('.select2-full').select2({
            dropdownParent: $('#create_bahan_pr'),
        });
    })

    $("#add_row").unbind('click').bind('click', function() {
        let count_table_tbody_tr = $("#table_bahan tbody tr").length;
        let row_id = count_table_tbody_tr + 1;
        $.ajax({
            url: "<?= site_url(); ?>purchasing/pr/loadDataBahan",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                let html = '<tr id="row_' + row_id + '">' +
                    '<td><select class="form-control select2-full" name="bahan[]" data-placeholder="-- Pilih Bahan --" data-row-id="' + row_id + '" id="bahan_' + row_id + '" onchange="getDetailBahan(' + row_id + ')" style="width: 100%">' +
                    '<option></option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.kode + ' | ' + value.nama + '</option>';
                });
                html += '</select></td>' +
                    '<td><select class="form-control select2-full" name="no_katalog[]" id="no_katalog_' + row_id + '" data-placeholder="-- Pilih No. Katalog --" onchange="getGramasi(' + row_id + ')" style="width: 100%;"><option></option></select></td>' +
                    '<td><input type="text" class="form-control text-right" name="gramasi[]" id="gramasi_' + row_id + '" readonly></td>' +
                    '<td><input type="text" class="form-control text-right" name="harga[]" id="harga_' + row_id + '" value="0" onkeyup="getSubtotal(\'' + row_id + '\')" autocomplete="off"></td>' +
                    '<td><input type="text" class="form-control text-right" name="jumlah[]" id="jumlah_' + row_id + '" value="0" onkeyup="getSubtotal(\'' + row_id + '\')" autocomplete="off"></td>' +
                    '<td><input type="text" class="form-control text-right" name="subtotal[]" id="subtotal_' + row_id + '" value="0" readonly></td>' +
                    '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(\'' + row_id + '\')"><i class="fas fa-times"></i></button></td>' +
                    '</tr>';

                if (count_table_tbody_tr >= 1) {
                    $("#table_bahan tbody tr:last").after(html);
                    $('.select2-full').select2({
                        dropdownParent: $('#create_bahan_pr'),
                    });
                } else {
                    $("#table_bahan tbody").html(html);
                    $('.select2-full').select2({
                        dropdownParent: $('#create_bahan_pr'),
                    });
                }
            }
        })
        return false;
    })

    function removeRow(tr_id) {
        $("#table_bahan tbody tr#row_" + tr_id).remove();
    }

    function getSubtotal(row_id) {
        let subtotal = Number(document.getElementById("harga_" + row_id).value) * Number(document.getElementById("jumlah_" + row_id).value);

        $("#subtotal_" + row_id).val(subtotal);
    }

    function getDetailBahan(row_id) {
        let id_bahan = document.getElementById("bahan_" + row_id).value;
        $.ajax({
            url: "<?= site_url(); ?>purchasing/pr/loadKatalogBahan/" + id_bahan,
            dataType: "JSON",
            success: function(data) {
                let html = '<option></option>';
                $.each(data, function(key, value) {
                    html += '<option value="' + value.id + '">' + value.no_katalog + ' [' + value.vendor + ']</option>';
                })
                $("#no_katalog_" + row_id).html(html);
            }
        });
    }

    function getGramasi(row_id) {
        let id_katalog = document.getElementById("no_katalog_" + row_id).value;
        $.ajax({
            url: "<?= site_url(); ?>purchasing/pr/loadGramasiBahan/" + id_katalog,
            dataType: "JSON",
            success: function(data) {
                $("#gramasi_" + row_id).val(data.gramasi);
            }
        });
    }

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_create_bahan_pr').serialize();
        $.ajax({
            url: "<?= site_url(); ?>purchasing/pr/saveBahanPr",
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#create_bahan_pr').modal('hide');
                    loadDataDetailPr();
                }
            }
        })
    });
</script>