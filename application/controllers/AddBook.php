<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddBook extends CI_Controller {

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
        $data['content'] = 'addbook';
		$this->load->view('layouts/main', $data);
	}

    public function add()
    {
        $title = $this->input->post('title');
        $author = $this->input->post('author');
        $quantity = $this->input->post('quantity');

        // Check if the book already exists in library
        $isExist = $this->Book_model->isExist($title, $author);

        if($isExist === false)
        {
            $data = array(
                'name' => $title,
                'author' => $author,
                'quantity' => $quantity,
                'number_available' => $quantity
            );
            
            $this->Book_model->add($data);
        }
    }
}
