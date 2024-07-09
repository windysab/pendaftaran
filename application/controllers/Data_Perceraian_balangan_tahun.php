<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Perceraian_balangan_tahun extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_data_perceraian_balangan_tahun");
	}

	public function index()
	{
		
		$lap_tahun = $this->input->post('lap_tahun');
		$data['datafilter'] = $this->M_data_perceraian_balangan_tahun->data_perceraian_balangan_tahun($lap_tahun);
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_perceraian_balangan_tahun', $data);
		$this->load->view('template/new_footer');	
		$this->load->helper('url');
	}
}
