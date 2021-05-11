<?php


defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . '/libraries/REST_Controller.php';

use chriskacerguis\RestServer\RestController;
// use Restserver\Libraries\REST_Controller;
require APPPATH . '/libraries/REST_Controller.php';
class AccelerometerAPI extends RestController
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
        $this->load->model("AccelerometerModel");
    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'content' => 'vDashboard',
            'dataAccelerometer' => $this->AccelerometerModel->getAll(),
        ];

        $this->load->view('templateDashboard/wrapper', $data);
    }
}
