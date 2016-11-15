<?php

/**
 * Thesis
 *
 * @author Jason Koukliatis
 */
class Thesis extends MY_Controller {

    function __construct() {

        parent::__construct();

    }

	/**
     * Loads the thesis view
     *
     * @access public
     */
    function index()
	{
		$this->load->model('M_thesis', 'mthesis');
		$this->load->model('M_requests', 'mreq');

		$this->db->select('divisions.id AS did, divisions.title, users.id, sets.id AS sid, firstname, lastname, photo, professor_attr, year, DATE_FORMAT(start, \'%d/%m/%Y\') AS start, DATE_FORMAT(end, \'%d/%m/%Y\') AS end', FALSE);
		$this->db->from('users');
		$this->db->join('sets', 'sets.professor_id = users.id');
		$this->db->join('divisions', 'users.professor_dir_id = divisions.id', 'left outer');
		$this->db->where('sets.start <=', date("Y-m-d"));
		$this->db->where('sets.end >=', date("Y-m-d"));

		$query = $this->db->get();

        $this->page_data += array(
            'section'    => 'general',
            'page'		 => 'thesis',
            'title'		 => 'Διπλωματικές',
			'professors' => $query
        );

        $this->load->view('thesis', $this->page_data);
    }

	/**
     * View the thesis of a set in new thesis page
     *
     * @access public
     */
    function viewthesis()
	{
		$this->load->model('M_thesis', 'mthesis');
		$this->load->model('M_requests', 'mreq');

		$set_id = $this->uri->segment(4);

		$this->db->select('sets.id AS sid, users.id, firstname, lastname, photo, professor_attr', FALSE);
		$this->db->from('users');
		$this->db->join('sets', 'sets.professor_id = users.id');
		$this->db->where('sets.id', $set_id);

		$query = $this->db->get();

		$prof = $query->row_array();

		$allthesis = $this->mthesis->getall($set_id);

        $this->page_data += array(
            'section'   => 'general',
            'page'		=> 'thesis',
            'title'		=> 'Διπλωματικές | Προβολή διπλωματικών',
			'professor' => $prof,
			'allthesis'	=> $allthesis
        );

        $this->load->view('thesis_view', $this->page_data);
    }

}

/* End of file thesis.php */