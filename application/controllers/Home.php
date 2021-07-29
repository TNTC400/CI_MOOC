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

	public function LoadPage($page)
	{
		# code...

		$config = array();
		$config['base_url'] = '#';
		$config['total_rows'] = $this->Book_model->countAllBooks();
		$config['per_page'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination div-logout">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li class="page-item no-search-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item no-search-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] =  '&gt;';
		$config['next_tag_open'] = '<li class="next-page no-search-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] =  '&lt;';
		$config['prev_tag_open'] = '<li class="prev-page no-search-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active no-search-item"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page no-search-item">';
		$config['num_tag_close'] = '</li>';
		$config['num_links'] = 1;
		$this->pagination->initialize($config);

		$start = ($page - 1) * $config['per_page'];
		$booksOfPage = $this->Book_model->getBooks($config['per_page'], $start);

		$table = "<table class=\"table\">
		<tr>
			<th class=\"col-sm-4\"> Title </th>
			<th class=\"col-sm-2\"> Quantity </th>
			<th class=\"col-sm-2\"> Available </th>
			<th class=\"col-sm-2\">  </th>
		</tr>";

		if(count($booksOfPage) > 0) {

			foreach($booksOfPage as $book) 
			{
				$table = $table.
				'<tr>
                <td><a href="'.$book->id.'">'.$book->name.'</td>
                <td>'.$book->quantity.'</td>
                <td>'.$book->number_available.'</td>
                <td> <a href="'.base_url("addbook").'/'.$book->id.'"  class="btn btn-lg btn-success btn-block" >Add</a>
                <a href="'.base_url('deletebook').'/'.$book->id.'" class="btn btn-lg btn-danger btn-block" type="submit">Delete</a> </td>
            	</tr>';
			}
		}

		$table = $table. "</table>";

		$resp = array(
			'bookTable' => $table,
			'pagination_link' => $this->pagination->create_links()
		);

		echo json_encode($resp);
	}

	public function Search($page = 1)
	{
		$searchString = $this->input->post('inputString');

		$config = array();
		
		if($searchString == '') {
			$config['base_url'] = '#';
			$config['total_rows'] = $this->Book_model->countAllBooks();
			$config['per_page'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination div-logout">';
			$config['full_tag_close'] = '</ul>';
			$config['first_tag_open'] = '<li class="page-item no-search-item">';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li class="page-item no-search-item">';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] =  '&gt;';
			$config['next_tag_open'] = '<li class="next-page no-search-item">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] =  '&lt;';
			$config['prev_tag_open'] = '<li class="prev-page no-search-item">';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="page-item active no-search-item"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="page no-search-item">';
			$config['num_tag_close'] = '</li>';
			$config['num_links'] = 1;
			$this->pagination->initialize($config);
		} else {
			$config['base_url'] = '#';
			$config['total_rows'] = $this->Book_model->countAllBooks($searchString);
			$config['per_page'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination div-logout">';
			$config['full_tag_close'] = '</ul>';
			$config['first_tag_open'] = '<li class="page-item search-item">';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li class="page-item search-item">';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] =  '&gt;';
			$config['next_tag_open'] = '<li class="next-page search-item">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] =  '&lt;';
			$config['prev_tag_open'] = '<li class="prev-page search-item">';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="page-item active search-item"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="page search-item">';
			$config['num_tag_close'] = '</li>';
			$config['num_links'] = 1;
			$this->pagination->initialize($config);
		}

		$start = ($page - 1) * $config['per_page'];
		$booksOfPage = $this->Book_model->search($searchString, $config['per_page'], $start);

		$table = "";
		if($this->session->userdata('role') === "ADMIN") {
			$table =  $this->CreateBookTable_Admin($booksOfPage);
		} else {
			$table = $this->CreateBookTable_User($booksOfPage);
		}
		

		$resp = array(
			'bookTable' => $table,
			'pagination_link' => $this->pagination->create_links()
		);

		echo json_encode($resp);
	}

	public function CreateBookTable_Admin($booksOfPage)
	{
		# code...
		$table = "<table class=\"table\">
		<tr>
			<th class=\"col-sm-4\"> Title </th>
			<th class=\"col-sm-2\"> Quantity </th>
			<th class=\"col-sm-2\"> Available </th>
			<th class=\"col-sm-2\">  </th>
		</tr>";

		if(count($booksOfPage) > 0) {

			foreach($booksOfPage as $book) 
			{
				$table = $table.
				'<tr>
                <td><a href="'.$book->id.'">'.$book->name.'</td>
                <td>'.$book->quantity.'</td>
                <td>'.$book->number_available.'</td>
                <td> <a href="'.base_url("addbook").'/'.$book->id.'"  class="btn btn-lg btn-success btn-block" >Add</a>
                <a href="'.base_url('deletebook').'/'.$book->id.'" class="btn btn-lg btn-danger btn-block" type="submit">Delete</a> </td>
            	</tr>';
			}
		}

		$table = $table. "</table>";

		return $table;
	}

	public function CreateBookTable_User($booksOfPage)
	{
		# code...
		// Check if user has a request in-progress
		$condition = array(
			'userid' => $this->session->userdata('user_id'),
			'status' => 0
		);
		$requests = $this->Request_model->get($condition);
		$isCanRequest = count($requests) <= 0;
		
		$table = '<table class="table">
            <tr>
                <th class="col-sm-4"> Title </th>
                <th class="col-sm-2"> Available </th>
                <th class="col-sm-2"></th>
            </tr>';
		foreach($booksOfPage as $book)
		{
			$table = $table . '<tr>
			<td><a href="'.base_url('bookdetail/'.$book->id).'">'.$book->name.'</td>
			<td>'.$book->number_available.'</td>
			<td>';
			if($isCanRequest === true && $book->number_available > 0) {
				$table = $table.'<a href="'.base_url('request/'.$book->id).'"  class="btn btn-lg btn-success btn-block" >Request</a>';				
			}
			$table = $table . '</td>
			</tr>';
		};

		$table = $table .'</table>';

		return $table;
	}
}
