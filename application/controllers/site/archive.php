<?php

/**
 * Archive
 *
 * @author Jason Koukliatis
 */
class Archive extends MY_Controller {

    function __construct() {

        parent::__construct();

    }

    /**
     * Loads the archive view
     *
     * @access public
     */
    function index()
	{
		$this->load->model('M_thesis', 'mthesis');

		$this->db->select('divisions.id AS did, divisions.title, users.id, sets.id AS sid, firstname, lastname, photo, professor_attr, year, DATE_FORMAT(start, \'%d/%m/%Y\') AS start, DATE_FORMAT(end, \'%d/%m/%Y\') AS end', FALSE);
		$this->db->from('users');
		$this->db->join('sets', 'sets.professor_id = users.id');
		$this->db->join('divisions', 'users.professor_dir_id = divisions.id', 'left outer');
		$this->db->where('sets.end <', date("Y-m-d"));

		$query = $this->db->get();

        $this->page_data += array(
            'section'    => 'general',
            'page'       => 'archive',
            'title'      => 'Αρχείο Διπλωματικών',
			'professors' => $query
        );

        $this->load->view('archive', $this->page_data);
    }

	/**
     * View the thesis of a set in archive
     *
     * @access public
     */
    function viewthesis()
	{
		$this->load->model('M_thesis', 'mthesis');

		$set_id = $this->uri->segment(4);

		$this->db->select('users.id, firstname, lastname, photo, professor_attr', FALSE);
		$this->db->from('users');
		$this->db->join('sets', 'sets.professor_id = users.id');
		$this->db->where('sets.id', $set_id);

		$query = $this->db->get();

		$prof = $query->row_array();

		$allthesis = $this->mthesis->getall($set_id);
	
        $this->page_data += array(
            'section'   => 'general',
            'page'		=> 'archive',
            'title'		=> 'Αρχείο Διπλωματικών | Προβολή διπλωματικών',
			'professor' => $prof,
			'allthesis'	=> $allthesis
        );

        $this->load->view('archive_view', $this->page_data);
    }
}

/* End of file archive.php */