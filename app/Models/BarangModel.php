<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'barang_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['barang_kode', 'barang_nama', 'barang_id_kategori', 'barang_id_satuan', 'barang_stok', 'barang_harga'];

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

    public function getBarangEkport()
    {
        $result = $this->orderBy('barang_id', 'DESC')->join('kategori', 'kategori.kategori_id = barang.barang_id_kategori')->join('satuan', 'satuan.satuan_id = barang.barang_id_satuan')->findAll();
        return $result;
    }

    public function getBarangStok($barang_id)
    {
        $data = $this->where(['barang_id' => $barang_id])->first();
        return $data['barang_stok'];
    }

    public function getBarangMinim()
    {
        $data = $this->where('barang_stok <', 10)->countAllResults();
        return $data;
    }
    public function getJumlahBarang()
    {
        $data = $this->orderBy('barang_id', 'ASC')->countAllResults();
        return $data;
    }

    public function ajaxGetData($start, $length)
    {
        $result = $this->orderBy('barang_id', 'DESC')->join('kategori', 'kategori.kategori_id = barang.barang_id_kategori')->join('satuan', 'satuan.satuan_id = barang.barang_id_satuan')->findAll($length, $start);
        return $result;
    }

    public function ajaxGetDataSearch($search, $start, $length)
    {
        $result = $this->join('kategori', 'kategori.kategori_id = barang.barang_id_kategori')->join('satuan', 'satuan.satuan_id = barang.barang_id_satuan')->like('barang_nama', $search)->orLike('barang_kode', $search)->findAll($start, $length);
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
        $result = $this->join('kategori', 'kategori.kategori_id = barang.barang_id_kategori')->join('satuan', 'satuan.satuan_id = barang.barang_id_satuan')->like('barang_nama', $search)->orLike('barang_kode', $search)->countAllResults();
        return $result;
    }

    public function getRulesValidation($method = null)
    {
        if ($method == 'save') {
            $barang_kode = 'required|is_unique[barang.barang_kode]';
        } else {
            $barang_kode = 'required';
        }

        $rulesValidation = [
            'barang_kode' => [
                'rules' => $barang_kode,
                'label' => 'Kode Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                    'is_unique' => '{field} Sudah ada'
                ],
            ],
            'barang_nama' => [
                'rules' => 'required',
                'label' => 'Nama Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
            'barang_id_kategori' => [
                'rules' => 'required',
                'label' => 'Kategori Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
            'barang_id_satuan' => [
                'rules' => 'required',
                'label' => 'Satuan Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
            'barang_harga' => [
                'rules' => 'required',
                'label' => 'Harga Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
            'barang_stok' => [
                'rules' => 'required',
                'label' => 'Stok Barang',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
        ];

        return $rulesValidation;
    }
}
