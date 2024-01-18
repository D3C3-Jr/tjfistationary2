<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\SatuanModel;
use App\Models\CostCentreModel;
use App\Models\BarangModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class MasterController extends BaseController
{
    protected $dbKategori;
    protected $dbSatuan;
    protected $dbCostCentre;
    protected $dbBarang;
    public function __construct()
    {
        $this->dbKategori = new KategoriModel();
        $this->dbSatuan = new SatuanModel();
        $this->dbCostCentre = new CostCentreModel();
        $this->dbBarang = new BarangModel();
    }

    public function kategori()
    {
        $data = [
            'sidebar' => 'kategori'
        ];
        return view('master/kategori', $data);
    }
    public function satuan()
    {
        $data = [
            'sidebar' => 'satuan'
        ];
        return view('master/satuan', $data);
    }
    public function costcentre()
    {
        $data = [
            'sidebar' => 'costcentre'
        ];
        return view('master/costcentre', $data);
    }
    public function barang()
    {
        $data = [
            'kategoris' => $this->dbKategori->findAll(),
            'satuans'   => $this->dbSatuan->findAll(),
            'sidebar'   => 'barang',
            'jumlahStokMinim' => $this->dbBarang->getBarangMinim(),
            'jumlahBarang'  => $this->dbBarang->getJumlahBarang(),
        ];
        return view('master/barang', $data);
    }


    // IMPORT EXCEL
    public function importBarangExcel()
    {
        $file_excel = $this->request->getFile('fileexcel');
        $ext = $file_excel->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file_excel);

        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }

            $barang_kode = $row[0];
            $barang_nama = $row[1];
            $barang_id_kategori = $row[2];
            $barang_id_satuan = $row[3];
            $barang_stok = $row[4];
            $barang_harga = $row[5];

            $db = \Config\Database::connect();

            $cekbarang_kode = $db->table('barang')->getWhere(['barang_kode' => $barang_kode])->getResult();

            if (count($cekbarang_kode) > 0) {
                session()->setFlashdata('error', '<b>Data Gagal di Import, Kode Barang ada yang sama</b>');
            } else {

                $simpandata = [
                    'barang_kode' => $barang_kode,
                    'barang_nama' => $barang_nama,
                    'barang_id_kategori' => $barang_id_kategori,
                    'barang_id_satuan' => $barang_id_satuan,
                    'barang_stok' => $barang_stok,
                    'barang_harga' => $barang_harga,
                ];

                $db->table('barang')->insert($simpandata);
                session()->setFlashdata('success', '<b class="text-success">Data Berhasil di Import</b>');
            }
        }

        return redirect()->to('/barang');
    }


    // READ
    public function readKategori()
    {
        $draw = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->dbKategori->ajaxGetTotal();
        $output = [
            'length' => $length,
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ];

        if ($search !== "") {
            $list = $this->dbKategori->ajaxGetDataSearch($search, $start, $length);
        } else {
            $list = $this->dbKategori->ajaxGetData($start, $length);
        }

        if ($search !== "") {
            $total_search = $this->dbKategori->ajaxGetTotalSearch($search);
            $output = [
                'recordsTotal' => $total_search,
                'recordsFiltered' => $total_search
            ];
        }

        $data = [];
        $no = $start + 1;

        foreach ($list as $temp) {
            $aksi = '
            <div class="text-center">
                    <a href="javascript:void(0)" onclick="detailKategori(' . $temp['kategori_id'] . ')"><i class="btn btn-sm btn-primary fas fa-eye"> </i></a>
                    <a href="javascript:void(0)" onclick="editKategori(' . $temp['kategori_id'] . ')"><i class="btn btn-sm btn-success fas fa-edit"> </i></a>
                    <a href="javascript:void(0)" onclick="deleteKategori(' . $temp['kategori_id'] . ')"><i class="btn btn-sm btn-danger fas fa-trash-alt"> </i></a>
            </div>
                    ';

            $row = [];
            $row[] = $no;
            $row[] = $temp['kategori_nama'];
            $row[] = $aksi;

            $data[] = $row;
            $no++;
        }

        $output['data'] = $data;

        echo json_encode($output);
        exit();
    }
    public function readSatuan()
    {
        $draw = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->dbSatuan->ajaxGetTotal();
        $output = [
            'length' => $length,
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ];

        if ($search !== "") {
            $list = $this->dbSatuan->ajaxGetDataSearch($search, $start, $length);
        } else {
            $list = $this->dbSatuan->ajaxGetData($start, $length);
        }

        if ($search !== "") {
            $total_search = $this->dbSatuan->ajaxGetTotalSearch($search);
            $output = [
                'recordsTotal' => $total_search,
                'recordsFiltered' => $total_search
            ];
        }

        $data = [];
        $no = $start + 1;

        foreach ($list as $temp) {
            $aksi = '
            <div class="text-center">
                    <a href="javascript:void(0)" onclick="detailSatuan(' . $temp['satuan_id'] . ')"><i class="btn btn-sm btn-primary fas fa-eye"> </i></a>
                    <a href="javascript:void(0)" onclick="editSatuan(' . $temp['satuan_id'] . ')"><i class="btn btn-sm btn-success fas fa-edit"> </i></a>
                    <a href="javascript:void(0)" onclick="deleteSatuan(' . $temp['satuan_id'] . ')"><i class="btn btn-sm btn-danger fas fa-trash-alt"> </i></a>
            </div>
                    ';

            $row = [];
            $row[] = $no;
            $row[] = $temp['satuan_nama'];
            $row[] = $aksi;

            $data[] = $row;
            $no++;
        }

        $output['data'] = $data;

        echo json_encode($output);
        exit();
    }
    public function readCostCentre()
    {
        $draw = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->dbCostCentre->ajaxGetTotal();
        $output = [
            'length' => $length,
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ];

        if ($search !== "") {
            $list = $this->dbCostCentre->ajaxGetDataSearch($search, $start, $length);
        } else {
            $list = $this->dbCostCentre->ajaxGetData($start, $length);
        }

        if ($search !== "") {
            $total_search = $this->dbCostCentre->ajaxGetTotalSearch($search);
            $output = [
                'recordsTotal' => $total_search,
                'recordsFiltered' => $total_search
            ];
        }

        $data = [];
        $no = $start + 1;

        foreach ($list as $temp) {
            $aksi = '
            <div class="text-center">
                    <a href="javascript:void(0)" onclick="detailCostCentre(' . $temp['cost_centre_id'] . ')"><i class="btn btn-sm btn-primary fas fa-eye"> </i></a>
                    <a href="javascript:void(0)" onclick="editCostCentre(' . $temp['cost_centre_id'] . ')"><i class="btn btn-sm btn-success fas fa-edit"> </i></a>
                    <a href="javascript:void(0)" onclick="deleteCostCentre(' . $temp['cost_centre_id'] . ')"><i class="btn btn-sm btn-danger fas fa-trash-alt"> </i></a>
            </div>
                    ';

            $row = [];
            $row[] = $no;
            $row[] = $temp['cost_centre_nama'];
            $row[] = $aksi;

            $data[] = $row;
            $no++;
        }

        $output['data'] = $data;

        echo json_encode($output);
        exit();
    }
    public function readBarang()
    {
        $draw = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->dbBarang->ajaxGetTotal();
        $output = [
            'length' => $length,
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ];

        if ($search !== "") {
            $list = $this->dbBarang->ajaxGetDataSearch($search, $start, $length);
        } else {
            $list = $this->dbBarang->ajaxGetData($start, $length);
        }

        if ($search !== "") {
            $total_search = $this->dbBarang->ajaxGetTotalSearch($search);
            $output = [
                'recordsTotal' => $total_search,
                'recordsFiltered' => $total_search
            ];
        }

        $data = [];
        $no = $start + 1;

        foreach ($list as $temp) {
            $aksi = '
            <div class="text-center">
                    <a href="javascript:void(0)" onclick="detailBarang(' . $temp['barang_id'] . ')"><i class="btn btn-sm btn-primary fas fa-eye"> </i></a>
                    <a href="javascript:void(0)" onclick="editBarang(' . $temp['barang_id'] . ')"><i class="btn btn-sm btn-success fas fa-edit"> </i></a>
                    <a href="javascript:void(0)" onclick="deleteBarang(' . $temp['barang_id'] . ')"><i class="btn btn-sm btn-danger fas fa-trash-alt"> </i></a>
            </div>
                    ';

            if ($temp['barang_stok'] < 10) {
                $stok = '<p style="background-color:#dc3545">' . $temp['barang_stok'] . '</p>';
            } else {
                $stok = '<p>' . $temp['barang_stok'] . '</p>';
            }

            $row = [];
            $row[] = $no;
            $row[] = $temp['barang_kode'];
            $row[] = $temp['barang_nama'];
            $row[] = $temp['kategori_nama'];
            $row[] = $temp['satuan_nama'];
            $row[] = $stok;
            $row[] = $temp['barang_harga'];
            $row[] = $aksi;

            $data[] = $row;
            $no++;
        }

        $output['data'] = $data;

        echo json_encode($output);
        exit();
    }




    // DETAIL
    public function detailKategori($kategori_id)
    {
        $data = $this->dbKategori->find($kategori_id);
        echo json_encode($data);
    }
    public function detailSatuan($satuan_id)
    {
        $data = $this->dbSatuan->find($satuan_id);
        echo json_encode($data);
    }
    public function detailCostCentre($cost_centre_id)
    {
        $data = $this->dbCostCentre->find($cost_centre_id);
        echo json_encode($data);
    }
    public function detailBarang($barang_id)
    {
        $data = $this->dbBarang->find($barang_id);
        echo json_encode($data);
    }



    // EDIT
    public function editKategori($kategori_id)
    {
        $data = $this->dbKategori->find($kategori_id);
        echo json_encode($data);
    }
    public function editSatuan($satuan_id)
    {
        $data = $this->dbSatuan->find($satuan_id);
        echo json_encode($data);
    }
    public function editCostCentre($cost_centre_id)
    {
        $data = $this->dbCostCentre->find($cost_centre_id);
        echo json_encode($data);
    }
    public function editBarang($barang_id)
    {
        $data = $this->dbBarang->find($barang_id);
        echo json_encode($data);
    }



    // UPDATE
    public function updateKategori()
    {
        $this->_validateKategori('update');
        $kategori_id = $this->request->getVar('kategori_id');
        $task = $this->dbKategori->find($kategori_id);

        $data = [
            'kategori_id' => $kategori_id,
            'kategori_nama' => $this->request->getVar('kategori_nama'),
        ];

        if ($this->dbKategori->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function updateSatuan()
    {
        $this->_validateSatuan('update');
        $satuan_id = $this->request->getVar('satuan_id');
        // $task = $this->dbSatuan->find($satuan_id);

        $data = [
            'satuan_id' => $satuan_id,
            'satuan_nama' => $this->request->getVar('satuan_nama'),
        ];

        if ($this->dbSatuan->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function updateCostCentre()
    {
        $this->_validateCostCentre('update');
        $cost_centre_id = $this->request->getVar('cost_centre_id');
        // $task = $this->dbCostCentre->find($cost_centre_id);

        $data = [
            'cost_centre_id' => $cost_centre_id,
            'cost_centre_nama' => $this->request->getVar('cost_centre_nama'),
        ];

        if ($this->dbCostCentre->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function updateBarang()
    {
        $this->_validateBarang('update');
        $barang_id = $this->request->getVar('barang_id');
        $task = $this->dbBarang->find($barang_id);

        $data = [
            'barang_id' => $barang_id,
            'barang_kode' => $this->request->getVar('barang_kode'),
            'barang_nama' => $this->request->getVar('barang_nama'),
            'barang_id_kategori' => $this->request->getVar('barang_id_kategori'),
            'barang_id_satuan' => $this->request->getVar('barang_id_satuan'),
            'barang_stok' => $this->request->getVar('barang_stok'),
            'barang_harga' => $this->request->getVar('barang_harga'),
        ];

        if ($this->dbBarang->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }




    // DELETE
    public function deleteKategori($kategori_id)
    {
        if ($this->dbKategori->delete($kategori_id)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function deleteSatuan($satuan_id)
    {
        if ($this->dbSatuan->delete($satuan_id)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function deleteCostCentre($cost_centre_id)
    {
        if ($this->dbCostCentre->delete($cost_centre_id)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function deleteBarang($barang_id)
    {
        if ($this->dbBarang->delete($barang_id)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }



    // SAVE
    public function saveKategori()
    {
        $this->_validateKategori('save');
        $data = [
            'kategori_nama' => $this->request->getVar('kategori_nama'),
        ];

        if ($this->dbKategori->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function saveSatuan()
    {
        $this->_validateSatuan('save');
        $data = [
            'satuan_nama' => $this->request->getVar('satuan_nama'),
        ];

        if ($this->dbSatuan->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function saveCostCentre()
    {
        $this->_validateCostCentre('save');
        $data = [
            'cost_centre_nama' => $this->request->getVar('cost_centre_nama'),
        ];

        if ($this->dbCostCentre->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function saveBarang()
    {
        $this->_validateBarang('save');
        $data = [
            'barang_kode' => $this->request->getVar('barang_kode'),
            'barang_nama' => $this->request->getVar('barang_nama'),
            'barang_id_kategori' => $this->request->getVar('barang_id_kategori'),
            'barang_id_satuan' => $this->request->getVar('barang_id_satuan'),
            'barang_stok' => $this->request->getVar('barang_stok'),
            'barang_harga' => $this->request->getVar('barang_harga'),
        ];

        if ($this->dbBarang->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }



    // VALIDATE
    public function _validateKategori($method)
    {
        if (!$this->validate($this->dbKategori->getRulesValidation($method))) {
            $validation = \Config\Services::validation();
            $data = [];
            $data['error_string'] = [];
            $data['inputerror'] = [];
            $data['status'] = true;

            if ($validation->hasError('kategori_nama')) {
                $data['inputerror'][] = 'kategori_nama';
                $data['error_string'][] = $validation->getError('kategori_nama');
                $data['status'] = false;
            }

            if ($data['status'] === false) {
                echo json_encode($data);
                exit();
            }
        }
    }
    public function _validateSatuan($method)
    {
        if (!$this->validate($this->dbSatuan->getRulesValidation($method))) {
            $validation = \Config\Services::validation();
            $data = [];
            $data['error_string'] = [];
            $data['inputerror'] = [];
            $data['status'] = true;

            if ($validation->hasError('satuan_nama')) {
                $data['inputerror'][] = 'satuan_nama';
                $data['error_string'][] = $validation->getError('satuan_nama');
                $data['status'] = false;
            }

            if ($data['status'] === false) {
                echo json_encode($data);
                exit();
            }
        }
    }
    public function _validateCostCentre($method)
    {
        if (!$this->validate($this->dbCostCentre->getRulesValidation($method))) {
            $validation = \Config\Services::validation();
            $data = [];
            $data['error_string'] = [];
            $data['inputerror'] = [];
            $data['status'] = true;

            if ($validation->hasError('cost_centre_nama')) {
                $data['inputerror'][] = 'cost_centre_nama';
                $data['error_string'][] = $validation->getError('cost_centre_nama');
                $data['status'] = false;
            }

            if ($data['status'] === false) {
                echo json_encode($data);
                exit();
            }
        }
    }
    public function _validateBarang($method)
    {
        if (!$this->validate($this->dbBarang->getRulesValidation($method))) {
            $validation = \Config\Services::validation();
            $data = [];
            $data['error_string'] = [];
            $data['inputerror'] = [];
            $data['status'] = true;

            if ($validation->hasError('barang_kode')) {
                $data['inputerror'][] = 'barang_kode';
                $data['error_string'][] = $validation->getError('barang_kode');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_nama')) {
                $data['inputerror'][] = 'barang_nama';
                $data['error_string'][] = $validation->getError('barang_nama');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_id_kategori')) {
                $data['inputerror'][] = 'barang_id_kategori';
                $data['error_string'][] = $validation->getError('barang_id_kategori');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_id_satuan')) {
                $data['inputerror'][] = 'barang_id_satuan';
                $data['error_string'][] = $validation->getError('barang_id_satuan');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_stok')) {
                $data['inputerror'][] = 'barang_stok';
                $data['error_string'][] = $validation->getError('barang_stok');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_harga')) {
                $data['inputerror'][] = 'barang_harga';
                $data['error_string'][] = $validation->getError('barang_harga');
                $data['status'] = false;
            }

            if ($data['status'] === false) {
                echo json_encode($data);
                exit();
            }
        }
    }



    // EXPORT EXCEL
    public function exportExcelBarang()
    {
        $dataBarang = $this->dbBarang->getBarangEkport();
        $filename = 'DataBarang' . date('ymd') . '.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Kode Barang');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Kategori Barang');
        $sheet->setCellValue('D1', 'Satuan Barang');
        $sheet->setCellValue('E1', 'Harga Barang');
        $sheet->setCellValue('F1', 'Stok Barang');
        $sheet->setCellValue('G1', 'Total');

        $column = 2;

        foreach ($dataBarang as $data) {
            $sheet->setCellValue('A' . $column, $data['barang_kode']);
            $sheet->setCellValue('B' . $column, $data['barang_nama']);
            $sheet->setCellValue('C' . $column, $data['kategori_nama']);
            $sheet->setCellValue('D' . $column, $data['satuan_nama']);
            $sheet->setCellValue('E' . $column, $data['barang_harga']);
            $sheet->setCellValue('F' . $column, $data['barang_stok']);
            $sheet->getCell('F2')->getCalculatedValue();
            $column++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length:' . filesize($filename));
        flush();
        readfile($filename);
        exit();
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        // header('Cache-Control: max-age=0');

        // $writer->save('php://output');
    }
}
