<?php

class M_comments extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Update the data of a comment
     */
    function update($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('comments', $data);
    }

    /*
     * Add a comment to the database
     */
    function insert($data)
    {
        return $this->db->insert('comments', $data);
    }

    /*
     * Retrieve a row or a specific value of a comments
     */
    function get($id, $field = FALSE)
    {
        if ($field) // Retrieve a specific field
        {
            $this->db->select($field)->from('comments')->where('id', $id);

            $query = $this->db->get();

            $result = $query->row();

            return $result->$field;
        }
        else // retrieve all
        {
            $this->db->select('comments.id, comments.content, DATE_FORMAT(published, \'%d-%m-%Y %H:%i\') AS published, comments.view, comments.author_id, users.username AS author, users.access AS uaccess, users.photo AS uphoto', FALSE);
            $this->db->from('comments');
            $this->db->join('comments', 'users.id = comments.author_id');
            $this->db->where('comments.id', $id);

            $query = $this->db->get();

            return $query->row_array();
        }
    }

    /*
     * Retrieve all comments
     */
    function get_all($content_id = FALSE, $category = FALSE, $view = FALSE)
    {
        $this->db->select('comments.id, comments.content, DATE_FORMAT(published, \'%d-%m-%Y %H:%i\') AS published, comments.view, comments.author_id, users.username AS author, users.access AS uaccess, users.photo AS uphoto', FALSE);
        $this->db->from('comments');
        $this->db->join('users', 'users.id = comments.author_id');

        if ($category)
            $this->db->where('comments.category', $category);
        if ($content_id)
            $this->db->where('comments.content_id', $content_id);
        if ($view)
            $this->db->where('comments.view', '1');

        $this->db->order_by('comments.published', 'asc');

        $query = $this->db->get();

        return $query;
    }

}

/* End of file m_comments.php */