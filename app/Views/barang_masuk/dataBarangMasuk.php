<?php

use App\Helpers\QueryTransaksi;

$query = new QueryTransaksi();
?>
<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">No.</th>
            <th class="text-center">Tanggal Barang Masuk</th>
            <th class="text-center">Nomor Invoice</th>
            <th class="text-center">Nomor PO</th>
            <th class="text-center">Supplier</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($result as $value) { ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= ($value['tanggal']) ? date('d-m-Y', strtotime($value['tanggal'])) : NULL; ?></td>
                <td class="text-left"><?= $value['nomor_invoice']; ?></td>
                <?php
                $data_po = $query->getPoByInvoice($value['nomor_invoice'])->getResultArray();
                ?>
                <td>
                    <?php
                    // $total = 0;
                    $count_po = array();
                    foreach ($data_po as $subkey => $subvalue) {
                        $detail_po = $query->getTotalByDetailPo($subvalue['id'])->getRowArray();
                        $log_po = $query->getCountNomorPo($subvalue['nomor_po'])->getRowArray();
                        if ((int)$log_po['count_po'] > 1) {
                            $count_po[] = true;
                        } else {
                            $count_po[] = false;
                        }
                    ?>
                        <span class="btn btn-default btn-xs"><?= $subvalue['nomor_po']; ?></span>
                    <?php } ?>
                </td>
                <td class="text-left"><?= $value['nama_vendor']; ?></td>
                <td class="text-center col-action">
                    <a href="<?= site_url(); ?>transaksi/barangMasuk/detailBarangMasuk/<?= $value['id']; ?>" class="btn btn-info btn-sm btn-detail" data-id="<?= $value['id']; ?>" target="_blank"><i class="fas fa-list"></i></a>
                    <a href="javascript:void(0)" class="btn btn-warning btn-sm btn-edit" data-id="<?= $value['id']; ?>"><i class="fas fa-edit"></i></a>
                    <?php if (!in_array(true, $count_po)) { ?>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id="<?= $value['id']; ?>" data-nama="<?= $value['nomor_invoice']; ?>"><i class="fas fa-trash-alt"></i></a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="overlay-wrapper" hidden>
    <div class="overlay">
        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
    </div>
</div>
<script>
    $('.btn-edit').click(function() {
        let id = $(this).data('id');
        $.ajax({
            url: "barangMasuk/editBarangMasuk/" + id,
            success: function(data) {
                $('#modal_view').html(data);
                $('#edit_barang_masuk').modal('show');
            }
        })
    });

    $('.btn-delete').click(function() {
        let nama = $(this).data('nama');
        let x = confirm("Apakah ingin menghapus \"" + nama + "\"?");
        if (x) {
            $('.overlay-wrapper').attr('hidden', false);
            let id = $(this).data('id');
            $.ajax({
                url: "barangMasuk/deleteBarangMasuk/" + id,
                dataType: "JSON",
                success: function(response) {
                    $('.overlay-wrapper').attr('hidden', true);
                    if (response.error) {
                        errorAlert(response.message);
                    } else {
                        successAlert(response.message);
                        loadDataBarangMasuk();
                    }
                }
            })
        }
    });
</script>