<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


	public function index()
	{
		// $this->load->view('template');
		$data['title'] = 'Home';
		$this->template->load('template', 'dashboard/dashboard', $data);
	}
}
