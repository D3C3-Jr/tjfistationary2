<?php

namespace App\Models;

use CodeIgniter\Model;

class CostCentreModel extends Model
{
    protected $table            = 'cost_centre';
    protected $primaryKey       = 'cost_centre_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['cost_centre_nama'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function ajaxGetData($start, $length)
    {
        $result = $this->orderBy('cost_centre_id', 'DESC')->findAll($length, $start);
        return $result;
    }

    public function ajaxGetDataSearch($search, $start, $length)
    {
        $result = $this->like('cost_centre_nama', $search)->findAll($start, $length);
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
        $result = $this->like('cost_centre_nama', $search)->countAllResults();
        return $result;
    }

    public function getRulesValidation($method = null)
    {
        // if ($method == 'save') {
        //     $kode_cost_center = 'required|is_unique[cost_center.kode_cost_center]';
        // } else {
        //     $kode_cost_center = 'required';
        // }

        $rulesValidation = [
            'cost_centre_nama' => [
                'rules' => 'required',
                'label' => 'Nama Cost Centre',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ],
            ],
        ];

        return $rulesValidation;
    }
}
