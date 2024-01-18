<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\BarangMasukModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BarangMasukController extends BaseController
{
    protected $dbBarang;
    protected $dbBarangMasuk;

    public function __construct()
    {
        $this->dbBarang = new BarangModel();
        $this->dbBarangMasuk = new BarangMasukModel();
    }

    public function barangmasuk()
    {
        $data = [
            'barangs'   => $this->dbBarang->findAll(),
            'kodeotomatis' => $this->dbBarangMasuk->generateTransactionCode(),
            'sidebar' => 'barangmasuk'
        ];
        return view('transaksi/barangmasuk', $data);
    }



    public function readBarangMasuk()
    {
        $draw = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->dbBarangMasuk->ajaxGetTotal();
        $output = [
            'length' => $length,
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ];

        if ($search !== "") {
            $list = $this->dbBarangMasuk->ajaxGetDataSearch($search, $start, $length);
        } else {
            $list = $this->dbBarangMasuk->ajaxGetData($start, $length);
        }

        if ($search !== "") {
            $total_search = $this->dbBarangMasuk->ajaxGetTotalSearch($search);
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
                    <a href="javascript:void(0)" onclick="detailBarangMasuk(' . $temp['barang_masuk_id'] . ')"><i class="btn btn-sm btn-primary fas fa-eye"> </i></a>
                    <a href="javascript:void(0)" onclick="editBarangMasuk(' . $temp['barang_masuk_id'] . ')"><i class="btn btn-sm btn-success fas fa-edit"> </i></a>
                    <a href="javascript:void(0)" onclick="deleteBarangMasuk(' . $temp['barang_masuk_id'] . ')"><i class="btn btn-sm btn-danger fas fa-trash-alt"> </i></a>
            </div>
                    ';

            $row = [];
            $row[] = $no;
            $row[] = $temp['barang_masuk_tanggal'];
            $row[] = $temp['barang_masuk_kode'];
            $row[] = $temp['barang_kode'];
            $row[] = $temp['barang_masuk_jumlah'];
            $row[] = $aksi;

            $data[] = $row;
            $no++;
        }

        $output['data'] = $data;

        echo json_encode($output);
        exit();
    }



    public function multipleAddBarangMasuk()
    {
        $data = [
            'barangs'   => $this->dbBarang->findAll(),
            'kodeotomatis' => $this->dbBarangMasuk->generateTransactionCode(),
            'sidebar' => 'barangmasuk'
        ];
        return view('transaksi/barangmasuk_multipleadd', $data);
    }



    public function detailBarangMasuk($barangmasuk_id)
    {
        $data = $this->dbBarangMasuk->find($barangmasuk_id);
        echo json_encode($data);
    }



    public function editBarangMasuk($barangmasuk_id)
    {
        $data = $this->dbBarangMasuk->find($barangmasuk_id);
        echo json_encode($data);
    }



    public function updateBarangMasuk()
    {
        $this->_validateBarangMasuk('update');
        $barang_masuk_id = $this->request->getVar('barang_masuk_id');
        $task = $this->dbBarangMasuk->find($barang_masuk_id);

        $data = [
            'barang_masuk_id' => $barang_masuk_id,
            'barang_id' => $this->request->getVar('barang_id'),
            'barang_masuk_kode' => $this->request->getVar('barang_masuk_kode'),
            'barang_masuk_jumlah' => $this->request->getVar('barang_masuk_jumlah'),
            'barang_masuk_tanggal' => $this->request->getVar('barang_masuk_tanggal'),
        ];

        if ($this->dbBarangMasuk->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }



    public function deleteBarangMasuk($barangmasuk_id)
    {
        if ($this->dbBarangMasuk->delete($barangmasuk_id)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }



    public function saveBarangMasuk()
    {
        $barang_id = $this->request->getVar('barang_id');
        $barang_masuk_jumlah = $this->request->getVar('barang_masuk_jumlah');
        $this->_validateBarangMasuk('save');
        $data = [
            'barang_id' => $this->request->getVar('barang_id'),
            'barang_masuk_kode' => $this->request->getVar('barang_masuk_kode'),
            'barang_masuk_jumlah' => $this->request->getVar('barang_masuk_jumlah'),
            'barang_masuk_tanggal' => $this->request->getVar('barang_masuk_tanggal'),
        ];

        if ($this->dbBarangMasuk->save($data)) {
            // Update stok barang
            $this->dbBarang->set('barang_stok', 'barang_stok +' . $barang_masuk_jumlah, false)->where('barang_id', $barang_id)->update();

            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function saveMultipleBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $barang_masuk_kode = $this->request->getVar('barang_masuk_kode');
            $barang_id = $this->request->getVar('barang_id');
            $barang_masuk_tanggal = $this->request->getVar('barang_masuk_tanggal');
            $barang_masuk_jumlah = $this->request->getVar('barang_masuk_jumlah');

            $jumlahData = count($barang_masuk_kode);

            for ($i = 0; $i < $jumlahData; $i++) {
                $this->dbBarangMasuk->insert([
                    'barang_masuk_kode'     => $barang_masuk_kode[$i],
                    'barang_id'             => $barang_id[$i],
                    'barang_masuk_tanggal'  => $barang_masuk_tanggal[$i],
                    'barang_masuk_jumlah'   => $barang_masuk_jumlah[$i],
                    // Update stok barang
                    $this->dbBarang->set('barang_stok', 'barang_stok +' . $barang_masuk_jumlah[$i], false)->where('barang_id', $barang_id[$i])->update()

                ]);
            }
            $msg = [
                'success' => "$jumlahData Data berhasil di simpan"
            ];
            echo json_encode($msg);
        } else {
            exit('Oops, Something went wrong');
        }
    }



    public function _validateBarangMasuk($method)
    {
        if (!$this->validate($this->dbBarangMasuk->getRulesValidation($method))) {
            $validation = \Config\Services::validation();
            $data = [];
            $data['error_string'] = [];
            $data['inputerror'] = [];
            $data['status'] = true;

            if ($validation->hasError('barang_masuk_kode')) {
                $data['inputerror'][] = 'barang_masuk_kode';
                $data['error_string'][] = $validation->getError('barang_masuk_kode');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_id')) {
                $data['inputerror'][] = 'barang_id';
                $data['error_string'][] = $validation->getError('barang_id');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_masuk_jumlah')) {
                $data['inputerror'][] = 'barang_masuk_jumlah';
                $data['error_string'][] = $validation->getError('barang_masuk_jumlah');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_masuk_tanggal')) {
                $data['inputerror'][] = 'barang_masuk_tanggal';
                $data['error_string'][] = $validation->getError('barang_masuk_tanggal');
                $data['status'] = false;
            }

            if ($data['status'] === false) {
                echo json_encode($data);
                exit();
            }
        }
    }



    public function exportExcelBarangMasuk()
    {
        $dataBarang = $this->dbBarangMasuk->getBarangMasukEkport();
        $filename = 'DataBarangMasuk' . date('ymd') . '.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getHeaderFooter()->setOddHeader('&C&HData Barang Masuk');
        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'Kode Transaksi');
        $sheet->setCellValue('C1', 'Kode Barang');
        $sheet->setCellValue('D1', 'Nama');
        $sheet->setCellValue('E1', 'Harga');
        $sheet->setCellValue('F1', 'Kategori');
        $sheet->setCellValue('G1', 'Satuan');
        $sheet->setCellValue('H1', 'Jumlah');
        $sheet->setCellValue('I1', 'Total');

        $column = 2;

        foreach ($dataBarang as $data) {
            $sheet->setCellValue('A' . $column, $data['barang_masuk_tanggal']);
            $sheet->setCellValue('B' . $column, $data['barang_masuk_kode']);
            $sheet->setCellValue('C' . $column, $data['barang_kode']);
            $sheet->setCellValue('D' . $column, $data['barang_nama']);
            $sheet->setCellValue('E' . $column, $data['barang_harga']);
            $sheet->setCellValue('F' . $column, $data['kategori_nama']);
            $sheet->setCellValue('G' . $column, $data['satuan_nama']);
            $sheet->setCellValue('H' . $column, $data['barang_masuk_jumlah']);
            $sheet->setCellValue('I' . $column, $data['barang_harga'] * $data['barang_masuk_jumlah']);
            $sheet->setAutoFilter('A:I');
            $sheet->getStyle('I')->getNumberFormat()->setFormatCode('#,##0');
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
