<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sepatu extends CI_Controller {


	public function index()
	{
		// $this->load->view('template');
		$data['title'] = 'Data Sepatu';
		$this->template->load('template', 'sepatu/data', $data);
	}
}
