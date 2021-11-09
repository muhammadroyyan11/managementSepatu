<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // cek_login();
        date_default_timezone_set('Asia/Jakarta');
        // // $this->load->model('Auth_model', 'auth');
        $this->load->model('Base_model', 'base');
    }

    public function index()
    {
        // $this->load->view('template');
        $data['title'] = 'Transaksi';
        $data['transaksi'] = $this->base_model->joinBarang()->result();
        $data['barang'] = $this->base->getBarang('barang');
        $this->template->load('template', 'transaksi/data', $data);

        
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama barang', 'required|trim');
        $this->form_validation->set_rules('stok', 'Stok', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');
    }

    public function add()
    {
        // echo $this->input->post('categori');
        // echo $id;
       
        // $data = $this->base->getBarangById()->result();        
        $id_barang = $this->input->post('barang_id');
        // $jumlah = str_replace(',', '', $this->input->post('jumlah'));
        $jumlah = str_replace(',', '', $this->input->post('jumlah'));
        $total =str_replace(',', '', $this->input->post('total_harga'));
        $tanggal = $this->input->post('tanggal');

        $row = $this->db->query("SELECT * FROM barang")->row();

        // $this->db->insert('transaksi', array(
        //     'jumlah' => $jumlah,
        //     'total' => $total,
        //     'tanggal' => $tanggal,
        //     'id_barang' => $id_barang
        // ));
        $data = array(
            'jumlah' => $jumlah,
            'total' => $total,
            'tanggal' => $tanggal,
            'id_barang' => $id_barang
        );

        // $qty = $this->input->post('jumlah');
        if ($jumlah > $row->stok) 
		{
			// $output = array(
			// 	'status' => false,
			// 	'message' => '<p>Stock tidak mencukupi,</p><p>Silahkan lakukan Update Stock terlebih dahulu.</p>'
			// );
            set_pesan('Jumlah Melebihi Stok', false);
		} else {
			$this->db->insert('transaksi', $data);
            set_pesan('Data berhasil di simpan');
			
		}


        // if ($this->db->affected_rows()) {
        //     $this->data = array(
        //         'status' => true,
        //         'message' => "Data berhasil disimpan"
        //     );
        // } else {
        //     $this->data = array(
        //         'status' => false,
        //         'message' => "Gagal saat menyimpan data!"
        //     );
        // }

        redirect('transaksi');
    }

    public function delete($id){
		$where=array('id_transaksi' => $id);
		$this->base_model->del('transaksi', $where);
		redirect('transaksi');
	}
}
