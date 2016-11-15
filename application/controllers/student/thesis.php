<?php



class Thesis extends MY_Controller {

    function __construct() {

        parent::__construct();

        $this->check_user(3, TRUE);
    }

    /**
     * Loads the student thesis view
     */
    function index()
	{
		$thesis = $this->db->select('thesis_id AS id')->where('student_id', $this->session->userdata('id'))->where('selected', '1')->get('requests')->row_array();

		if (!$thesis)
		{
			redirect();
			exit();
		}
		
		// Load models
		$this->load->model('m_thesis', 'mthesis');
		$this->load->model('m_users', 'musers');
		$this->load->model('m_sets', 'msets');

		$thesisdata = $this->mthesis->get($thesis['id']);
		$professor = $this->musers->get($this->msets->get($thesisdata['set_id'], FALSE, 'professor_id'));

		if ($this->input->post('zipfile_button')) // If the user posted a file
		{
			$inc_url = inc_url();

			$config['upload_path'] = './uploads/thesis/';
			$config['encrypt_name'] = TRUE;
			$config['allowed_types'] = 'zip';
			$config['max_size']	= '10000';
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('zipfile'))
			{
				$this->page_data += array(
					'error_zipfile' => $this->upload->display_errors()
				);
			}
			else
			{
				$zipfile_data = $this->upload->data();

				$query = $this->mthesis->update($thesis['id'], array('zipfile' => $zipfile_data['file_name']));

				if ($query)
                {
                    redirect('student/thesis/index/add_zipfile_ok');
                }
                else
                {
                    $this->page_data += array(
                        'error_zipfile' => 'Παρουσιάστηκε κάποιο πρόβλημα και το αρχείο δεν στάλθηκε!'
                    );
                }
			}
		}

		$this->page_data += array(
            'section'   => 'student',
            'page'      => 'student_thesis',
            'title'     => 'Ανάθεση διπλωματικής',
			'professor' => $professor,
			'thesis'    => $thesisdata
        );

        $this->load->view('student/thesis', $this->page_data);

    }

}