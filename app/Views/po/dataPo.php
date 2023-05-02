<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">No.</th>
            <th class="text-center">Tanggal PO</th>
            <th class="text-center">Nomor PO</th>
            <th class="text-center">Supplier</th>
            <th class="text-center">Total PO</th>
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
                <td class="text-left"><?= $value['nomor']; ?></td>
                <td class="text-left"><?= $value['nama_vendor']; ?></td>
                <td class="text-right"><?= number_format($value['grand_total'], 0, ',', '.'); ?></td>
                <td class="text-center col-action">
                    <a href="<?= site_url(); ?>purchasing/po/detailPo/<?= $value['id']; ?>" class="btn btn-info btn-sm btn-detail" data-id="<?= $value['id']; ?>" target="_blank"><i class="fas fa-list"></i></a>
                    <a href="<?= site_url(); ?>purchasing/po/printPo/<?= $value['id']; ?>" type="button" class="btn btn-sm btn-success" target="_blank"><i class="fas fa-print"></i></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<a href="<?= site_url(); ?>purchasing/po/exportExcelPo?tglawal=<?= $filter_tglawal; ?>&tglakhir=<?= $filter_tglakhir; ?>" class="btn btn-default">Export ke Excel</a>
<div class="overlay-wrapper" hidden>
    <div class="overlay">
        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
    </div>
</div>
<script>
    // $('.btn-edit').click(function() {
    //     let id = $(this).data('id');
    //     $.ajax({
    //         url: "po/editPo/" + id,
    //         success: function(data) {
    //             $('#showModal').html(data);
    //             $('#edit_po').modal('show');
    //         }
    //     })
    // });

    // $('.btn-delete').click(function() {
    //     let nomor = $(this).data('nomor');
    //     let x = confirm("Apakah ingin menghapus \"" + nomor + "\"?");
    //     if (x) {
    //         $('.overlay-wrapper').attr('hidden', false);
    //         let id = $(this).data('id');
    //         $.ajax({
    //             url: "po/deletePo/" + id,
    //             dataType: "JSON",
    //             success: function(response) {
    //                 $('.overlay-wrapper').attr('hidden', true);
    //                 if (response.error) {
    //                     toastr.error(response.message);
    //                 } else {
    //                     toastr.success(response.message);
    //                     loadDataPo();
    //                 }
    //             }
    //         })
    //     }
    // });
</script>