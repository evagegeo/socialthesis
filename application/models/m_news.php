<?php

class M_news extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Update the data of a new
     */
    function update($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('news', $data);
    }

    /*
     * Add a new to the database
     */
    function insert($data)
    {
        return $this->db->insert('news', $data);
    }

    /*
     * Retrieve a row or a specific value of a new
     */
    function get($id, $field = FALSE)
    {
        if ($field) // Retrieve a specific field
        {
            $this->db->select($field)->from('news')->where('id', $id);

            $query = $this->db->get();

            $result = $query->row();

            return $result->$field;
        }
        else // retrieve all
        {
            $this->db->select('news.id, news.title, news.content, DATE_FORMAT(published, \'%d-%m-%Y %H:%i\') AS published, news.view, news.author_id, users.username AS author', FALSE);
            $this->db->from('news');
            $this->db->join('users', 'users.id = news.author_id');
            $this->db->where('news.id', $id);

            $query = $this->db->get();

            return $query->row_array();
        }
    }

    /*
     * Retrieve all news
     */
    function getall($num, $offset, $view = FALSE)
    {
        $this->db->select('news.id, news.title, news.content, DATE_FORMAT(published, \'%d-%m-%Y %H:%i\') AS published, news.view, users.username AS author', FALSE);
        $this->db->from('news');
        $this->db->join('users', 'users.id = news.author_id');

        if ($view) {
            $this->db->where('news.view', '1');
        }

        $this->db->order_by('news.published', 'desc');
        $this->db->limit($num, $offset);

        $query = $this->db->get();

        return $query;
    }

}

/* End of file m_news.php */