var tableCostCentre;
$(document).ready(function () {
    tableCostCentre = $('#tableCostCentre').dataTable({
        "ajax": {
            "url": '/costcentre/read',
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

function reloadCostCentre() {
    tableCostCentre.api().ajax.reload();
}

function addCostCentre() {
    method = 'save';
    $('.modal-footer').attr('hidden', false);
    $('#formCostCentre')[0].reset();
    $('#modalCostCentre').modal('show');
    $('input').attr('disabled', false);
    $('input').attr('readonly', false);
    $('select').attr('disabled', false);
    $('.modal-title').text('Form Tambah Data CostCentre');
    $('#submit').text('Simpan');
}


function detailCostCentre(id) {
    $.ajax({
        url: '/costcentre/detail/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('[name="cost_centre_id"]').val(data.cost_centre_id).attr('disabled', true);
            $('[name="cost_centre_nama"]').val(data.cost_centre_nama).attr('disabled', true);

            $('#modalCostCentre').modal('show');
            $('.modal-title').text('Detail Data CostCentre');
            $('.modal-footer').attr('hidden', true);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error');
        }
    })
}

function editCostCentre(id) {
    method = 'update';
    $.ajax({
        url: '/costcentre/edit/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('[name="cost_centre_id"]').val(data.cost_centre_id).attr('disabled', false);
            $('[name="cost_centre_nama"]').val(data.cost_centre_nama).attr('disabled', false);

            $('.modal-footer').attr('hidden', false);
            $('#modalCostCentre').modal('show');
            $('.modal-title').text('Form Edit Data CostCentre');
            $('#submit').text('Update');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error');
        }
    })
}


// DELETE
function deleteCostCentre(id) {
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
                url: '/costcentre/delete/' + id,
                type: "DELETE",
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        reloadCostCentre();
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
function saveCostCentre() {
    if (method == 'save') {
        url = '/costcentre/save';
        $text = 'Data berhasil di Ditambah';
    } else {
        url = '/costcentre/update';
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
        data: new FormData($('#formCostCentre')[0]),
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
                reloadCostCentre();

                $('.help-block').empty();
                $('#modalCostCentre').modal('hide');
                $('#formCostCentre')[0].reset();
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
