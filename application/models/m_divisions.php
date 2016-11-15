<?php

class M_divisions extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	/*
     * Add a new division to the database
     */
    function insert($title)
    {
        return $this->db->insert('divisions', array('title' => $title));
    }

    /*
     * Update division's data
     */
    function update($id, $title)
    {
        return $this->db->where('id', $id)->update('divisions', array('title' => $title));
    }

	/*
     * Delete a division from the database
     */
    function delete($id)
    {
        if ($this->db->delete('divisions', array('id' => $id)))
		{
			if ($this->db->where('professor_dir_id', $id)->or_where('student_dir_id', $id)->update('users', array('professor_dir_id' => '0', 'student_dir_id' => '0')))
				return TRUE;
			else
				return FALSE;
		}

		return FALSE;
    }

    /*
     * Retrieve a division or all divisions
     */
    function get($id = FALSE, $field = FALSE)
    {
		if ($id !== FALSE && $field)
		{
			$query = $this->db->get_where('divisions', array('id' => $id))->row_array();

			if (isset($query[$field]))
				return $query[$field];
			else
				return 'Καμία';
		}
		else if ($id)
			return $this->db->get_where('divisions', array('id' => $id))->row_array();
		else
			return $this->db->order_by('id', 'ASC')->get('divisions')->result_array();
    }

}

/* End of file m_divisions.php */