<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	private $incorrect_account_message = 'Incorrect username or password. Please check again!';
	private $email_not_exists_message = "This email address is not exists. Please check again!";
	private $invalid_token_message = "Invalid token";
	private $passwordconf_not_match_message = "Confirm password is not matched. Please try again!";
	private $host_email = "ngoctrai168@gmail.com";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Token_model');
	}

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
					'message' => $this->incorrect_account_message
				);

				echo json_encode($resp);
			}
		}
	}

	public function forgotPassword(Type $var = null)
	{
		# code...
		$data['content'] = 'forgotpassword';
		$this->load->view('layouts/main', $data);
	}

	public function sendTokenChangePassword()
	{
		# code...
		$email = $this->input->post('email');

		// check if email exists
		$user = $this->User_model->getUserUsingEmail($email);

		if($user == null) {
			$resp = array(
				'isSuccess' => false,
				'message' => $this->email_not_exists_message
			);

			echo json_encode($resp);
		} else {
			$this->sendEmailTokenChangePassword($email);

			$changePasswordDiv = $this->CreateChangePasswordDiv();
			$resp = array(
				'isSuccess' => true,
				'changePasswordDiv' => $changePasswordDiv
			);

			echo json_encode($resp);
		}
	}

	public function sendEmailTokenChangePassword($email)
	{
		# code...
		// Create token
		$token = random_int(100000, 999999);

		$tokenData = array(
			'email' => $email,
			'token' => $token
		);

		$this->Token_model->insert($tokenData);

		$config = Array( 
			'protocol' => 'smtp', 
			'smtp_host' => 'ssl://smtp.googlemail.com', 
			'smtp_port' => 465, 
			'smtp_user' => $this->host_email, 
			'smtp_pass' => 'xxxxxxxx');

		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->load->library('email', $config);
		// Create email content
		$emailContent = $this->CreateChangePassworkTokenEmailContent($token);

		$this->email->from("$this->host_email", 'Weread Admin');
		$this->email->to("$email");

		$this->email->subject("Weread - Change Password Token");
		$this->email->message("$emailContent");

		$this->email->send();
	}

	public function CreateChangePassworkTokenEmailContent($token)
	{
		# code...
		$result = "Your token is: " . $token . '.';
	}

	public function CreateChangePasswordDiv()
	{
		# code...
		$changePasswordDiv = 
		'<p>
			<label for="token" class="sr-only">Token</label><br>
			<input type="text" id="token" class="text-center" required autofocus>
		</p>
		<p>
			<label for="password" class="sr-only">Password</label><br>
			<input type="password" id="password" class="text-center" required>
		</p>
		<!-- Confirm password -->
		<p>
			<label for="passwordconf" class="sr-only">Confirm Password</label><br>
			<input type="password" id="passwordconf" class="text-center" required>
		</p>
		<p>
			<button class="orange-button" id="btnChangePassword" type="submit">Change Password</button>
		</p>';

		return $changePasswordDiv;
	}

	public function changePassword()
	{
		# code...
		$email = $this->input->post('email');
		$token = $this->input->post('token');
		$password = $this->input->post('password');
		$passwordconf = $this->input->post('passwordconf');

		// Check token
		$isTokenValid = $this->Token_model->isTokenValid($email, $token);

		if($isTokenValid == false) {
			$resp = array(
				"isSuccsess" => false,
				"message" => $this->invalid_token_message
			);

			echo json_encode($resp);
		};

		if($password != $passwordconf) {
			$resp = array(
				"isSuccsess" => false,
				"message" => $this->passwordconf_not_match_message
			);

			echo json_encode($resp);
		}

		$this->User_model->updatePassword($email, $password);
		$resp = array(
			"isSuccsess" => true,
			"redirect" => base_url('login')
		);

		echo json_encode($resp);

	}
}
?>