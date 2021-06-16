<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
        $data['content'] = 'login';
		$this->load->view('layouts/main', $data);
	}

	public function doLogin()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');
		if($this->form_validation->run() == FALSE) {
			
			$data = array(
				'errors' => validation_errors()
				);
			return NULL;

		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$user_id = $this->Login_model->login_user($username,$password);

			if($user_id) {

				$user_data = array(
					'user_id' => $user_id,
					'username' => $username,
					);
				$this->session->set_userdata($user_data);

				echo json_encode($user_data);

			} else {
				return NULL;
			}
		}
	}
}
?>