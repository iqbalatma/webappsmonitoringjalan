<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	private $jenis_data_jalan;
	/**
	 * Ini adalah consturctor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("UsersModel");
		$this->load->model("LocationModel");
	}


	/**
	 * Ini adalah method index
	 */
	public function index($jenis_data_jalan = "")
	{
		$this->jenis_data_jalan = $jenis_data_jalan;

		switch ($this->jenis_data_jalan) {
			case "":
				$this->jenis_data_jalan = $this->LocationModel->getAll();
				break;
			case "1":
				$this->jenis_data_jalan = $this->LocationModel->getDataRusak();
				break;
			case "2":
				$this->jenis_data_jalan = $this->LocationModel->getDataRusakTerverifikasi();
				break;
			case "3":
				$this->jenis_data_jalan = $this->LocationModel->getDataDiperbaiki();
				break;
			default:
				$this->jenis_data_jalan = $this->LocationModel->getAll();
		}
		$data = [
			'title' => 'Dashboard',
			'content' => 'vDashboard',
			'dataAccelerometer' => $this->jenis_data_jalan
		];
		return $this->load->view('templateDashboard/wrapper', $data);
	}
















	/**
	 * Ini adalah method untuk demo
	 */
	public function chart()
	{
		$this->load->view('multichart');
	}
}
