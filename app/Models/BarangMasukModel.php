<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table            = 'barang_masuk';
    protected $primaryKey       = 'barang_masuk_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['barang_masuk_kode', 'barang_id', 'barang_masuk_jumlah', 'barang_masuk_tanggal'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function generateTransactionCode()
    {
        $prefix = 'BM'; // Prefix kode transaksi
        $date = date('Ymd'); // Format tanggal
        $count = $this->countAll(); // Menghitung jumlah transaksi

        $transactionCode = $prefix . $date . str_pad($count + 1, 4, '0', STR_PAD_LEFT);

        return $transactionCode;
    }

    public function getBarangMasukEkport()
    {
        $result = $this->orderBy('barang_masuk_id', 'DESC')->join('barang', 'barang.barang_id = barang_masuk.barang_id')->join('kategori', 'barang.barang_id_kategori = kategori.kategori_id', 'left')->join('satuan', 'barang.barang_id_satuan = satuan.satuan_id', 'left')->findAll();
        return $result;
    }

    public function ajaxGetData($start, $length)
    {
        $result = $this->orderBy('barang_masuk_id', 'DESC')->join('barang', 'barang.barang_id = barang_masuk.barang_id')->findAll($length, $start);
        return $result;
    }

    public function ajaxGetDataSearch($search, $start, $length)
    {
        $result = $this->join('barang', 'barang.barang_id = barang_masuk.barang_id')->like('barang_masuk_kode', $search)->orLike('barang_masuk_tanggal', $search)->findAll($start, $length);
        return $result;
    }

    public function ajaxGetTotal()
    {
        $result = $this->countAllResults();
        if (isset($result)) {
            return $result;
        }
        return 0;
    }

    public function ajaxGetTotalSearch($search)
    {
        $result = $this->join('barang', 'barang.barang_id = barang_masuk.barang_id')->like('barang_masuk_kode', $search)->orLike('barang_masuk_tanggal', $search)->countAllResults();
        return $result;
    }

    public function getRulesValidation($method = null)
    {
        if ($method == 'save') {
            $barang_masuk_kode = 'required|is_unique[barang_masuk.barang_masuk_kode]';
        } else {
            $barang_masuk_kode = 'required';
        }

        $rulesValidation = [
            'barang_masuk_kode' => [
                'rules' => $barang_masuk_kode,
                'label' => 'Kode Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                    'is_unique' => '{field} Sudah ada'
                ],
            ],
            'barang_id' => [
                'rules' => 'required',
                'label' => 'Nama Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
            'barang_masuk_jumlah' => [
                'rules' => 'required',
                'label' => 'Jumlah Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
            'barang_masuk_tanggal' => [
                'rules' => 'required',
                'label' => 'Tanggal',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
        ];

        return $rulesValidation;
    }
}
