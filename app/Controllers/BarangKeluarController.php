<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\BarangKeluarModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BarangKeluarController extends BaseController
{
    protected $dbBarang;
    protected $dbBarangKeluar;

    public function __construct()
    {
        $this->dbBarang = new BarangModel();
        $this->dbBarangKeluar = new BarangKeluarModel();
    }

    public function barangkeluar()
    {
        $data = [
            'barangs'   => $this->dbBarang->findAll(),
            'kodeotomatis' => $this->dbBarangKeluar->generateTransactionCode(),
            'sidebar' => 'barangkeluar'
        ];
        return view('transaksi/barangkeluar', $data);
    }



    public function readBarangKeluar()
    {
        $draw = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->dbBarangKeluar->ajaxGetTotal();
        $output = [
            'length' => $length,
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ];

        if ($search !== "") {
            $list = $this->dbBarangKeluar->ajaxGetDataSearch($search, $start, $length);
        } else {
            $list = $this->dbBarangKeluar->ajaxGetData($start, $length);
        }

        if ($search !== "") {
            $total_search = $this->dbBarangKeluar->ajaxGetTotalSearch($search);
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
                    <a href="javascript:void(0)" onclick="detailBarangKeluar(' . $temp['barang_keluar_id'] . ')"><i class="btn btn-sm btn-primary fas fa-eye"> </i></a>
                    <a href="javascript:void(0)" onclick="editBarangKeluar(' . $temp['barang_keluar_id'] . ')"><i class="btn btn-sm btn-success fas fa-edit"> </i></a>
                    <a href="javascript:void(0)" onclick="deleteBarangKeluar(' . $temp['barang_keluar_id'] . ')"><i class="btn btn-sm btn-danger fas fa-trash-alt"> </i></a>
            </div>
                    ';

            $row = [];
            $row[] = $no;
            $row[] = $temp['barang_keluar_tanggal'];
            $row[] = $temp['barang_keluar_kode'];
            $row[] = $temp['barang_kode'];
            $row[] = $temp['barang_keluar_jumlah'];
            $row[] = $aksi;

            $data[] = $row;
            $no++;
        }

        $output['data'] = $data;

        echo json_encode($output);
        exit();
    }



    public function multipleAddBarangKeluar()
    {
        $data = [
            'barangs'   => $this->dbBarang->findAll(),
            'kodeotomatis' => $this->dbBarangKeluar->generateTransactionCode(),
            'sidebar' => 'barangkeluar'
        ];
        return view('transaksi/barangkeluar_multipleadd', $data);
    }



    public function detailBarangKeluar($barangkeluar_id)
    {
        $data = $this->dbBarangKeluar->find($barangkeluar_id);
        echo json_encode($data);
    }



    public function editBarangKeluar($barangkeluar_id)
    {
        $data = $this->dbBarangKeluar->find($barangkeluar_id);
        echo json_encode($data);
    }



    public function updateBarangKeluar()
    {
        $this->_validateBarangKeluar('update');
        $barang_keluar_id = $this->request->getVar('barang_keluar_id');
        $task = $this->dbBarangKeluar->find($barang_keluar_id);

        $data = [
            'barang_keluar_id' => $barang_keluar_id,
            'barang_id' => $this->request->getVar('barang_id'),
            'barang_keluar_kode' => $this->request->getVar('barang_keluar_kode'),
            'barang_keluar_jumlah' => $this->request->getVar('barang_keluar_jumlah'),
            'barang_keluar_tanggal' => $this->request->getVar('barang_keluar_tanggal'),
        ];

        if ($this->dbBarangKeluar->save($data)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }



    public function deleteBarangKeluar($barangkeluar_id)
    {
        if ($this->dbBarangKeluar->delete($barangkeluar_id)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }



    public function saveBarangKeluar()
    {
        $barang_id = $this->request->getVar('barang_id');
        $barang_keluar_jumlah = $this->request->getVar('barang_keluar_jumlah');
        $this->_validateBarangKeluar('save');
        $data = [
            'barang_id' => $this->request->getVar('barang_id'),
            'barang_keluar_kode' => $this->request->getVar('barang_keluar_kode'),
            'barang_keluar_jumlah' => $this->request->getVar('barang_keluar_jumlah'),
            'barang_keluar_tanggal' => $this->request->getVar('barang_keluar_tanggal'),
        ];
        $barang_stok = $this->dbBarang->getBarangStok($barang_id);
        if ($barang_stok < $barang_keluar_jumlah) {
            echo "Stok tidak cukup";
            return redirect()->back();
        }
        $this->dbBarangKeluar->save($data);
        $this->dbBarang->set('barang_stok', 'barang_stok -' . $barang_keluar_jumlah, false)->where('barang_id', $barang_id)->update();
        echo json_encode(['status' => true]);

        // if ($this->dbBarangKeluar->save($data)) {
        //     $this->dbBarang->set('barang_stok', 'barang_stok -' . $barang_keluar_jumlah, false)->where('barang_id', $barang_id)->update();
        //     echo json_encode(['status' => true]);
        // } else {
        //     echo json_encode(['status' => false]);
        // }
    }
    public function saveMultipleBarangKeluar()
    {
        if ($this->request->isAJAX()) {
            $barang_keluar_kode = $this->request->getVar('barang_keluar_kode');
            $barang_id = $this->request->getVar('barang_id');
            $barang_keluar_tanggal = $this->request->getVar('barang_keluar_tanggal');
            $barang_keluar_jumlah = $this->request->getVar('barang_keluar_jumlah');

            $jumlahData = count($barang_keluar_kode);

            for ($i = 0; $i < $jumlahData; $i++) {
                $this->dbBarangKeluar->insert([
                    'barang_keluar_kode'     => $barang_keluar_kode[$i],
                    'barang_id'             => $barang_id[$i],
                    'barang_keluar_tanggal'  => $barang_keluar_tanggal[$i],
                    'barang_keluar_jumlah'   => $barang_keluar_jumlah[$i],
                    // Update stok barang
                    $this->dbBarang->set('barang_stok', 'barang_stok -' . $barang_keluar_jumlah[$i], false)->where('barang_id', $barang_id[$i])->update()

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



    public function _validateBarangKeluar($method)
    {
        if (!$this->validate($this->dbBarangKeluar->getRulesValidation($method))) {
            $validation = \Config\Services::validation();
            $data = [];
            $data['error_string'] = [];
            $data['inputerror'] = [];
            $data['status'] = true;

            if ($validation->hasError('barang_keluar_kode')) {
                $data['inputerror'][] = 'barang_keluar_kode';
                $data['error_string'][] = $validation->getError('barang_keluar_kode');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_id')) {
                $data['inputerror'][] = 'barang_id';
                $data['error_string'][] = $validation->getError('barang_id');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_keluar_jumlah')) {
                $data['inputerror'][] = 'barang_keluar_jumlah';
                $data['error_string'][] = $validation->getError('barang_keluar_jumlah');
                $data['status'] = false;
            }
            if ($validation->hasError('barang_keluar_tanggal')) {
                $data['inputerror'][] = 'barang_keluar_tanggal';
                $data['error_string'][] = $validation->getError('barang_keluar_tanggal');
                $data['status'] = false;
            }

            if ($data['status'] === false) {
                echo json_encode($data);
                exit();
            }
        }
    }



    public function exportExcelBarangKeluar()
    {
        $dataBarang = $this->dbBarangKeluar->getBarangKeluarEkport();
        $filename = 'DataBarangKeluar' . date('ymd') . '.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getHeaderFooter()->setOddHeader('&C&HData Barang Keluar');
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
            $sheet->setCellValue('A' . $column, $data['barang_keluar_tanggal']);
            $sheet->setCellValue('B' . $column, $data['barang_keluar_kode']);
            $sheet->setCellValue('C' . $column, $data['barang_kode']);
            $sheet->setCellValue('D' . $column, $data['barang_nama']);
            $sheet->setCellValue('E' . $column, $data['barang_harga']);
            $sheet->setCellValue('F' . $column, $data['kategori_nama']);
            $sheet->setCellValue('G' . $column, $data['satuan_nama']);
            $sheet->setCellValue('H' . $column, $data['barang_keluar_jumlah']);
            $sheet->setCellValue('I' . $column, $data['barang_harga'] * $data['barang_keluar_jumlah']);
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
