<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sepatu extends CI_Controller {

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
		$data['title'] = 'Data Sepatu';
        $data['barang'] = $this->base_model->get('barang')->result();
		$this->template->load('template', 'sepatu/data', $data);
	}
}
