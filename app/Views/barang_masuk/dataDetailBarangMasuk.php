<div class="card-body table-responsive p-0">
    <table class="table table-borderless">
        <tr>
            <th width="25%">Nomor PO<span class="float-right"> :</span></th>
            <td><?= ($row['tanggal']) ? date('d-m-Y', strtotime($row['tanggal'])) : NULL; ?></td>
        </tr>
    </table>
    <table class="table table-hover table-bordered" id="table_bahan">
        <thead>
            <tr>
                <th width="1%">No.</th>
                <th>Kode</th>
                <th>Bahan</th>
                <th>Satuan</th>
                <th>No. Katalog</th>
                <th>Harga Satuan</th>
                <th>Jumlah Pesanan</th>
                <th>Harga Total</th>
                <th>Jumlah Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($result as $value) { ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td class="text-center"><?= $value['kode']; ?></td>
                    <td><?= $value['alias']; ?></td>
                    <td><?= $value['nama_satuan']; ?></td>
                    <td><?= $value['no_katalog']; ?></td>
                    <td class="text-right"><?= number_format($value['harga'], 0, ',', '.'); ?></td>
                    <td class="text-right"><?= $value['jumlah']; ?></td>
                    <td class="text-right"><?= number_format($value['total_harga'], 0, ',', '.'); ?></td>
                    <td class="text-right"><?= $value['jumlah_masuk']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>