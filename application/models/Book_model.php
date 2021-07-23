<?php 

class Book_model extends CI_Model {

    public function getAllBooks()
    {
        return $this->db->get('books')->result();
    }

    public function getBook($id)
    {
        $conditions = array(
            'id' => $id,
        );
		$this->db->where($conditions);

        return $this->db->get('books')->first_row();
    }

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

    public function update($data, $conditions)
    {
        $this->db->where($conditions);
        $this->db->update('books', $data);
    }

    public function delete($conditions)
    {
        $this->db->where($conditions);
        $this->db->delete('books');
    }
}