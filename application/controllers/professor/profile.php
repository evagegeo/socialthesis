<?php

/**
 * Profile
 *
 * 
 */
class Profile extends MY_Controller {

    function __construct() {

        parent::__construct();

    }

    /**
     * Loads the professor profile page
     *
     * @access public
     */
    function index() {

		$this->load->model('m_users', 'musers');
		$this->load->model('m_divisions', 'mdirs');
		
		$id = $this->uri->segment(4);

		if ((is_numeric($id)) && ($this->musers->get($id, 'access') == 2)) // If a professor id is declared
		{
			$userdata = $this->musers->get($id);

			$userdata['email'] = str_replace('@', ' <strong>(at)</strong> ', $userdata['email']);
			$userdata['email'] = str_replace('.', ' <strong>(dot)</strong> ', $userdata['email']);

			$this->page_data += array(
                'section'  => 'general',
				'page'     => 'professor_profile',
				'title'	   => 'Προφίλ καθηγητή',
				'userdata' => $userdata
			);

			$this->load->view('professor/profile', $this->page_data);
		}
		else
		{
			redirect();
		}

    }

}

/* End of file profile.php */