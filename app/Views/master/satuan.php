<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Managemen Satuan
<?= $this->endSection('title') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('subtitle') ?>
Data Satuan
<?= $this->endSection('subtitle') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('content') ?>
<a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="reloadSatuan()"><i class="fas fa-sync"></i></a>
<a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="addSatuan()"><i class="fas fa-plus"> </i> Tambah Data</a>
<table class="table-sm table-striped" id="tableSatuan">
    <thead>
        <tr class="ligth">
            <th width="5%">No</th>
            <th>Nama Satuan</th>
            <th class="text-center" width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="modalSatuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formSatuan" enctype="multipart/form-data">
                <input type="hidden" name="satuan_id" id="satuan_id">
                <div class="modal-body">
                    <div class="row mb-1">
                        <label for="satuan_nama" class="col-sm-4 col-form-label">Nama Satuan</label>
                        <div class="col-sm-8">
                            <input type="text" name="satuan_nama" class="form-control form-control-sm" id="satuan_nama">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeSatuan" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary" onclick="saveSatuan()"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection('content') ?>