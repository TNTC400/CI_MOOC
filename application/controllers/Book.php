<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller {

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
	}

	public function index()
	{
        if($this->session->userdata('user_id') === NULL)
        {
            redirect('login');
        }
        $data['content'] = 'bookdetail';
		$this->load->view('layouts/main', $data);
	}

    public function detail($id)
    {
        if($this->session->userdata('user_id') === NULL)
        {
            redirect('login');
        }
        // Get detail of the selected book here

		$book = $this->Book_model->getBook($id);

		$data['book'] = $book;
        $data['content'] = 'bookdetail';
		$this->load->view('layouts/main', $data);
    }

	public function ShowPageAddExisted($id)
	{
		$book = $this->Book_model->getBook($id);

		$data['book'] = $book;
		$data['content'] = 'addexistedbook';
		$this->load->view('layouts/main', $data);
	}

	public function ShowPageDeleteExisted($id)
	{
		$book = $this->Book_model->getBook($id);

		$data['book'] = $book;
		$data['content'] = 'deletebook';
		$this->load->view('layouts/main', $data);
	}

	public function AddExisted($id)
	{
		$quantity = $this->input->post('quantity');
		$book = $this->Book_model->getBook($id);
		$data = array(
			'quantity' => $quantity + $book->quantity,
			'number_available' => $quantity + $book->number_available
		);

		$conditions = array(
			'id' => $id
		);
		$this->Book_model->update($data,$conditions);

		$newbook = $this->Book_model->getBook($id);

		$response = array(
			'redirect' => base_url('home')
		);
		
		echo json_encode($response);
	}

	public function Delete($id)
	{	
		$conditions = array(
			'id' => $id
		);	
		$this->Book_model->delete($conditions);

		
		$response = array(
			'redirect' => base_url('home')
		);
		
		echo json_encode($response);
	}
}
