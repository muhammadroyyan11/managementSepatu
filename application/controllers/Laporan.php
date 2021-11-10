<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Base_model', 'base');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[masuk,transaksi]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Laporan Transaksi";
            $this->template->load('template', 'laporan/form', $data);
        } else {

            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $dateMasuk = new DateTime();
            $dateKeluar = new DateTime();
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'masuk') {
                // $query = $this->base->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
                $query = $this->base_model->get('barang')->result_array();
                //$data['categori'] = $this->base_model->get('categori');
            } else {
                $query = $this->base_model->joinBarang()->result_array();
            }
            $dateMasuk = new DateTime($mulai);
            $dateKeluar = new DateTime($akhir);
            $newMulai = $dateMasuk->format('d F Y');
            $newKeluar = $dateKeluar->format('d F Y');
            $this->_cetak($query, $table, $tanggal, $newKeluar, $newMulai);

            // print_r($query);
        }
    }

    private function _cetak($data, $table_, $tanggal, $newKeluar, $newMulai)
    {
        $this->load->library('CustomPDF');
        $table = $table_ == 'masuk' ? 'Stok Barang' : 'Transaksi';
        // $dateMasuk = new DateTime($tanggal);

        error_reporting(0);

        $pdf = new FPDF();
        $pdf->AddPage('P', 'A4');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->Ln();

        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(25, 7, 'Tanggal', 0, 0, 'L');
        $pdf->Cell(3, 7, ':', 0, 0, 'L');
        $pdf->Cell(60, 7, $newMulai . ' - ' . $newKeluar, 0, 1, 'L');
        // $pdf->Ln();
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(25, 7, 'Nama User', 0, 0, 'L');
        $pdf->Cell(3, 7, ':', 0, 0, 'L');
        $pdf->Cell(60, 7, userdata('nama'), 0, 0, 'L');
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 11);

        if ($table_ == 'masuk') :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(90, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Stok', 1, 0, 'C');
            $pdf->Cell(55, 7, 'Harga Jual', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Times', '', 11);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(90, 7, $d['nama'], 1, 0, 'L');
                $pdf->Cell(35, 7, $d['stok'], 1, 0, 'C');
                $pdf->Cell(55, 7, 'Rp . ' . number_format($d['harga']), 1, 0, 'L');
                $pdf->Ln();
            }
        else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(100, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Tanggal', 1, 0, 'C');
            $pdf->Cell(15, 7, 'qty', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Sub Total', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            $subtotal = 0;
            foreach ($data as $d) {
                $dateMasuk = new DateTime($d['tanggal']);
                $subtotal += $d['total'];
                $pdf->SetFont('Times', '', 11);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(100, 7, $d['nama'], 1, 0, 'L');
                $pdf->Cell(35, 7, $dateMasuk->format('d F Y'), 1, 0, 'L');
                $pdf->Cell(15, 7, $d['jumlah'], 1, 0, 'C');
                $pdf->Cell(30, 7, 'Rp . ' . number_format($d['total']), 1, 0, 'L');
                $pdf->Ln();
            }
            //echo "Ini keluar";

            $pdf->SetFont('Times', 'B', 11);
            $pdf->Cell(160, 7, 'Total   ', 0, 0, 'R');
            $pdf->Cell(30, 7, 'Rp . ' . number_format($subtotal), 1, 0, 'L');
            $pdf->Ln();
        endif;
        $file_name = userdata('nama') . ' ' . $table . '-' . $tanggal;
        $pdf->Output('I', $file_name);
    }
}
