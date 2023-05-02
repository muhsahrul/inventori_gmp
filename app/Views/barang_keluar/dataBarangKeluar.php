<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr class="text-center">
            <th class="text-center">No.</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Kode Bahan</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">Jumlah Keluar</th>
            <th class="text-center">Parameter Uji</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Petugas</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($result as $value) { ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($value['tanggal'])); ?></td>
                <td class="text-center"><?= $value['kode']; ?></td>
                <td><?= $value['nama']; ?></td>
                <td><?= $value['satuan']; ?></td>
                <td class="text-right"><?php if ($value['jumlah'] > 999) {
                                            $str = $value['jumlah'];
                                            $dec = strlen(substr(strrchr($str, "."), 1));
                                            echo number_format($value['jumlah'], $dec, ',', '.');
                                        } else {
                                            echo str_replace('.', ',', $value['jumlah']);
                                        }; ?></td>
                <td><?= $value['nama_parameter']; ?></td>
                <td><?= $value['keterangan']; ?></td>
                <td><?= $value['nama_pegawai']; ?></td>
                <td class="text-center col-action">
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id="<?= $value['id']; ?>" data-nama="<?= $value['nama']; ?>"><i class="fas fa-trash-alt"></i></a>
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
    $('.btn-delete').click(function() {
        let nama = $(this).data('nama');
        let x = confirm("Apakah ingin menghapus \"" + nama + "\"?");
        if (x) {
            $('.overlay-wrapper').attr('hidden', false);
            let id = $(this).data('id');
            $.ajax({
                url: "barangKeluar/deleteBarangKeluar/" + id,
                dataType: "JSON",
                success: function(response) {
                    $('.overlay-wrapper').attr('hidden', true);
                    if (response.error) {
                        errorAlert(response.message);
                    } else {
                        successAlert(response.message);
                        loadDataBarangKeluar();
                    }
                }
            })
        }
    });
</script>