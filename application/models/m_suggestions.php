<?php

class M_suggestions extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Update the data of a suggestion
     */
    function update($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('suggestions', $data);
    }

    /*
     * Add a suggestion to the database
     */
    function insert($data)
    {
        return $this->db->insert('suggestions', $data);
    }

    /*
     * Retrieve a row or a specific value of a suggestion
     */
    function get($id, $field = FALSE)
    {
        if ($field) // Retrieve a specific field
        {
            $this->db->select($field)->from('suggestions')->where('id', $id);

            $query = $this->db->get();

            $result = $query->row();

            return $result->$field;
        }
        else // retrieve all
        {
            $this->db->select('suggestions.id, suggestions.title, suggestions.content, DATE_FORMAT(published, \'%d-%m-%Y %H:%i\') AS published, suggestions.view, suggestions.author_id, users.username AS author, users.access AS uaccess, users.photo AS uphoto, users.firstname, users.lastname', FALSE);
            $this->db->from('suggestions');
            $this->db->join('users', 'users.id = suggestions.author_id');
            $this->db->where('suggestions.id', $id);

            $query = $this->db->get();

            return $query->row_array();
        }
    }

    /*
     * Retrieve all suggestions
     */
    function getall($num = FALSE, $offset = FALSE, $view = FALSE, $where = FALSE, $fav_id = FALSE, $popular = FALSE)
    {
        if ($popular)
        {
            return $this->db->query('select s.id, s.title, s.content, DATE_FORMAT(published, \'%d-%m-%Y %H:%i\') AS published,
                                              s.view,  s.author_id, u.username as author, u.access as uaccess, u.photo as uphoto
                                       from '.$this->db->dbprefix('suggestions').' as s 
                                               inner join '.$this->db->dbprefix('users').' as u on u.id = s.author_id
                                               inner join (select content_id, count(1) as fcount
                                                              from '.$this->db->dbprefix('favorites').'
                                                           where category = 2 
                                                           group by content_id) as f on f.content_id = s.id
                                      order by f.fcount desc, s.published desc
                                      limit 8');
        }
        else
        {
            $this->db->select('suggestions.id, suggestions.title, suggestions.content, DATE_FORMAT(published, \'%d-%m-%Y %H:%i\') AS published, suggestions.view, suggestions.author_id, users.username AS author, users.access AS uaccess, users.photo AS uphoto', FALSE);
            $this->db->from('suggestions');
            $this->db->join('users', 'users.id = suggestions.author_id', 'inner');

            if ($fav_id) {
                $this->db->distinct();
                $this->db->join('favorites', 'suggestions.id = favorites.content_id');
                $this->db->where('favorites.category', '2');
                $this->db->where('favorites.user_id', $fav_id);
            }

            if ($where)
                $this->db->where($where);

            if ($view)
                $this->db->where('suggestions.view', '1');

            $this->db->order_by('suggestions.published', 'desc');

            if ($num && $offset)
                $this->db->limit($num, $offset);

            return $this->db->get();
        }
    }

}

/* End of file m_suggestions.php */