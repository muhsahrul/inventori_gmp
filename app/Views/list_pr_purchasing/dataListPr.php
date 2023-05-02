<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">No.</th>
            <th class="text-center">Tanggal PR</th>
            <th class="text-center">Nomor PR</th>
            <th class="text-center">Supplier</th>
            <th class="text-center">Total PR</th>
            <th class="text-center">Status Validasi</th>
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
                <td class="text-center"><?= $value['status_validasi']; ?></td>
                <td class="text-center col-action">
                    <a href="javascript:void(0)" class="btn btn-info btn-sm btn-detail" data-id="<?= $value['id']; ?>" title="Detail PR"><i class="fas fa-list"></i></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $('.btn-detail').click(function() {
        let id = $(this).data('id');
        $.ajax({
            url: "listPr/detailListPr/" + id,
            success: function(data) {
                $('#modal_view').html(data);
                $('#detail_list_pr').modal('show');
            }
        })
    });
</script>