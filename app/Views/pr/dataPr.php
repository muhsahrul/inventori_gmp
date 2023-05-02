<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">No.</th>
            <th class="text-center">Tanggal PR</th>
            <th class="text-center">Nomor PR</th>
            <th class="text-center">Supplier</th>
            <th class="text-center">Total PR (Rp)</th>
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
                    <a href="<?= site_url(); ?>purchasing/pr/detailPr/<?= $value['id']; ?>" class="btn btn-info btn-sm btn-detail" data-id="<?= $value['id']; ?>" target="_blank"><i class="fas fa-list"></i></a>
                    <a href="javascript:void(0)" class="btn btn-warning btn-sm btn-edit" data-id="<?= $value['id']; ?>"><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id="<?= $value['id']; ?>" data-nomor="<?= $value['nomor']; ?>"><i class="fas fa-trash-alt"></i></a>
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
            url: "pr/editPr/" + id,
            success: function(data) {
                $('#modal_view').html(data);
                $('#edit_pr').modal('show');
            }
        })
    });

    $('.btn-delete').click(function() {
        let nomor = $(this).data('nomor');
        let x = confirm("Apakah ingin menghapus \"" + nomor + "\"?");
        if (x) {
            $('.overlay-wrapper').attr('hidden', false);
            let id = $(this).data('id');
            $.ajax({
                url: "pr/deletePr/" + id,
                dataType: "JSON",
                success: function(response) {
                    $('.overlay-wrapper').attr('hidden', true);
                    if (response.error) {
                        errorAlert(response.message);
                    } else {
                        successAlert(response.message);
                        loadDataPr();
                    }
                }
            })
        }
    });
</script>