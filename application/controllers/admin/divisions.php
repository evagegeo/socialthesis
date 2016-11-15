<?php

/**
 * Divisions
 *
 * @author Christine Naskopoulou
 */
class Divisions extends MY_Controller {

    function __construct() {

        parent::__construct();

        $this->check_user(1, TRUE);

    }

    /**
     * Loads the admin divisions view from where the admin can create, edit and delete divisions
     *
     * @access public
     */
    function index()
	{
		// Load models
		$this->load->model('M_divisions', 'mdirs');

		if ($this->input->post('adddir_button'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

			if ($this->form_validation->run('admin_dir')) // If passes validation
            {
				if ($this->mdirs->insert($this->input->post('title')))
					redirect('admin/divisions/index/add_ok');
				else
					$this->page_data += array('error' => 'Υπήρξε κάποιο πρόβλημα και δεν μπόρεσε να καταχωρηθεί ο τομέας!');
			}
		}

        $this->page_data += array(
            'section'    => 'admin',
            'page'		 => 'admin_divisions',
            'title'		 => 'Διαχείριση τομέων',
			'divisions' => $this->mdirs->get()
        );

        $this->load->view('admin/divisions', $this->page_data);
    }

	/**
     * Delete a division
     *
     * @access public
     */
	function delete()
	{
		$this->load->model('m_divisions', 'mdirs');

		$this->mdirs->delete($this->uri->segment(4));

		redirect('admin/divisions/index/delete_ok');
	}

	/**
     * Update (ajax)
     *
     * @access public
     */
	function update()
	{
		$this->load->model('m_divisions', 'mdirs');

		$this->mdirs->update($this->input->post('id'), $this->input->post('title'));

		echo $this->input->post('title');
	}
}

/* End of file divisions_labs.php */