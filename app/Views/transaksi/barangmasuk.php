<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Managemen Barang Masuk
<?= $this->endSection('title') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('subtitle') ?>
Data Barang Masuk
<?= $this->endSection('subtitle') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('content') ?>
<form action="<?= base_url() ?>exportExcelBarangMasuk" method="post">
    <a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="reloadBarangMasuk()"><i class="fas fa-sync"></i></a>
    <a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="addBarangMasuk()"><i class="fas fa-plus"> </i> Single Transaction</a>
    <a href="<?= site_url('barangmasuk/multipleadd') ?>" class="btn btn-sm btn-default my-2"><i class="fas fa-plus"> </i> Multi Transaction</a>
    <button class="btn btn-sm btn-default my-2"><i class="fas fa-file-excel"> </i> Export All</button>
</form>
<table class="table-sm table-striped" id="tableBarangMasuk">
    <thead>
        <tr class="ligth">
            <th width="5%">No</th>
            <th>Tanggal</th>
            <th>Kode Transaksi</th>
            <th>Kode Barang</th>
            <th>Jumlah</th>
            <th class="text-center" width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="modalBarangMasuk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formBarangMasuk" enctype="multipart/form-data">
                <input type="hidden" name="barang_masuk_id" id="barang_masuk_id">
                <div class="modal-body">
                    <div class="row mb-1">
                        <label for="barang_masuk_tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="date" name="barang_masuk_tanggal" class="form-control form-control-sm" id="barang_masuk_tanggal">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="barang_masuk_kode" class="col-sm-4 col-form-label">Kode</label>
                        <div class="col-sm-8">
                            <input type="text" name="barang_masuk_kode" class="form-control form-control-sm" id="barang_masuk_kode" value="<?= $kodeotomatis ?>">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="barang_id" class="col-sm-4 col-form-label">Barang</label>
                        <div class="col-sm-8">
                            <select name="barang_id" id="barang_id" class="form-control form-control-sm">
                                <option disabled selected hidden>Pilih Barang</option>
                                <?php foreach ($barangs as $barang) : ?>
                                    <option value="<?= $barang['barang_id'] ?>"><?= $barang['barang_nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="barang_masuk_jumlah" class="col-sm-4 col-form-label">Jumlah</label>
                        <div class="col-sm-8">
                            <input type="text" name="barang_masuk_jumlah" class="form-control form-control-sm" id="barang_masuk_jumlah">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="closeBarangMasuk" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary" onclick="saveBarangMasuk()"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var tableBarangMasuk;
    $(document).ready(function() {
        tableBarangMasuk = $('#tableBarangMasuk').dataTable({
            "ajax": {
                "url": '/barangmasuk/read',
                "type": 'GET'
            },
            "deferRender": true,
            "serverSide": true,
            "processing": true,
            "bDestroy": true,
            "scrollY": 150,
            "scroller": true,
            "responsive": true,
            "dom": 'Bfrtip',
            "buttons": [{
                extend: 'excel',
                text: 'Export by Search',
                filename: 'BarangMasuk',
                title: 'Data Barang Masuk',
                exportOptions: {
                    // modifier: {
                    //     search: 'applied',
                    //     order: 'applied',
                    //     page: 'current'
                    // },
                    columns: [0, 1, 2, 3, 4]
                }
            }, ],
        });

    });

    function reloadBarangMasuk() {
        tableBarangMasuk.api().ajax.reload();
    }

    function addBarangMasuk() {
        method = 'save';
        $('.modal-footer').attr('hidden', false);
        $('#formBarangMasuk')[0].reset();
        $('#modalBarangMasuk').modal('show');
        $('input').attr('disabled', false);
        $('input').attr('readonly', false);
        $('select').attr('disabled', false);
        $('.modal-title').text('Form Tambah Data BarangMasuk');
        $('#submit').text('Simpan');
    }


    function detailBarangMasuk(id) {
        $.ajax({
            url: '/barangmasuk/detail/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('[name="barang_masuk_id"]').val(data.barang_masuk_id).attr('disabled', true);
                $('[name="barang_masuk_kode"]').val(data.barang_masuk_kode).attr('disabled', true);
                $('[name="barang_id"]').val(data.barang_id).attr('disabled', true);
                $('[name="barang_masuk_jumlah"]').val(data.barang_masuk_jumlah).attr('disabled', true);
                $('[name="barang_masuk_tanggal"]').val(data.barang_masuk_tanggal).attr('disabled', true);

                $('#modalBarangMasuk').modal('show');
                $('.modal-title').text('Detail Data BarangMasuk');
                $('.modal-footer').attr('hidden', true);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error');
            }
        })
    }

    function editBarangMasuk(id) {
        method = 'update';
        $.ajax({
            url: '/barangmasuk/edit/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('[name="barang_masuk_id"]').val(data.barang_masuk_id).attr('disabled', false);
                $('[name="barang_masuk_kode"]').val(data.barang_masuk_kode).attr('disabled', false);
                $('[name="barang_id"]').val(data.barang_id).attr('disabled', false);
                $('[name="barang_masuk_jumlah"]').val(data.barang_masuk_jumlah).attr('disabled', false);
                $('[name="barang_masuk_tanggal"]').val(data.barang_masuk_tanggal).attr('disabled', false);

                $('.modal-footer').attr('hidden', false);
                $('#modalBarangMasuk').modal('show');
                $('.modal-title').text('Form Edit Data BarangMasuk');
                $('#submit').text('Update');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error');
            }
        })
    }


    // DELETE
    function deleteBarangMasuk(id) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Anda yakin ingin menghapus Data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/barangmasuk/delete/' + id,
                    type: "DELETE",
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            reloadBarangMasuk();
                        };
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error');
                    }
                });
            };
        });
    }



    // SAVE
    function saveBarangMasuk() {
        if (method == 'save') {
            url = '/barangmasuk/save';
            $text = 'Data berhasil di Ditambah';
        } else {
            url = '/barangmasuk/update';
            $text = 'Data berhasil di Update';
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: new FormData($('#formBarangMasuk')[0]),
            dataType: 'JSON',
            contentType: false,
            processData: false,
            beforeSend: function(data) {
                $('#submit').html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success: function(data) {
                if (data.status) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: $text,
                        icon: 'success',
                        toast: true,
                        position: 'bottom-start',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    reloadBarangMasuk();

                    $('.help-block').empty();
                    $('#modalBarangMasuk').modal('hide');
                    $('#formBarangMasuk')[0].reset();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                        $('#submit').text('Simpan');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error');
            }
        });
    }
</script>
<?= $this->endSection('content') ?>