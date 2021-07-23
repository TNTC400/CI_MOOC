<?php 

class Login_model extends CI_Model {

	public function login_user($username, $password) {
		$this->db->where('username', $username);
		$result = $this->db->get('users');

		if($result->num_rows() <= 0)
		{
			return NULL;
		}
		
		$db_password = $result->row(2)->password;

		if(password_verify($password, $db_password)) {
			return $result->row(0);
		} else {
			return NULL;

		}
	}
}