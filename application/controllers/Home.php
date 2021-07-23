<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->model('Book_model');
		$this->load->model('Request_model');
	}

	public function index()
	{
        if($this->session->userdata('user_id') === NULL)
        {
            redirect('login');
        }
		$data['books'] = $this->Book_model->getAllBooks();

		// Check if user has a request in-progress
		$condition = array(
			'userid' => $this->session->userdata('user_id'),
			'status' => 0
		);

		if($this->session->userdata('role') === "ADMIN")
		{
			$data['content'] = 'home';
		}
		else
		{
			$requests = $this->Request_model->get($condition);
			$data['isCanRequest'] = count($requests) <= 0;
			
			$data['content'] = 'home_user';
		}
		$this->load->view('layouts/main', $data);
	}
}
