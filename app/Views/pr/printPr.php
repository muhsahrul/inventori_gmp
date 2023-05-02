<style type="text/css">
    #logo {
        height: 120px;
        margin-bottom: 50px;
        width: 100%;
        border-top-style: none;
        border-right-style: none;
        border-bottom-style: none;
        border-left-style: none;
    }

    #isi {
        font-size: 12pt;
    }

    #isi-table {
        padding: 2px;
    }

    .tr-title {
        font-size: 8pt;
        color: #000;
        background-color: #6BA5F2;
    }

    #footer-tanggal {
        color: #000;
        margin-top: 40px;
        margin-left: 450px;
        font-size: 8pt;
    }

    #footer-jabatan {
        color: #000;
        font-size: 8pt;
        margin-left: 450px;
        margin-bottom: 70px;
    }

    #footer-nama {
        color: #000;
        font-size: 8pt;
        margin-left: 450px;
        text-decoration: underline;
        font-weight: bold;
    }

    body {
        /* font-family: sans-serif; */
        color: #000;
        /* text-align: center; */
    }

    table {
        width: 100%;
        text-align: left;
    }

    th {
        text-align: center;
        /* background: #6BA5F2; */
    }


    th,
    td {
        padding: 2px;
        font-family: Times, serif;
    }

    .tabel-isi {
        padding: 4px;
    }

    ul,
    li,
    p {
        text-align: left;
        font-family: Times;
    }
</style>
<?php

use App\Helpers\QueryPurchasing;

$query = new QueryPurchasing();

$result = $query->getBahanDetailPr($row['id'])->getResultArray();
?>
<div id="isi">
    <table border="0" cellspacing="0" style="width: 100%; text-align: center;">
        <col style="width:100%">
        <tr>
            <td align="center">
                <img width="615" src="<?= base_url(); ?>/assets/img/kop_new.png" alt="Logo">
            </td>
        </tr>
    </table>
    <br>
    <!-- <hr> -->
    <table border="0" cellpadding="0" cellspacing="0">
        <col style="width: 15%">
        <col style="width: 45%">
        <col style="width: 40%">
        <tbody>
            <tr>
                <td>Nomor</td>
                <td>: <?= $row['nomor']; ?></td>
                <td>Mojokerto, <?= date('d', strtotime($row['tanggal'])) . ' ' . $row['nama_bulan'] . ' ' . date('Y', strtotime($row['tanggal'])); ?></td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>: <i>Purchase Requisition</i></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Kepada Yth.</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><?= $row['nama_vendor']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><?= $row['alamat_vendor']; ?></td>
            </tr>
        </tbody>
    </table>

    <br>
    <br>
    <br>
    <p style="margin-bottom:0">Dengan Hormat,</p>
    <p>Bersama ini kami kirimkan purchase requisition (PR) untuk bahan sebagaimana tersebut di bawah ini:</p>
    <br>
    <table border="0.3" cellspacing="0" class="table-isi">
        <col style="width: 5%">
        <col style="width: 28%">
        <col style="width: 17%">
        <col style="width: 17.5%">
        <col style="width: 15%">
        <col style="width: 17.5%">
        <thead style="background:#FFF">
            <tr>
                <th width="1%">No</th>
                <th align="center">Nama Bahan</th>
                <th align="center">No. Katalog</th>
                <th align="center">Harga Satuan</th>
                <th align="center">Jumlah</th>
                <th align="center">Harga Total</th>
            </tr>
        </thead>
        <?php
        $no = 1;
        foreach ($result as $value) { ?>
            <tr>
                <td align="center"><?= $no++; ?></td>
                <td align="left"><?= $value['alias']; ?></td>
                <td align="center"><?= $value['no_katalog']; ?></td>
                <td align="right"><?= number_format($value['harga'], 0, ',', '.'); ?></td>
                <td align="center"><?= $value['jumlah']; ?></td>
                <td align="right"><?= number_format($value['total_harga'], 0, ',', '.'); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td style="height: 12.4px;"> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>
        <tr>
            <td colspan="3" rowspan="<?= $row['diskon_rupiah'] ? '4' : '3'; ?>"><?= $row['note'] ? "Catatan : <br/>" . $row['note'] : ''; ?></td>
            <td colspan="2" align="center "><b>Total</b></td>
            <td align="right"><?= number_format($row['total'], 0, ',', '.'); ?></td>
        </tr>
        <?php if ($row['diskon_rupiah']) { ?>
            <tr>
                <td colspan="2" align="center"><b>Diskon (<?= $row['diskon_persen']; ?>%)</b></td>
                <td align="right"><?= number_format($row['diskon_rupiah'], 0, ',', '.'); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="2" align="center"><b>PPN (<?= $row['ppn'] ? '11' : '0'; ?>%)</b></td>
            <td align="right"><?= number_format($row['ppn'], 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><b>Grand Total</b></td>
            <td align="right"><?= number_format($row['grand_total'], 0, ',', '.'); ?></td>
        </tr>
    </table>
    <p>Demikian atas perhatian dan kerjasama yang baik, kami mengucapkan terima kasih. </p>
    <br>

    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%; text-align: right;">
        <col style="width: 65%">
        <col style="width: 35%">
        <tr style="padding:0;margin:0;">
            <td></td>
            <!-- <td style="height: 12px;padding-right:40px">
                Hormat Kami,
            </td> -->
        </tr>
        <tr>
            <td></td>
            <td>
                <img style="width: 85%;margin-right:30px" src="<?= base_url(); ?>/assets/img/ttd_lia2.png" alt="PT. Graha Mutu Persada">
            </td>
        </tr>
    </table>
</div>