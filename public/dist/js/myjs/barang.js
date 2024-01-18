var tableBarang;
$(document).ready(function () {
    tableBarang = $('#tableBarang').DataTable({
        "ajax": {
            "url": '/barang/read',
            "type": 'GET'
        },
        "deferRender": true,
        "serverSide": true,
        "processing": true,
        "bDestroy": true,
        "scrollY": 150,
        "scroller": true,
        "responsive": true,
        // "dom": 'Bfrtip',
        // "buttons": [
        //     'pageLength',
        //     'excel',
        //     'print',
        // ]
    });

});

function reloadBarang() {
    tableBarang.ajax.reload();
}

function importBarang() {
    $('#modalImport').modal('show');
}

function addBarang() {
    method = 'save';
    $('.modal-footer').attr('hidden', false);
    $('#formBarang')[0].reset();
    $('#modalBarang').modal('show');
    $('input').attr('disabled', false);
    $('input').attr('readonly', false);
    $('select').attr('disabled', false);
    $('.modal-title').text('Form Tambah Data Barang');
    $('#submit').text('Simpan');
}


function detailBarang(id) {
    $.ajax({
        url: '/barang/detail/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('[name="barang_id"]').val(data.barang_id).attr('disabled', true);
            $('[name="barang_kode"]').val(data.barang_kode).attr('disabled', true);
            $('[name="barang_nama"]').val(data.barang_nama).attr('disabled', true);
            $('[name="barang_id_kategori"]').val(data.barang_id_kategori).attr('disabled', true);
            $('[name="barang_id_satuan"]').val(data.barang_id_satuan).attr('disabled', true);
            $('[name="barang_stok"]').val(data.barang_stok).attr('disabled', true);
            $('[name="barang_harga"]').val(data.barang_harga).attr('disabled', true);

            $('#modalBarang').modal('show');
            $('.modal-title').text('Detail Data Barang');
            $('.modal-footer').attr('hidden', true);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error');
        }
    })
}

function editBarang(id) {
    method = 'update';
    $.ajax({
        url: '/barang/edit/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('[name="barang_id"]').val(data.barang_id).attr('disabled', false);
            $('[name="barang_kode"]').val(data.barang_kode).attr('disabled', false);
            $('[name="barang_nama"]').val(data.barang_nama).attr('disabled', false);
            $('[name="barang_id_kategori"]').val(data.barang_id_kategori).attr('disabled', false);
            $('[name="barang_id_satuan"]').val(data.barang_id_satuan).attr('disabled', false);
            $('[name="barang_stok"]').val(data.barang_stok).attr('disabled', false);
            $('[name="barang_harga"]').val(data.barang_harga).attr('disabled', false);

            $('.modal-footer').attr('hidden', false);
            $('#modalBarang').modal('show');
            $('.modal-title').text('Form Edit Data Barang');
            $('#submit').text('Update');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error');
        }
    })
}


// DELETE
function deleteBarang(id) {
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
                url: '/barang/delete/' + id,
                type: "DELETE",
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        reloadBarang();
                    };
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error');
                }
            });
        };
    });
}



// SAVE
function saveBarang() {
    if (method == 'save') {
        url = '/barang/save';
        $text = 'Data berhasil di Ditambah';
    } else {
        url = '/barang/update';
        $text = 'Data berhasil di Update';
    }

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $.ajax({
        url: url,
        type: 'POST',
        data: new FormData($('#formBarang')[0]),
        dataType: 'JSON',
        contentType: false,
        processData: false,
        beforeSend: function (data) {
            $('#submit').html('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            if (data.status) {
                Toast.fire({
                    icon: 'success',
                    title: $text,
                })
                reloadBarang();

                $('.help-block').empty();
                $('#modalBarang').modal('hide');
                $('#formBarang')[0].reset();
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    $('#submit').text('Simpan');
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error');
        }
    });
}