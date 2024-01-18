<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Managemen Barang Keluar
<?= $this->endSection('title') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('subtitle') ?>
Data Barang Keluar
<?= $this->endSection('subtitle') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('content') ?>
<form action="<?= base_url() ?>exportExcelBarangKeluar" method="post">
    <a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="reloadBarangKeluar()"><i class="fas fa-sync"></i></a>
    <a href="javascript:void(0)" class="btn btn-sm btn-default my-2" onclick="addBarangKeluar()"><i class="fas fa-plus"> </i> Single Transaction</a>
    <a href="<?= site_url('barangkeluar/multipleadd') ?>" class="btn btn-sm btn-default my-2"><i class="fas fa-plus"> </i> Multi Transaction</a>
    <button class="btn btn-sm btn-default my-2"><i class="fas fa-file-excel"> </i> Export All</button>
</form>
<table class="table-sm table-striped" id="tableBarangKeluar">
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
<div class="modal fade" id="modalBarangKeluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formBarangKeluar" enctype="multipart/form-data">
                <input type="hidden" name="barang_keluar_id" id="barang_keluar_id">
                <div class="modal-body">
                    <div class="row mb-1">
                        <label for="barang_keluar_tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="date" name="barang_keluar_tanggal" class="form-control form-control-sm" id="barang_keluar_tanggal">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="barang_keluar_kode" class="col-sm-4 col-form-label">Kode</label>
                        <div class="col-sm-8">
                            <input type="text" name="barang_keluar_kode" class="form-control form-control-sm" id="barang_keluar_kode" value="<?= $kodeotomatis ?>">
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
                        <label for="barang_keluar_jumlah" class="col-sm-4 col-form-label">Jumlah</label>
                        <div class="col-sm-8">
                            <input type="text" name="barang_keluar_jumlah" class="form-control form-control-sm" id="barang_keluar_jumlah">
                            <small class="help-block text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="closeBarangKeluar" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary" onclick="saveBarangKeluar()"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var tableBarangKeluar;
    $(document).ready(function() {
        tableBarangKeluar = $('#tableBarangKeluar').dataTable({
            "ajax": {
                "url": '/barangkeluar/read',
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
                filename: 'BarangKeluar',
                title: 'Data Barang Keluar',
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

    function reloadBarangKeluar() {
        tableBarangKeluar.api().ajax.reload();
    }

    function addBarangKeluar() {
        method = 'save';
        $('.modal-footer').attr('hidden', false);
        $('#formBarangKeluar')[0].reset();
        $('#modalBarangKeluar').modal('show');
        $('input').attr('disabled', false);
        $('input').attr('readonly', false);
        $('select').attr('disabled', false);
        $('.modal-title').text('Form Tambah Data BarangKeluar');
        $('#submit').text('Simpan');
    }


    function detailBarangKeluar(id) {
        $.ajax({
            url: '/barangkeluar/detail/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('[name="barang_keluar_id"]').val(data.barang_keluar_id).attr('disabled', true);
                $('[name="barang_keluar_kode"]').val(data.barang_keluar_kode).attr('disabled', true);
                $('[name="barang_id"]').val(data.barang_id).attr('disabled', true);
                $('[name="barang_keluar_jumlah"]').val(data.barang_keluar_jumlah).attr('disabled', true);
                $('[name="barang_keluar_tanggal"]').val(data.barang_keluar_tanggal).attr('disabled', true);

                $('#modalBarangKeluar').modal('show');
                $('.modal-title').text('Detail Data BarangKeluar');
                $('.modal-footer').attr('hidden', true);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error');
            }
        })
    }

    function editBarangKeluar(id) {
        method = 'update';
        $.ajax({
            url: '/barangkeluar/edit/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('[name="barang_keluar_id"]').val(data.barang_keluar_id).attr('disabled', false);
                $('[name="barang_keluar_kode"]').val(data.barang_keluar_kode).attr('disabled', false);
                $('[name="barang_id"]').val(data.barang_id).attr('disabled', false);
                $('[name="barang_keluar_jumlah"]').val(data.barang_keluar_jumlah).attr('disabled', false);
                $('[name="barang_keluar_tanggal"]').val(data.barang_keluar_tanggal).attr('disabled', false);

                $('.modal-footer').attr('hidden', false);
                $('#modalBarangKeluar').modal('show');
                $('.modal-title').text('Form Edit Data BarangKeluar');
                $('#submit').text('Update');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error');
            }
        })
    }


    // DELETE
    function deleteBarangKeluar(id) {
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
                    url: '/barangkeluar/delete/' + id,
                    type: "DELETE",
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            reloadBarangKeluar();
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
    function saveBarangKeluar() {
        if (method == 'save') {
            url = '/barangkeluar/save';
            $text = 'Data berhasil di Ditambah';
        } else {
            url = '/barangkeluar/update';
            $text = 'Data berhasil di Update';
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: new FormData($('#formBarangKeluar')[0]),
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
                    reloadBarangKeluar();

                    $('.help-block').empty();
                    $('#modalBarangKeluar').modal('hide');
                    $('#formBarangKeluar')[0].reset();
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