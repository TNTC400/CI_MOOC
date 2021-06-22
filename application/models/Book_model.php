<?php 

class Book_model extends CI_Model {

	public function isExist($title, $author) {
        $conditions = array(
            'name' => $title,
            'author' => $author
        );
		$this->db->where($conditions);
		$this->db->from('books');
        $count = $this->db->count_all_results();

		return $count > 0;
	}

    public function add($data)
    {
        $this->db->insert('books', $data);
    }
}