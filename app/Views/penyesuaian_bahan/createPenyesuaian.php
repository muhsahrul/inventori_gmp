<?php
$this->extend('layout/template');
$this->section('content');
?>
<div class="content-wrapper">
    <div class="content pt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title; ?></h3>
                        </div>
                        <form action="<?= site_url(); ?>master/penyesuaian/savePenyesuaian" method="POST">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="tanggal">Tanggal Penyesuaian</label>
                                        <div class="input-group date date-default" id="tanggal" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="tanggal" data-toggle="datetimepicker" data-target="#tanggal" autocomplete="off" required />
                                            <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-responsive table-bordered my-3" id="tabel_bahan">
                                    <thead>
                                        <tr>
                                            <th width="49%" class="text-center">Nama Bahan</th>
                                            <th width="25%" class="text-center">Stok Lama</th>
                                            <th width="25%" class="text-center">Stok Baru</th>
                                            <th width="1%" class="text-center"><button type="button" class="btn btn-primary btn-sm" id="add_row"><i class="fas fa-plus"></i></button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_bahan">
                                        <tr id="row_1">
                                            <td>
                                                <select class="form-control select2-default" name="bahan[]" id="bahan_1" data-placeholder="-- Pilih Bahan --" style="width: 100%;" data-row-id="1" id="bahan_1" onchange="getDetailBahan(1)" required>
                                                    <option></option>
                                                    <?php foreach ($bahan as $value) { ?>
                                                        <option value="<?= $value['id']; ?>"><?= $value['kode'] . ' | ' . $value['nama']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control text-right" name="stok_lama[]" id="stok_lama_1" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control text-right" name="stok_baru[]" id="stok_baru_1">
                                            </td>
                                            <td class="text-right pl-0">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(1)"><i class="fas fa-times"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <a href="<?= site_url(); ?>master/penyesuaian" class="btn btn-default">Batal</a>
                                <button type="submit" class="btn btn-primary float-right">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        datepickerDefault();
        select2Default();
    })

    $("#add_row").unbind('click').bind('click', function() {
        let count_table_tbody_tr = $("#tabel_bahan tbody tr").length;
        let row_id = count_table_tbody_tr + 1;
        $.ajax({
            url: "<?= site_url(); ?>master/penyesuaian/loadBahan",
            dataType: "JSON",
            success: function(data) {
                let html = '<tr id="row_' + row_id + '">' +
                    '<td><select class="form-control select2-default" name="bahan[]" data-placeholder="-- Pilih bahan --" data-row-id="' + row_id + '" id="bahan_' + row_id + '" onchange="getDetailBahan(' + row_id + ')" style="width:100%" required>' +
                    '<option></option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.kode + ' | ' + value.nama + '</option>';
                });
                html += '</select></td>' +
                    '<td><input type="number" class="form-control text-right" name="stok_lama[]" id="stok_lama_' + row_id + '" readonly></td>' +
                    '<td><input type="number" class="form-control text-right" name="stok_baru[]" id="stok_baru_' + row_id + '"></td>' +
                    '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(\'' + row_id + '\')"><i class="fas fa-times"></i></button></td>' +
                    '</tr>';

                if (count_table_tbody_tr >= 1) {
                    $("#tabel_bahan tbody tr:last").after(html);
                } else {
                    $("#tabel_bahan tbody").html(html);
                }
                select2Default();
            }
        })
        return false;
    })

    function removeRow(tr_id) {
        $("#tabel_bahan tbody tr#row_" + tr_id).remove();
    }

    function getDetailBahan(row_id) {
        let id_bahan = $("#bahan_" + row_id).val();
        $.ajax({
            url: "<?= site_url(); ?>master/penyesuaian/loadDetailBahan/" + id_bahan,
            dataType: "JSON",
            success: function(data) {
                $("#stok_lama_" + row_id).val(data);
            }
        });
    }
</script>
<?= $this->endSection(); ?>