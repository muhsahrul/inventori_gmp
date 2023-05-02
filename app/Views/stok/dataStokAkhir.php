<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr class="text-center">
            <th class="text-center">Kode Bahan</th>
            <th class="text-center">Nomor Katalog</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">Stok Akhir</th>
            <!-- <th class="text-center" width="10%"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($bahan as $key => $value) { ?>
            <tr>
                <td class="text-center"><?= $value['kode']; ?></td>
                <td class="text-center"><?= $value['no_katalog']; ?></td>
                <td class="text-center"><?= $value['nama']; ?></td>
                <td class="text-center"><?= $value['nama_satuan']; ?></td>
                <td class="text-center"><?= $value['stok_akhir']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<!-- <a href="" class="btn btn-default">Export ke Excel</a> -->