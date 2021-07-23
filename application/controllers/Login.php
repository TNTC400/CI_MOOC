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
			$option = ['cost' => 12];
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			$user = $this->Login_model->login_user($username,$password);
			if($user) {

				$user_data = array(
					'user_id' => $user->id,
					'username' => $username,
					'role' => $user->role,
					);
				$resp = array(
					'isSuccess' => true,
					'redirect' => 'home',
					'username' => $username,
					'password' => $password,
				);
				
				$this->session->set_userdata($user_data);

				echo json_encode($resp);

			} else {
				$resp = array(
					'isSuccess' => false,
					'redirect' => 'login',
					'username' => $username,
					'password' => $password,
				);

				echo json_encode($resp);
			}
		}
	}
}
?>