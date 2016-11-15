<?php

class M_sets extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Update a set
     */
    function update($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('sets', $data);
    }

    /*
     * Add a new set to the database
     */
    function insert($data)
    {
        return $this->db->insert('sets', $data);
    }
    
    /*
     * Delete a set
     */
    function delete( $set_id )
    {
        return $this->db->delete( 'sets', array( 'id' => $set_id ) );
    }

	/*
     * Retrieve a row or a specific field of a set
     */
    function get($id, $formatdate = FALSE, $field = FALSE)
    {
        if ($field) // Retrieve a specific field
        {
            $this->db->select($field)->from('sets')->where('id', $id);

            $query = $this->db->get();

            $result = $query->row();

            return $result->$field;
        }
        else // retrieve row
        {
			if ($formatdate)
				$this->db->select('id, year, DATE_FORMAT(start, \'%d/%m/%Y\') AS start, DATE_FORMAT(end, \'%d/%m/%Y\') AS end, professor_id, published', FALSE);

			$query = $this->db->get_where('sets', array('id' => $id));

            return $query->row_array();
        }
    }

	/*
     * Retrieve all sets or a professor's sets
     */
    function getall($formatdate = FALSE, $professor_id = FALSE)
    {
		if ($formatdate)
				$this->db->select('id, year, DATE_FORMAT(start, \'%d/%m/%Y\') AS start, DATE_FORMAT(end, \'%d/%m/%Y\') AS end, professor_id, published', FALSE)->order_by('start', 'asc');
		
		if ($professor_id)
			$query = $this->db->get_where('sets', array('professor_id' => $professor_id));
		else
			$query = $this->db->get('sets');

        return $query;
    }

	/*
     * Retrieve set with professor info
     */
    function getsetinfo($set_id)
    {
		$this->db->select('sets.id AS sid, year, DATE_FORMAT(start, \'%d/%m/%Y\') AS start, DATE_FORMAT(end, \'%d/%m/%Y\') AS end, users.id, firstname, lastname, professor_attr', FALSE);
		$this->db->from('users');
		$this->db->join('sets', 'sets.professor_id = users.id');
		$this->db->where('sets.id', $set_id);

		$query = $this->db->get();

		return $query->row_array();
    }
    
    /*
     * Check if a set or a set of a thesis is published
     */
    function set_published( $thesis_id = FALSE, $set_id = FALSE )
    {
        if ( $thesis_id )
            $this->db->select('published')->from('sets')->join('thesis', 'thesis.set_id = sets.id')->where('thesis.id', $thesis_id);
        else
            $this->db->select('published')->from('sets')->where('sets.id', $set_id);
        
        return $this->db->get()->row()->published ? TRUE : FALSE;
    }
}

/* End of file m_sets.php */