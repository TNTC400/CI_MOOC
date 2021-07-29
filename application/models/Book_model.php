<?php 

class Book_model extends CI_Model {

    private $bookTable = 'books';
    private $requestTable = 'requests';
    private $userTable = 'users';

    public function countAllBooks($searchString = '')
    {
        # code...
        if($searchString != '') {
            $searchStringCondition = "$this->bookTable.name like '%".$searchString."%'";
            $this->db->where($searchStringCondition);
        }

        return $this->db->count_all_results('books');
        
    }

    public function getAllBooks()
    {
        return $this->db->get('books')->result();
    }

    public function getBooks($limit, $offset)
    {
        # code...
        $this->db->limit($limit, $offset);
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

    public function search($searchString, $limit, $offset)
    {        
        # code...
        $this->db->select("*");
        $this->db->from("$this->bookTable");
        if($searchString != '') {
            $searchStringCondition = "$this->bookTable.name like '%".$searchString."%'"; 
            $this->db->where($searchStringCondition);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
}