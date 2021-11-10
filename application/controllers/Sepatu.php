<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sepatu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_login();
        date_default_timezone_set('Asia/Jakarta');
        // // $this->load->model('Auth_model', 'auth');
        $this->load->model('Base_model', 'base');
    }

    public function index()
    {
        // $this->load->view('template');
        $data['title'] = 'Data Sepatu';
        $data['barang'] = $this->base_model->get('barang')->result();
        $this->template->load('template', 'sepatu/data', $data);

        
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama', 'Nama barang', 'required|trim');
        $this->form_validation->set_rules('stok', 'Stok', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');
    }

    public function add()
    {
        // echo $this->input->post('categori');
        
        $this->db->insert('barang', array(
            'nama' => $this->input->post('nama_barang'),
            'stok' => str_replace(',', '', $this->input->post('stok')),
            'harga' => str_replace(',', '', $this->input->post('harga'))
            // 'description' => $this->input->post('description'),
            // // 'user_id' => userdata('id_user')
            // 'id_user' => userdata('id_user'),
            // 'category' => $this->input->post('categori')
        ));

        if ($this->db->affected_rows()) {
            $this->data = array(
                'status' => true,
                'message' => "Data berhasil disimpan"
            );
            set_pesan('Data berhasil di simpan');
        } else {
            $this->data = array(
                'status' => false,
                'message' => "Gagal saat menyimpan data!"
            );
            set_pesan('Gagal saat menyimpan data', false);
        }

        redirect('sepatu');
    }

    public function delete($id){
		$where=array('id_barang' => $id);
		$this->base_model->del('barang', $where);
		redirect('sepatu');
	}

    public function edit($id)
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Edit Barang";
            $data['barang'] = $this->base->getBarang('barang', ['id_barang' => $id]);
            $this->template->load('template', 'sepatu/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->base->update('barang', 'id_barang', $id, $input);
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('sepatu');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('sepatu/add');
            }
        }
    }

    public function detail($id)
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Edit Barang";
            $data['barang'] = $this->base->getBarang('barang', ['id_barang' => $id]);
            $this->template->load('template', 'sepatu/detail', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->base->update('barang', 'id_barang', $id, $input);
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('sepatu');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('sepatu/add');
            }
        }
    }

    public function getHarga($id)
    {
        // $id = encode_php_tags($getId);
        $query = $this->base_model->cekHarga($id);
        output_json($query);
    }
}
