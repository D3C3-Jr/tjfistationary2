
var tableKategori;
$(document).ready(function () {
    tableKategori = $('#tableKategori').dataTable({
        "ajax": {
            "url": '/kategori/read',
            "type": 'GET'
        },
        "deferRender": true,
        "serverSide": true,
        "processing": true,
        "bDestroy": true,
        "scrollY": 150,
        "scroller": true,
        // "responsive": true,
        // "dom": 'Bfrtip',
        // "buttons": [
        //     'pageLength',
        //     'excel',
        //     'print',
        // ]
    });

});

function reloadKategori() {
    tableKategori.api().ajax.reload();
}

function addKategori() {
    method = 'save';
    $('.modal-footer').attr('hidden', false);
    $('#formKategori')[0].reset();
    $('#modalKategori').modal('show');
    $('input').attr('disabled', false);
    $('input').attr('readonly', false);
    $('select').attr('disabled', false);
    $('.modal-title').text('Form Tambah Data Kategori');
    $('#submit').text('Simpan');
}


function detailKategori(id) {
    $.ajax({
        url: '/kategori/detail/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('[name="kategori_id"]').val(data.kategori_id).attr('disabled', true);
            $('[name="kategori_nama"]').val(data.kategori_nama).attr('disabled', true);

            $('#modalKategori').modal('show');
            $('.modal-title').text('Detail Data Kategori');
            $('.modal-footer').attr('hidden', true);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error');
        }
    })
}

function editKategori(id) {
    method = 'update';
    $.ajax({
        url: '/kategori/edit/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('[name="kategori_id"]').val(data.kategori_id).attr('disabled', false);
            $('[name="kategori_nama"]').val(data.kategori_nama).attr('disabled', false);

            $('.modal-footer').attr('hidden', false);
            $('#modalKategori').modal('show');
            $('.modal-title').text('Form Edit Data Kategori');
            $('#submit').text('Update');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error');
        }
    })
}


// DELETE
function deleteKategori(id) {
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
                url: '/kategori/delete/' + id,
                type: "DELETE",
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        reloadKategori();
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
function saveKategori() {
    if (method == 'save') {
        url = '/kategori/save';
        $text = 'Data berhasil di Ditambah';
    } else {
        url = '/kategori/update';
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
        data: new FormData($('#formKategori')[0]),
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
                reloadKategori();

                $('.help-block').empty();
                $('#modalKategori').modal('hide');
                $('#formKategori')[0].reset();
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
