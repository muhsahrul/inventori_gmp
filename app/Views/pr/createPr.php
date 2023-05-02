<div class="modal fade" id="create_pr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-custom modal-xl" style="overflow-y: scroll;max-width:1455px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah PR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="overlay-wrapper" hidden>
                <div class="overlay">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
            <form method="POST" id="form_create_pr">
                <div class="modal-body modal-body-custom">
                    <div class="card-body py-0">
                        <div class="form-row d-flex justify-content-between">
                            <div class="form-group col-md-6">
                                <label for="tanggal">Tanggal PR</label>
                                <div class="input-group date date-today" id="tanggal" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tanggal" data-toggle="datetimepicker" data-target="#tanggal" autocomplete="off" />
                                    <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nomor">Nomor PR</label>
                                <input type="hidden" name="nomor_urut" value="<?= $nomor['max_nomor'] + 1; ?>">
                                <input type="text" class="form-control" name="nomor" value="<?= $nomor['max_nomor'] + 1 . '/GMP-PR/PRC' . '/' . $bulan['kode_romawi'] . '/' . date('Y'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nama">Supplier</label>
                                <select class="form-control select2-full" name="vendor" data-placeholder="-- Pilih Supplier --" style="width: 100%">
                                    <option></option>
                                    <?php foreach ($vendor as $value) { ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered" id="table_bahan">
                            <thead>
                                <tr>
                                    <th width="25%" class="text-center">Nama Bahan (Vendor)</th>
                                    <th width="25%" class="text-center">No. Katalog</th>
                                    <th width="10%" class="text-center">Gramasi</th>
                                    <th width="15%" class="text-center">Harga Satuan</th>
                                    <th width="9%" class="text-center">Jumlah</th>
                                    <th width="15%" class="text-center">Harga Total</th>
                                    <th width="1%" class="text-center"><button type="button" class="btn btn-primary btn-sm" id="add_row"><i class="fas fa-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_bahan">
                                <tr id="row_1">
                                    <td>
                                        <select class="form-control select2-full" name="bahan[]" id="bahan_1" data-placeholder="-- Pilih Bahan --" data-row-id="1" onchange="getDetailBahan(1)" style="width: 100%">
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
                        <table class="table table-responsive table-borderless">
                            <tr>
                                <td width="65%" rowspan="4" class="pl-0">
                                    <label>Catatan :</label>
                                    <textarea rows="3" class="form-control" name="note"></textarea>
                                </td>
                                <th width="20%" class="text-right"><label class="text-right">Total</label></th>
                                <td width="18%" class="pr-0 pb-0"><input type="text" class="form-control text-right" name="total" id="total" readonly></td>
                            </tr>
                            <tr class="text-right">
                                <th class="text-right">
                                    <div class="form-row d-flex justify-content-end align-items-center">
                                        <label class="text-right pr-2">Diskon</label>
                                        <input type="text" class="form-control text-right" name="diskon_persen" id="diskon_persen" style="width: 50px;"><label class="pl-1">%</label>
                                    </div>
                                </th>
                                <td class="pr-0 pb-0"><input type="text" class="form-control text-right" name="diskon_rupiah" id="diskon_rupiah" onkeyup="changeDiscount()"></td>
                            </tr>
                            <tr>
                                <th class="text-right"><label class="text-right">PPN (11%)</label></th>
                                <td class="pr-0 pb-0"><input type="text" class="form-control text-right" name="ppn" id="ppn" onkeyup="changePpn()"></td>
                            </tr>
                            <tr>
                                <th class="text-right"><label class="text-right">Grand Total</label></th>
                                <td class="pr-0 pb-0"><input type="text" class="form-control text-right" name="grand_total" id="grand_total" readonly></td>
                            </tr>
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
            dropdownParent: $('#create_pr'),
        });

        datepickerToday();
    })

    $("#add_row").unbind('click').bind('click', function() {
        let count_table_tbody_tr = $("#table_bahan tbody tr").length;
        let row_id = count_table_tbody_tr + 1;
        $.ajax({
            url: "pr/loadDataBahan",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                let html = '<tr id="row_' + row_id + '">' +
                    '<td><select class="form-control select2-full" name="bahan[]" data-placeholder="-- Pilih Bahan --" data-row-id="' + row_id + '" id="bahan_' + row_id + '" onchange="getDetailBahan(' + row_id + ')" style="width: 100%">' +
                    '<option></option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.kode + ' | ' + value.alias + '</option>';
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
                        dropdownParent: $('#create_pr'),
                    });
                } else {
                    $("#table_bahan tbody").html(html);
                    $('.select2-full').select2({
                        dropdownParent: $('#create_pr'),
                    });
                }
            }
        })
        return false;
    })

    function removeRow(tr_id) {
        $("#table_bahan tbody tr#row_" + tr_id).remove();
    }

    function getDetailBahan(row_id) {
        let id_bahan = document.getElementById("bahan_" + row_id).value;
        $("#gramasi_" + row_id).val('');
        $.ajax({
            url: "pr/loadKatalogBahan/" + id_bahan,
            dataType: "JSON",
            success: function(data) {
                let html = '<option></option>';
                $.each(data, function(key, value) {
                    html += '<option value="' + value.id + '" data-gramasi="' + value.gramasi + '">' + value.no_katalog + ' [' + value.vendor + ']</option>';
                })
                $("#no_katalog_" + row_id).html(html);
            }
        });
    }

    function getGramasi(row_id) {
        let gramasi = $("#no_katalog_" + row_id).find(":selected").data("gramasi");
        $("#gramasi_" + row_id).val(gramasi);
    }

    function getSubtotal(row_id) {
        let subtotal = Number(document.getElementById("harga_" + row_id).value) * Number(document.getElementById("jumlah_" + row_id).value);

        $("#subtotal_" + row_id).val(subtotal);
        getTotal();
    }

    function getTotal() {
        let tableProductLength = $("#tbody_bahan tr").length;
        let total = 0;
        for (x = 0; x < tableProductLength; x++) {
            var tr = $("#tbody_bahan tr")[x];
            var count = $(tr).attr('id');
            count = count.substring(4);

            total = Number(total) + Number($("#subtotal_" + count).val());
        }
        $("#total").val(total);
        $("#ppn").val(parseFloat(total * 0.11));
        $("#grand_total").val(parseFloat(total + (total * 0.11)));
    }

    function changeDiscount() {
        if ($("#diskon_rupiah").val() != "") {
            let total = parseFloat($("#total").val()) - parseFloat($("#diskon_rupiah").val());
            let ppn = parseFloat(total * 0.11);
            let grand_total = parseFloat(total) + parseFloat(ppn);
            $("#ppn").val(ppn);
            $("#grand_total").val(grand_total);
        } else {
            let total = parseFloat($("#total").val());
            let ppn = parseFloat(total * 0.11);
            let grand_total = parseFloat(total) + parseFloat(ppn);
            $("#ppn").val(ppn);
            $("#grand_total").val(grand_total);
        }
    }

    function changePpn() {
        if ($("#ppn").val() == "" || isNaN($("#ppn").val()) == true) {
            errorAlert("PPn Tidak Berisi Nilai/Angka");
            let grand_total = parseFloat($("#total").val()) - parseFloat($("#diskon_rupiah").val()) + parseFloat($("#ppn").val());
            $("#grand_total").val(grand_total);
            $("#btn_submit").attr("disabled", true);
        } else {
            let grand_total = parseFloat($("#total").val()) - parseFloat($("#diskon_rupiah").val()) + parseFloat($("#ppn").val());
            $("#grand_total").val(grand_total);
            $("#btn_submit").attr("disabled", false);
        }
    }

    $('#btn_submit').click(function() {
        $('.overlay-wrapper').attr('hidden', false);
        let data = $('#form_create_pr').serialize();
        $.ajax({
            url: "pr/savePr",
            data: data,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                $('.overlay-wrapper').attr('hidden', true);
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    $('#create_pr').modal('hide');
                    loadDataPr();
                }
            }
        })
    });
</script>