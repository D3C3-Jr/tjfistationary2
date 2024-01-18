<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Managemen Kategori
<?= $this->endSection('title') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('subtitle') ?>
Data Kategori
<?= $this->endSection('subtitle') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('content') ?>
<a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="reloadKategori()"><i class="fas fa-sync"></i></a>
<a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="addKategori()"><i class="fas fa-plus"> </i> Tambah Data</a>
<table class="table-sm table-striped" id="tableKategori" >
    <thead>
        <tr class="ligth">
            <th width="5%">No</th>
            <th>Nama Kategori</th>
            <th class="text-center" width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="modalKategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formKategori" enctype="multipart/form-data">
                <input type="hidden" name="kategori_id" id="kategori_id">
                <div class="modal-body">
                    <div class="row mb-1">
                        <label for="kategori_nama" class="col-sm-4 col-form-label">Nama Kategori</label>
                        <div class="col-sm-8">
                            <input type="text" name="kategori_nama" class="form-control form-control-sm" id="kategori_nama">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeKategori" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary" onclick="saveKategori()"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection('content') ?>