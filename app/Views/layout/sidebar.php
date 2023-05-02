<div class="sidebar">
    <div class="user-panel ">
        <div class="form-inline my-2">
            <ul class="nav nav-sidebar">
                <li class="nav-header mx-1 pt-0">CABANG :</li>
            </ul>
            <div class="input-group" data-widget="sidebar-search">
                <select class="form-control select2-min" name="cabang" id="cabang" style="width:100%">
                    <?php foreach (filterCabang() as $key => $value) { ?>
                        <option value="<?= $value['id']; ?>" <?= session()->get('cabang_aktif') == $value['id'] ? 'selected' : (session()->get('user_cabang') == $value['id'] ? 'selected' : ''); ?>><?= $value['nama']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <hr>
        </div>
    </div>
    <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="<?= site_url() ?>" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="datamaster" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Data Master<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>master/bahan" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Bahan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>master/satuan" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Satuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>master/katalog" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Katalog - Gramasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>master/vendor" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Vendor</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>master/stokAwal" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Stok Awal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>master/penyesuaian" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Penyesuaian Stok</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="purchasing" class="nav-link">
                    <i class="nav-icon fas fa-clone"></i>
                    <p>Purchasing<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>purchasing/pr" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>PR</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>purchasing/validasiPr" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Validasi PR</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>purchasing/po" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>PO</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>transaksi/barangMasuk" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Barang Masuk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>purchasing/pembelanjaan" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List Pembelanjaan</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="ga" class="nav-link">
                    <i class="nav-icon fas fa-clone"></i>
                    <p>GA<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>ga/invoice" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Invoice Belum Dibayar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>ga/pembayaran" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List Pembayaran</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="teknis" class="nav-link">
                    <i class="nav-icon fas fa-clone"></i>
                    <p>Teknis<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>transaksi/barangKeluar" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Barang Keluar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>teknis/pembelanjaan" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List Pembelanjaan</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="report" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Report<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>report/reportStok" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Report Stok Bahan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>report/reportBahan" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Report Per Bahan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>report/reportParameter" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Report Per Parameter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>report/chartBahan" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Chart Report Bahan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>report/jatuhTempo" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Jatuh Tempo</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>report/reportBarangMasuk" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Report Barang Masuk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url(); ?>report/reportPenyesuaian" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Report Penyesuaian</p>
                        </a>
                    </li>
                </ul>
            </li>
            <?php if (session()->get('user_id') == 2) { ?>
                <li class="nav-item">
                    <a href="<?= site_url(); ?>main/backupDb" class="nav-link">
                        <i class="fas fa-download"></i>
                        <p>Backup DB</p>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>