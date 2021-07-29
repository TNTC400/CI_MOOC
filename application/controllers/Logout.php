<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{        
	}

	public function doLogout()
	{
		
		$this->session->sess_destroy();
		$resp = array(
			'redirect' => base_url('login')
		);

		echo json_encode($resp);
	}
}
?>