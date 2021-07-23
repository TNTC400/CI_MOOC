<?php 

class SignUp_model extends CI_Model {

	public function signUp($username, $email, $password, $role = 'User') {

		$encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $encryptedPassword,
            'role' => $role,
        );
        $this->db->insert('users', $data);
        return true;
	}
}