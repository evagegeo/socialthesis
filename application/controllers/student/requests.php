<?php


class Requests extends MY_Controller {

    function __construct() {

        parent::__construct();

        $this->check_user(3, TRUE);

    }

    /**
     * Loads the student's requests view
     */
    function index()
	{
		// Load models
		$this->load->model('m_sets', 'msets');
		$this->load->model('m_requests', 'mreq');

		$sets = $this->db->query("SELECT distinct(set_id) AS id FROM ".$this->db->dbprefix('requests')." WHERE student_id = '".$this->session->userdata('id')."'")->result_array();

		$this->page_data += array(
            'section'   => 'general',
            'page'      => 'student_requests',
            'title'     => 'Αιτήσεις',
			'sets'      => $sets
        );

        $this->load->view('student/requests', $this->page_data);
	}

	/**
     * Loads the student's request view (for a new request)
     * public
     */
    function add()
	{
		if ($this->db->where('student_id', $this->session->userdata('id'))->where('selected', '1')->get('requests')->result_array())
		{
			redirect();
			exit();
		}

		// Load models
		$this->load->model('M_requests', 'mreq');
		$this->load->model('M_sets', 'msets');

		$set_id = $this->uri->segment(4);

		// Check if the student can submit a request in this set (if the set is active)
		$this->db->from('sets')->where('id', $set_id)->where('sets.start <=', date("Y-m-d"))->where('sets.end >=', date("Y-m-d"));

		if ($this->db->count_all_results() == 0)
		{
			redirect();
			exit();
		}
		
		// If the student submit a request in this set already
		if ($this->mreq->getnum($set_id, $this->session->userdata('id')) > 0)
		{
			redirect();
			exit();
		}

		// Retrieve set info
		$set = $this->msets->getsetinfo($set_id);

		// Check if user has submitted all personal info before submit a request
		$this->load->model('M_users', 'musers');

		$student = $this->musers->get($this->session->userdata('id'));

		if (!$student['address'] || !$student['student_aem'] || !$student['phone'] || !$student['student_grade'] || !$student['student_year'] || !$student['student_file'] || !$student['student_cleft'])
		{
			$this->page_data += array(
				'error' => 'Πρέπει να συμπληρωθούν όλα τα προσωπικά στοιχεία καθώς και να προστεθεί ένα αρχείο με τα απαραίτητα (βιογραφικό κτλ) πριν μπορέσετε να κάνετε αίτηση!'
			);
		}
		else
		{
			$this->load->model('M_thesis', 'mthesis');

			$allthesis = $this->mthesis->getall($set_id);

			$this->page_data += array(
				'allthesis' => $allthesis
			);
		}

		$this->page_data += array(
            'section' => 'general',
            'page'    => 'student_requests',
            'title'   => 'Νέα αίτηση',
			'set'     => $set
        );

        $this->load->view('student/request', $this->page_data);
	}

	/**
     * Loads the student's request view (for a new request)
     *
     * @access public
     */
	function addrequest()
	{
		$this->load->model('M_requests', 'mreq');

		$set_id = $this->input->post('set_id');
		$student_id = $this->session->userdata('id');
		$request = $this->input->post('request');

		if ($this->mreq->getnum($set_id, $this->session->userdata('id')) > 0) // If the student submit a request in this set already
		{
			redirect();
			exit();
		}
		
		// Check if the student can submit a request in this set (if the set is active)
		$this->db->from('sets')->where('id', $set_id)->where('sets.start <=', date("Y-m-d"))->where('sets.end >=', date("Y-m-d"));

		if ($this->db->count_all_results() == 0)
		{
			redirect();
			exit();
		}

		// Check if all the posted thesis_id belong to this set_id provided
		$this->load->model('M_thesis', 'mthesis');
		$j = 0;
		$ct = 0;

		foreach($request as $thesis)
		{
			if ($this->mthesis->get($thesis, 'set_id') == $set_id)
				$ct++;

			$j++;
		}

		if ($ct != $j)
			exit();

		// Submit the request to the database
		$i = 1;
		$counter = 0;

		foreach($request as $req)
		{
			$post_data = array(
				'order'		 => $i,
				'thesis_id'  => $req,
				'set_id'	 => $set_id,
				'student_id' => $student_id,
				'submitted'  => date('Y-m-d H:i:s')
			);

			if ($this->mreq->insert($post_data))
				$counter++;

			$i++;
		}

		if (($i - 1) == $counter) { ?>
			<div class="msg-ok">Η αίτηση καταχωρήθηκε με επιτυχία!</div>
		<?php } else { ?>
			<div class="msg-error">Υπήρξε κάποιο πρόβλημα και η αίτηση δεν καταχωρήθηκε. Παρακαλώ επικοινωνήστε με τους διαχειριστές!</div>
		<?php }
	}
}