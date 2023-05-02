<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center">Kode Bahan</th>
            <th class="text-center">Nama Bahan</th>
            <th class="text-center">Nama Bahan (Vendor)</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Stok Penyesuaian</th>
            <th class="text-center">Selisih</th>
            <th class="text-center">Tanggal Penyesuaian</th>
            <th class="text-center">Stok Terbaru</th>
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
                <td class="text-right">
                    <?php
                    if ($value['stok_lama'] > 999) {
                        $str = $value['stok_lama'];
                        $dec = strlen(substr(strrchr($str, "."), 1));
                        echo number_format($value['stok_lama'], $dec, ',', '.');
                    } else {
                        echo str_replace('.', ',', $value['stok_lama']);
                    }
                    ?>
                </td>
                <td class="text-right"><?= $value['stok_baru']; ?></td>
                <td class="text-right"><?= $value['selisih']; ?></td>
                <td class="text-center"><?= $value['tgl_penyesuaian'] ? date('d-m-Y', strtotime($value['tgl_penyesuaian'])) : ''; ?></td>
                <td class="text-right"><?= $value['stok_update']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>