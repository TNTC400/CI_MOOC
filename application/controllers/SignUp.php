<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignUp extends CI_Controller {

	public function index()
	{
        $data['content'] = 'signup';
		$this->load->view('layouts/main', $data);
	}

	public function doSignUp()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('email',    'Email',    'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
		if($this->form_validation->run() == FALSE) {
			
			$data = array(
				'errors' => validation_errors()
				);
			return NULL;

		} else {
			$username = $this->input->post('username');
            $email    = $this->input->post('email');
			$password = $this->input->post('password');
			$signUpSuccess = $this->SignUp_model->signUp($username, $email, $password);

			if($signUpSuccess) {

				$user_data = array(
					'user_id' => $user_id,
					'username' => $username,
                    'email' => $email,
					);

				echo json_encode($user_data);

			} else {
				return NULL;
			}
		}
	}
}
?>