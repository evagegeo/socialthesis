<?php

class M_requests extends CI_Model {

    function __construct()
    {
        parent::__construct();
	}

	/*
     * Update a request
     */
    function update($thesis_id, $student_id, $data)
    {
        $this->db->where('thesis_id', $thesis_id)->where('student_id', $student_id);

        return $this->db->update('requests', $data);
    }

    /*
     * Add a new request to the database
     */
    function insert($data)
    {
        return $this->db->insert('requests', $data);
    }

	/*
     * Retrieve a row or a specific field of a request
     */
    function get($id, $field = FALSE)
    {
        if ($field) // Retrieve a specific field
        {
            $this->db->select($field)->from('requests')->where('id', $id);

            $query = $this->db->get();

            $result = $query->row();

            return $result->$field;
        }
        else // retrieve row
        {
			$query = $this->db->get_where('requests', array('id' => $id));

            return $query->row_array();
        }
    }

	/*
     * Retrieve all requests or a set's request
     */
    function getall($set_id = FALSE)
    {
		if ($set_id)
			$query = $this->db->get_where('requests', array('set_id' => $set_id));
		else
			$query = $this->db->get('requests');

        return $query;
    }

	/*
     * Retrieve number of requests of a set
     */
    function getnum($set_id, $student_id = FALSE)
    {
		if ($student_id)
			$this->db->from('requests')->where('set_id', $set_id)->where('student_id', $student_id);
		else
			$this->db->from('requests')->where('set_id', $set_id);

		return $this->db->count_all_results();
    }

	/*
     * Retrieve number of unique requests of a set
     */
    function getnumreq($set_id)
    {
		$query = $this->db->select('DISTINCT(student_id)')->from('requests')->where('set_id', $set_id)->get()->result_array();

		return count($query);

    }

	/*
     * Return all the students that have a request for a specific thesis
     */
    function getstudents($thesis_id)
    {
		$this->db->select('users.id, users.student_aem, users.firstname, users.lastname, users.photo, users.email, users.student_grade, users.student_year, users.student_cleft, users.student_dir_id, users.student_file, users.address, users.phone, requests.order');
		$this->db->from('users');
		$this->db->join('requests', 'users.id = requests.student_id');
		$this->db->where('requests.thesis_id', $thesis_id);
		$this->db->where('requests.selected', '0');
		$this->db->order_by('requests.order', 'ASC');

		return $this->db->get();
    }

	/*
     * Return all the students that have a request for in a specific set
     */
    function getstudentsset($set_id)
    {
		$this->db->select('distinct(set_id), users.id, users.firstname, users.lastname, users.photo');
		$this->db->from('users');
		$this->db->join('requests', 'users.id = requests.student_id');
		$this->db->where('requests.set_id', $set_id);
		$this->db->order_by('requests.id', 'ASC');

		return $this->db->get();
    }

	/*
     * Return all the thesis that a student has requested in a set
     */
    function getallthesis($set_id, $student_id)
    {
		$this->db->select('thesis.zipfile, requests.order, requests.selected, thesis.title, thesis.id');
		$this->db->from('requests');
		$this->db->join('thesis', 'thesis.id = requests.thesis_id');
		$this->db->where('requests.set_id', $set_id);
		$this->db->where('requests.student_id', $student_id);
		$this->db->order_by('requests.order', 'ASC');

		return $this->db->get();
    }

	/*
     * Check if a student has submitted any request in the past
     */
    function check($student_id)
    {
		$this->db->from('requests')->where('student_id', $student_id);

        if ($this->db->count_all_results() > 0)
			return TRUE;
		else
			return FALSE;
    }

}

/* End of file m_requests.php */