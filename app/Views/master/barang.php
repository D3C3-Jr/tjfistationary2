<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $jumlahStokMinim ?> Barang</h3>

                <p>Stok kurang dari 10</p>
            </div>
            <div class="icon">
                <i class="fas fa-cart-arrow-down"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?= $jumlahBarang ?> Barang</h3>

                <p>Jumlah Barang</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('title') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('subtitle') ?>
Data Barang
<?= $this->endSection('subtitle') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php elseif (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Error!</h5>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<form action="<?= base_url() ?>exportExcelBarang" method="post">
    <a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="reloadBarang()"><i class="fas fa-sync"></i></a>
    <a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="addBarang()"><i class="fas fa-plus"> </i> Tambah Data</a>
    <button class="btn btn-sm btn-default my-2"><i class="fas fa-file-excel"> </i> Export All</button>
    <a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="importBarang()"><i class="fas fa-plus"> </i> Import Data</a>
</form>

<table class="table-sm table-striped" id="tableBarang">
    <thead>
        <tr class="ligth">
            <th width="5%">No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Stok</th>
            <th>Harga</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formBarang" enctype="multipart/form-data">
                <input type="hidden" name="barang_id" id="barang_id">
                <div class="modal-body">
                    <div class="row mb-1">
                        <label for="barang_kode" class="col-sm-4 col-form-label">Kode Barang</label>
                        <div class="col-sm-8">
                            <input type="text" name="barang_kode" class="form-control form-control-sm" id="barang_kode">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="barang_nama" class="col-sm-4 col-form-label">Nama Barang</label>
                        <div class="col-sm-8">
                            <input type="text" name="barang_nama" class="form-control form-control-sm" id="barang_nama">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="barang_id_kategori" class="col-sm-4 col-form-label">Kategori Barang</label>
                        <div class="col-sm-8">
                            <select name="barang_id_kategori" id="barang_id_kategori" class="form-control form-control-sm">
                                <option selected hidden disabled>Pilih Kategori</option>
                                <?php foreach ($kategoris as $kategori) : ?>
                                    <option value="<?= $kategori['kategori_id'] ?>"><?= $kategori['kategori_nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="barang_id_satuan" class="col-sm-4 col-form-label">Satuan Barang</label>
                        <div class="col-sm-8">
                            <select name="barang_id_satuan" id="barang_id_satuan" class="form-control form-control-sm">
                                <option selected hidden disabled>Pilih Kategori</option>
                                <?php foreach ($satuans as $satuan) : ?>
                                    <option value="<?= $satuan['satuan_id'] ?>"><?= $satuan['satuan_nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="barang_stok" class="col-sm-4 col-form-label">Stok Barang</label>
                        <div class="col-sm-8">
                            <input type="text" name="barang_stok" class="form-control form-control-sm" id="barang_stok">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="barang_harga" class="col-sm-4 col-form-label">Harga Barang</label>
                        <div class="col-sm-8">
                            <input type="text" name="barang_harga" class="form-control form-control-sm" id="barang_harga">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeBarang" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary" onclick="saveBarang()"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="/importBarangExcel" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="fileexcel" required accept=".xls, .xlsx">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="closeBarang" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection('content') ?>