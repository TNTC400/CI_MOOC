<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RequestManage extends CI_Controller {

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
		$this->load->model('Request_model');
		$this->load->model('Book_model');
	}


	public function index()
	{
        if($this->session->userdata('user_id') === NULL)
        {
            redirect('login');
        }

		// Get all request which in progress, accepted. (Not done yet)
		$requests = $this->Request_model->getAll();

		$data['requests'] = $requests;
        $data['content'] = 'requestmanage';
		$this->load->view('layouts/main', $data);
	}

	public function ShowPageRequest($id)
	{
		# code...
		if($this->session->userdata('user_id') === NULL)
        {
            redirect('login');
        };

		$userActiveRequests = $this->Request_model->getUserActiveRequests($this->session->userdata('user_id'));

		if(count($userActiveRequests) > 0) {
			redirect('home');
		}

		$book = $this->Book_model->getBook($id);

		$data['book'] = $book;
        $data['content'] = 'request';
		$this->load->view('layouts/main', $data);
	}

	public function Request($id)
	{
		# code...
		$data = array(
			'bookid' => $id,
			'userid' => $this->session->userdata('user_id')
		);

		// Check if this user already had a request in-progress
		$userActiveRequests = $this->Request_model->getUserActiveRequests($this->session->userdata('user_id'));

		if(count($userActiveRequests) > 0) return;

		// Add a request to requests table
		$this->Request_model->add($data);
		// Update number of available
		$updated_book_info = $this->Book_model->getBook($id);

		if($updated_book_info->number_available >= 1)
		{
			$book_update_data = array(
				'number_available' => $updated_book_info->number_available-1
			);

			$book_update_condition = array(
				'id' => $id
			);

			$this->Book_model->update($book_update_data, $book_update_condition);
		}

		$resp = array(
			'redirect' => base_url('home')
		);

		echo json_encode($resp);

	}

	public function UserRequest()
	{
		# code...

		if($this->session->userdata('user_id') === NULL)
        {
            redirect('login');
        };

		$condition = array(
			'userid' => $this->session->userdata('user_id'),
		);

		$myrequests = $this->Request_model->getUserActiveRequests($this->session->userdata('user_id'));
		$myrequest = null;
		if(count($myrequests) > 0) {
			$myrequest = $myrequests[0];
		};

		$data['request'] = NULL;
		if($myrequest !== NULL)
		{
			$request_status = 'In Progress';
			switch($myrequest->status)
			{
				case 1:
					$request_status = 'Accepted';
					break;
				case 2:
					$request_status = 'Returned';
					break;
				default:
					break;
			};

			$request = array(
				'booktitle' => $myrequest->booktitle,
				'request_date' => $myrequest->request_date,
				'request_status' => $request_status
			);

			$data['booktitle'] = $myrequest->booktitle;
			$data['request_date'] = $myrequest->request_date;
			$data['request_status'] = $request_status;
			$data['request'] = $request;
		}


		
        $data['content'] = 'userrequestmanage';
		$this->load->view('layouts/main', $data);
	}

	public function AcceptRequest($requestId)
	{
		# code...

		// Update request status
		$data = array(
			'status' => 1
		);

		$condition = array(
			'id' => $requestId
		);

		$this->Request_model->update($data,$condition);

		$resp = array(
			'isUpdated' => true,
			'redirect' => base_url('requestmanage')
		);

		echo json_encode($resp);
	}

	public function BookReturn($requestId)
	{
		# code...

		// Update request status
		$data = array(
			'status' => 2
		);

		$condition = array(
			'id' => $requestId
		);

		$this->Request_model->update($data,$condition);

		// Update available number of book
		$request = $this->Request_model->get($condition)[0];
		
		$bookCondition = array(
			'id' => $request->bookid
		);

		
		$returnedBook = $this->Book_model->getBook($request->bookid);

		$bookdata = array(
			'number_available' => $returnedBook->number_available+1
		);

		$this->Book_model->update($bookdata, $bookCondition);

		$resp = array(
			'isUpdated' => true,
			'redirect' => base_url('borrowingmanage')
		);

		echo json_encode($resp);
	}

	public function Search()
	{
		# code...
		$searchString = $this->input->post('inputString');

		$requests = $this->Request_model->search($searchString);

		$tablehtml = "<table class=\"table\">
			<tr>
			<th class=\"col-sm-2 text-center\"> User </th>
			<th class=\"col-sm-5 text-center\"> Requested book </th>
			<th class=\"col-sm-1 text-center\"> Request date </th>
			<th class=\"col-sm-1 text-center\"> Accept </th>
			</tr>";
		if(count($requests) > 0) {
			
			foreach($requests as $request)
			{
				$tablehtml = $tablehtml . "<tr>
                <td class=\"text-center\">".$request->username."</td>
                <td class=\"text-center\">".$request->booktitle."</td>
                <td class=\"text-center\">".$request->request_date."</td>
                <td class=\"text-center\"> <button class=\"btn btn-lg btn-primary btn-block button-accept\" value=".$request->id.">";
				if($request->status == 0) {
					$tablehtml = $tablehtml." Accept ";
				} else {
					$tablehtml = $tablehtml." Return ";
				}
				$tablehtml = $tablehtml."</button></td>
            	</tr>";
			}

			$tablehtml = $tablehtml."</table>";
		} else {
			$tablehtml = $tablehtml . "</table> <h6 class=\"text-center\"> No result.</h6>";
		}

		$resp = array(
			'redirect' => base_url('requestmanage'),
			'tableHTML' => $tablehtml
		);

		echo json_encode($resp);
	}

	public function BorrowingPage()
	{
		# code...
		if($this->session->userdata('user_id') === NULL)
        {
            redirect('login');
        }

        $data['content'] = 'borrowingmanage';
		$this->load->view('layouts/main', $data);
	}

	public function BorrowingSearch($page = 1)
	{
		$searchString = $this->input->post('inputString');

		$config = array();
		
		if($searchString == '') {
			$config['base_url'] = '#';
			$config['total_rows'] = $this->Request_model->countAllBorrowing($searchString);
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
			$config['total_rows'] = $this->Request_model->countAllBorrowing($searchString);
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
		$requestsOfPage = $this->Request_model->searchBorrowing($searchString, $config['per_page'], $start);

		$table = "";
		$table =  $this->CreateBorrowingBooksTable($requestsOfPage);
		

		$resp = array(
			'requestTable' => $table,
			'pagination_link' => $this->pagination->create_links()
		);

		echo json_encode($resp);
	}

	public function CreateBorrowingBooksTable($requests)
	{
		# code...
		$tablehtml = "<table class=\"table\">
			<tr>
			<th class=\"col-sm-2 text-center\"> User </th>
			<th class=\"col-sm-5 text-center\"> Requested book </th>
			<th class=\"col-sm-1 text-center\"> Request date </th>
			<th class=\"col-sm-1 text-center\"></th>
			</tr>";
		if(count($requests) > 0) {
			
			foreach($requests as $request)
			{
				$tablehtml = $tablehtml . "<tr>
                <td class=\"text-center\">".$request->username."</td>
                <td class=\"text-center\">".$request->booktitle."</td>
                <td class=\"text-center\">".$request->request_date."</td>
                <td class=\"text-center\"> <button class=\"btn btn-lg btn-primary btn-block button-accept\" value=".$request->id.">";
				$tablehtml = $tablehtml." Return ";
				$tablehtml = $tablehtml."</button></td>
            	</tr>";
			}

			$tablehtml = $tablehtml."</table>";
		} else {
			$tablehtml = $tablehtml . "</table> <h6 class=\"text-center\"> No result.</h6>";
		}

		return $tablehtml;
	}

	public function RequestSearch($page = 1)
	{
		$searchString = $this->input->post('inputString');

		$config = array();
		
		if($searchString == '') {
			$config['base_url'] = '#';
			$config['total_rows'] = $this->Request_model->countAllRequest($searchString);
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
			$config['total_rows'] = $this->Request_model->countAllRequest($searchString);
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
		$requestsOfPage = $this->Request_model->searchRequest($searchString, $config['per_page'], $start);

		$table = "";
		$table =  $this->CreateRequestTable($requestsOfPage);
		

		$resp = array(
			'requestTable' => $table,
			'pagination_link' => $this->pagination->create_links()
		);

		echo json_encode($resp);
	}

	public function CreateRequestTable($requests)
	{
		# code...
		$tablehtml = "<table class=\"table\">
			<tr>
			<th class=\"col-sm-2 text-center\"> User </th>
			<th class=\"col-sm-5 text-center\"> Requested book </th>
			<th class=\"col-sm-1 text-center\"> Request date </th>
			<th class=\"col-sm-1 text-center\"></th>
			</tr>";
		if(count($requests) > 0) {
			
			foreach($requests as $request)
			{
				$tablehtml = $tablehtml . "<tr>
                <td class=\"text-center\">".$request->username."</td>
                <td class=\"text-center\">".$request->booktitle."</td>
                <td class=\"text-center\">".$request->request_date."</td>
                <td class=\"text-center\"> <button class=\"btn btn-lg btn-primary btn-block button-accept\" value=".$request->id.">";
				$tablehtml = $tablehtml." Accept ";
				$tablehtml = $tablehtml."</button></td>
            	</tr>";
			}

			$tablehtml = $tablehtml."</table>";
		} else {
			$tablehtml = $tablehtml . "</table> <h6 class=\"text-center\"> No result.</h6>";
		}

		return $tablehtml;
	}
}
