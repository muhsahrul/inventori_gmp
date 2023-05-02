<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">Kode Bahan</th>
            <th class="text-center">Nama Bahan</th>
            <th class="text-center">Nama Bahan (Vendor)</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">Stok Awal</th>
            <th class="text-center">Tanggal Stok Awal</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($result as $value) { ?>
            <tr>
                <td class="text-center"><?= $value['kode']; ?></td>
                <td><?= $value['nama']; ?></td>
                <td><?= $value['alias']; ?></td>
                <td class="text-center"><?= $value['nama_satuan']; ?></td>
                <td class="text-right"><?= number_format($value['stok_awal'], 4, ',', '.'); ?></td>
                <td class="text-center"><?= $value['tgl_stok_awal'] ? date('d-m-Y', strtotime($value['tgl_stok_awal'])) : ''; ?></td>
                <td class="text-center col-action">
                    <a href="javascript:void(0)" class="btn btn-warning btn-sm btn-edit" data-id="<?= $value['id']; ?>" data-nama="<?= $value['nama']; ?>"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $('.btn-edit').click(function() {
        let id = $(this).data('id');
        $.ajax({
            url: "stokAwal/editStokAwal/" + id,
            success: function(data) {
                $('#modal_view').html(data);
                $('#edit_stok_awal').modal('show');
            }
        })
    });
</script>