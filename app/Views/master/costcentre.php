<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Managemen Cost Centre
<?= $this->endSection('title') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('subtitle') ?>
Data Cost Centre
<?= $this->endSection('subtitle') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('content') ?>
<a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="reloadCostCentre()"><i class="fas fa-sync"></i></a>
<a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="addCostCentre()"><i class="fas fa-plus"> </i> Tambah Data</a>
<table class="table-sm table-striped" id="tableCostCentre" >
    <thead>
        <tr class="ligth">
            <th width="5%">No</th>
            <th>Nama CostCentre</th>
            <th class="text-center" width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="modalCostCentre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formCostCentre" enctype="multipart/form-data">
                <input type="hidden" name="cost_centre_id" id="cost_centre_id">
                <div class="modal-body">
                    <div class="row mb-1">
                        <label for="cost_centre_nama" class="col-sm-4 col-form-label">Nama CostCentre</label>
                        <div class="col-sm-8">
                            <input type="text" name="cost_centre_nama" class="form-control form-control-sm" id="cost_centre_nama">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeCostCentre" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary" onclick="saveCostCentre()"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection('content') ?>