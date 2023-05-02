<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center">Kode Bahan</th>
            <th class="text-center">No. Katalog</th>
            <th class="text-center">Nama Bahan</th>
            <th class="text-center">Nama Bahan (Vendor)</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">Gramasi</th>
            <th class="text-center">Vendor</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($result as $value) { ?>
            <tr>
                <td class="text-center"><?= $value['kode']; ?></td>
                <td class="text-center"><?= $value['no_katalog']; ?></td>
                <td><?= $value['nama_bahan']; ?></td>
                <td><?= $value['alias']; ?></td>
                <td class="text-center"><?= $value['satuan']; ?></td>
                <td class="text-right"><?= number_format($value['gramasi'], 0, ',', '.'); ?></td>
                <td><?= $value['vendor']; ?></td>
                <td class="text-center col-action">
                    <a href="javascript:void(0)" class="btn btn-warning btn-sm btn-edit" data-id="<?= $value['id']; ?>"><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id="<?= $value['id']; ?>" data-nama="<?= $value['no_katalog']; ?>"><i class="fas fa-trash-alt"></i></a>
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
            url: "katalog/editKatalog/" + id,
            success: function(data) {
                $('#modal_view').html(data);
                $('#edit_katalog').modal('show');
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
                url: "katalog/deleteKatalog/" + id,
                dataType: "JSON",
                success: function(response) {
                    $('.overlay-wrapper').attr('hidden', true);
                    if (response.error) {
                        errorAlert(response.message);
                    } else {
                        successAlert(response.message);
                        loadDataKatalog();
                    }
                }
            })
        }
    });
</script>