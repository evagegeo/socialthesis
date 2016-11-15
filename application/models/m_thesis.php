<?php

class M_thesis extends CI_Model {

    function __construct()
    {
        parent::__construct();
	}

	/*
     * Update a thesis
     */
    function update($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('thesis', $data);
    }

    /*
     * Add a new thesis to the database
     */
    function insert($data)
    {
        return $this->db->insert('thesis', $data);
    }
    
    /*
     * Delete a thesis or thesis of a set
     */
    function delete( $thesis_id, $set_id = FALSE )
    {
        if ( $set_id )
            return $this->db->delete( 'thesis', array( 'set_id' => $set_id ) );
        else
            return $this->db->delete( 'thesis', array( 'id' => $thesis_id ) );
    }

	/*
     * Retrieve a row or a specific field of a thesis
     */
    function get($id, $field = FALSE)
    {
        if ($field) // Retrieve a specific field
        {
            $this->db->select($field)->from('thesis')->where('id', $id);

            $query = $this->db->get();

            $result = $query->row();

            return $result->$field;
        }
        else // retrieve row
        {
			$query = $this->db->get_where('thesis', array('id' => $id));

            return $query->row_array();
        }
    }

	/*
     * Retrieve all thesis or a set's thesis
     */
    function getall($set_id = FALSE)
    {
		if ($set_id)
			$query = $this->db->order_by("id", "ASC")->get_where('thesis', array('set_id' => $set_id));
		else
			$query = $this->db->order_by("id", "ASC")->get('thesis');

        return $query;
    }

	/*
     * Retrieve number of thesis of a set
     */
    function getnum($set_id)
    {
		$this->db->from('thesis')->where('set_id', $set_id);

		return $this->db->count_all_results();
    }
    
    /*
     * Retrieve all thesis or a set's thesis
     */
    function get_dir($thesis_id)
    {
        $this->db->select('thesis.id, thesis.title, thesis.abstract, DATE_FORMAT(date_published, \'%d-%m-%Y %H:%i\') AS published, thesis.student_id, thesis.set_id, thesis.link, thesis.final_file AS file, users.username AS author, users.firstname, users.lastname, users.photo AS uphoto', FALSE);
        $this->db->from('thesis');
        $this->db->join('users', 'users.id = thesis.student_id');
        $this->db->where('thesis.directory', '1');
        $this->db->where('thesis.id', $thesis_id);

        return $this->db->get()->row_array();
    }
    
    /*
     * Retrieve all thesis or a set's thesis
     */
    function get_dir_all($num = FALSE, $offset = FALSE, $fav_id = FALSE, $popular = FALSE)
    {
        if ($popular)
        {
            return $this->db->query('select t.id, t.title, t.abstract, DATE_FORMAT(date_published, \'%d-%m-%Y %H:%i\') AS published,
                                              t.student_id, t.set_id, u.username AS author, u.photo AS uphoto
                                       from '.$this->db->dbprefix('thesis').' as t 
                                               inner join '.$this->db->dbprefix('users').' as u on u.id = t.student_id
                                               inner join (select content_id, count(1) as fcount
                                                              from '.$this->db->dbprefix('favorites').'
                                                           where category = 1 
                                                           group by content_id) as f on f.content_id = t.id
                                      order by f.fcount desc, t.date_published desc
                                      limit 8');
        }
        else
        {
            $this->db->select('thesis.id, thesis.title, thesis.abstract, DATE_FORMAT(date_published, \'%d-%m-%Y %H:%i\') AS published, thesis.student_id, thesis.set_id, users.username AS author, users.photo AS uphoto', FALSE);
            $this->db->from('thesis');
            $this->db->join('users', 'users.id = thesis.student_id');

            if ($fav_id) {
                $this->db->distinct();
                $this->db->join('favorites', 'thesis.id = favorites.content_id');
                $this->db->where('favorites.category', '1');
                $this->db->where('favorites.user_id', $fav_id);
            }

            $this->db->where('thesis.directory', '1');

            $this->db->order_by('thesis.date_published', 'desc');

            if ($num && $offset)
                $this->db->limit($num, $offset);

            return $this->db->get();
        }
    }

}

/* End of file m_thesis.php */