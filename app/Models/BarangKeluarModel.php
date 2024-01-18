<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $table            = 'barang_keluar';
    protected $primaryKey       = 'barang_keluar_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['barang_keluar_kode', 'barang_id', 'barang_keluar_jumlah', 'barang_keluar_tanggal'];

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
        $prefix = 'BK'; // Prefix kode transaksi
        $date = date('Ymd'); // Format tanggal
        $count = $this->countAll(); // Menghitung jumlah transaksi

        $transactionCode = $prefix . $date . str_pad($count + 1, 4, '0', STR_PAD_LEFT);

        return $transactionCode;
    }


    public function getBarangKeluarEkport()
    {
        $result = $this->orderBy('barang_keluar_id', 'DESC')->join('barang', 'barang.barang_id = barang_keluar.barang_id')->join('kategori', 'barang.barang_id_kategori = kategori.kategori_id', 'left')->join('satuan', 'barang.barang_id_satuan = satuan.satuan_id', 'left')->findAll();
        return $result;
    }

    public function ajaxGetData($start, $length)
    {
        $result = $this->orderBy('barang_keluar_id', 'DESC')->join('barang', 'barang.barang_id = barang_keluar.barang_id')->findAll($length, $start);
        return $result;
    }

    public function ajaxGetDataSearch($search, $start, $length)
    {
        $result = $this->join('barang', 'barang.barang_id = barang_keluar.barang_id')->like('barang_keluar_kode', $search)->orLike('barang_keluar_tanggal', $search)->findAll($start, $length);
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
        $result = $this->join('barang', 'barang.barang_id = barang_keluar.barang_id')->like('barang_keluar_kode', $search)->orLike('barang_keluar_tanggal', $search)->countAllResults();
        return $result;
    }

    public function getRulesValidation($method = null)
    {
        if ($method == 'save') {
            $barang_keluar_kode = 'required|is_unique[barang_keluar.barang_keluar_kode]';
        } else {
            $barang_keluar_kode = 'required';
        }

        $rulesValidation = [
            'barang_keluar_kode' => [
                'rules' => $barang_keluar_kode,
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
            'barang_keluar_jumlah' => [
                'rules' => 'required',
                'label' => 'Jumlah Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
            'barang_keluar_tanggal' => [
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
