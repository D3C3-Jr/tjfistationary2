<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Managemen Barang Masuk
<?= $this->endSection('title') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('subtitle') ?>
Tambah Data Barang Masuk
<?= $this->endSection('subtitle') ?>
<!-- ------------------------------------------------ -->


<?= $this->section('content') ?>
<?= form_open('barangmasuk/saveMultipleBarangMasuk', ['class' => 'saveMultipleBarangMasuk']) ?>
<table class="table table-sm">
    <thead>
        <tr>
            <td>Tanggal</td>
            <td>Kode Barang Masuk</td>
            <td width="30%">Barang</td>
            <td>Jumlah</td>
            <td># </td>
        </tr>
    </thead>
    <tbody id="tambahanField">
        <tr>
            <td><input type="date" name="barang_masuk_tanggal[]" class="form-control form-control-sm" id="barang_masuk_tanggal" required></td>
            <td><input type="text" name="barang_masuk_kode[]" class="form-control form-control-sm" value="<?= $kodeotomatis ?>" readonly></td>
            <td>
                <select name="barang_id[]" id="barang_id" class="form-control form-control-sm">
                    <option hidden selected disabled>Pilih Barang</option>
                    <?php foreach ($barangs as $barang) : ?>
                        <option value="<?= $barang['barang_id'] ?>"><?= $barang['barang_nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="text" name="barang_masuk_jumlah[]" class="form-control form-control-sm"></td>

            <td><button type="button" id="tambahField" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></button></td>
        </tr>
    </tbody>
</table>
<a href="<?= site_url('barangmasuk') ?>" class="btn btn-secondary" data-dismiss="modal">Back</a>
<button type="submit" class="btn btn-primary btnSave">Save changes</button>
<?= form_close() ?>

<script>
    $('#tambahField').click(function() {
        var tambahanField = `
            <tr id="fieldTambahan">
                <td><input type="date" name="barang_masuk_tanggal[]" class="form-control form-control-sm" id="barang_masuk_tanggal" required></td>
                <td><input type="text" name="barang_masuk_kode[]" class="form-control form-control-sm" value="<?= $kodeotomatis ?>" readonly></td>
                <td>
                <select name="barang_id[]" id="barang_id" class="form-control form-control-sm">
                    <option hidden selected disabled>Pilih Barang</option>
                    <?php foreach ($barangs as $barang) : ?>
                        <option value="<?= $barang['barang_id'] ?>"><?= $barang['barang_nama'] ?></option>
                    <?php endforeach; ?>
                </select>
                </td>
                <td><input type="text" name="barang_masuk_jumlah[]" class="form-control form-control-sm"></td>
                
                <td><button type="button" id="hapusField" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
            </tr>
            `;
        $('#tambahanField').append(tambahanField);
    });

    $("body").on("click", "#hapusField", function() {
        $(this).parents("#fieldTambahan").remove();
    });

    $('.saveMultipleBarangMasuk').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.btnSave').attr('disable', 'disabled');
                $('.btnSave').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function(response) {
                $('.btnSave').removeAttr('disabled');
                $('.btnSave').html('Save changes');
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                    });
                }
                window.location.href = "/barangmasuk/multipleadd";

            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: xhr.status + "\n" + xhr.responseText + "\n" + thrownError,
                });

                window.location.href = "/barangmasuk/multipleadd";
            }
        });
        return false;
    });
</script>
<?= $this->endSection('content') ?>