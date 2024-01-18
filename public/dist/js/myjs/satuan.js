
var tableSatuan;
$(document).ready(function () {
    tableSatuan = $('#tableSatuan').dataTable({
        "ajax": {
            "url": '/satuan/read',
            "type": 'GET'
        },
        "deferRender": true,
        "serverSide": true,
        "processing": true,
        "bDestroy": true,
        "scrollY": 150,
        "scroller": true,
        "paging": true,
        // "responsive": true,
        // "dom": 'Bfrtip',
        // "buttons": [
        //     'pageLength',
        //     'excel',
        //     'print',
        // ]
    });

});

function reloadSatuan() {
    tableSatuan.api().ajax.reload();
}

function addSatuan() {
    method = 'save';
    $('.modal-footer').attr('hidden', false);
    $('#formSatuan')[0].reset();
    $('#modalSatuan').modal('show');
    $('input').attr('disabled', false);
    $('input').attr('readonly', false);
    $('select').attr('disabled', false);
    $('.modal-title').text('Form Tambah Data Satuan');
    $('#submit').text('Simpan');
}


function detailSatuan(id) {
    $.ajax({
        url: '/satuan/detail/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('[name="satuan_id"]').val(data.satuan_id).attr('disabled', true);
            $('[name="satuan_nama"]').val(data.satuan_nama).attr('disabled', true);

            $('#modalSatuan').modal('show');
            $('.modal-title').text('Detail Data Satuan');
            $('.modal-footer').attr('hidden', true);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error');
        }
    })
}

function editSatuan(id) {
    method = 'update';
    $.ajax({
        url: '/satuan/edit/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('[name="satuan_id"]').val(data.satuan_id).attr('disabled', false);
            $('[name="satuan_nama"]').val(data.satuan_nama).attr('disabled', false);

            $('.modal-footer').attr('hidden', false);
            $('#modalSatuan').modal('show');
            $('.modal-title').text('Form Edit Data Satuan');
            $('#submit').text('Update');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error');
        }
    })
}


// DELETE
function deleteSatuan(id) {
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
                url: '/satuan/delete/' + id,
                type: "DELETE",
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        reloadSatuan();
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
function saveSatuan() {
    if (method == 'save') {
        url = '/satuan/save';
        $text = 'Data berhasil di Ditambah';
    } else {
        url = '/satuan/update';
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
        data: new FormData($('#formSatuan')[0]),
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
                reloadSatuan();

                $('.help-block').empty();
                $('#modalSatuan').modal('hide');
                $('#formSatuan')[0].reset();
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
