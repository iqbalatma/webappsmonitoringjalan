<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("UsersModel");
		$this->load->model("LocationModel");
	}
	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'content' => 'vDashboard',
			'dataAccelerometer' => $this->LocationModel->getAll(),
		];

		$this->load->view('templateDashboard/wrapper', $data);
	}
	public function jalanRusak()
	{
		$data = [
			'title' => 'Dashboard',
			'content' => 'vDashboard',
			'dataAccelerometer' => $this->LocationModel->getDataRusak(),
		];

		$this->load->view('templateDashboard/wrapper', $data);
	}
	public function jalanRusakTerverifikasi()
	{
		$data = [
			'title' => 'Dashboard',
			'content' => 'vDashboard',
			'dataAccelerometer' => $this->LocationModel->getDataRusakTerverifikasi(),
		];

		$this->load->view('templateDashboard/wrapper', $data);
	}
	public function altitude()
	{
		$data = [
			'title' => 'Dashboard',
			'content' => 'vAltitude',
			'dataAccelerometer' => $this->AltitudeModel->getAll(),
		];

		$this->load->view('templateDashboard/wrapper', $data);
	}


	public function chart()
	{

		$this->load->view('multichart');
	}
}
