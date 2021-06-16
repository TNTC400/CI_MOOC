<?php 

class SignUp_model extends CI_Model {

	public function signUp($username, $email, $password, $role = 'User') {

		$encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
        $data = array(
            'name' => $username,
            'email' => $email,
            'password' => $encryptedPassword,
            'role' => $role,
        );

        $this->db->insert('users', $data);

        return true;
		// $this->db->where('Name', $username);
		// $result = $this->db->get('users');

		// if($result->num_rows() <= 0)
		// {
		// 	return NULL;
		// }
		
		// $db_password = $result->row(2)->password;
		// if(password_verify($password, $db_password)) {
		// 	return $result->row(0)->id;
		// } else {
		// 	return NULL;

		// }
	}
}