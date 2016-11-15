<?php

/**
 * Thesis
 *
 * 
 */
class Thesis extends MY_Controller {

    function __construct() {

        parent::__construct();

		$this->check_user(2, TRUE);

    }

	/**
     * Loads the professor sets view
     *
     * @access public
     */
	function index()
	{
		// Load models & libraries
        $this->load->model('m_sets', 'msets');
		$this->load->model('m_thesis', 'mthesis');
		$this->load->model('m_requests', 'mreq');
        
        $mode = $this->uri->segment(4);
        $available_modes = array ( 'edit', 'delete', 'publish' );
        $set_id = $this->uri->segment(5);
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');
        
        // Retrieve professor sets
		$sets = $this->msets->getall(TRUE, $this->session->userdata('id'));

		// If a new set has been submitted
		if ($this->input->post('addset_button')) 
		{
			$post_data = array(
                'start'		   => $this->input->post('start'),
                'end'		   => $this->input->post('end'),
				'professor_id' => $this->session->userdata('id')
            );

			$year = $this->_check_date($post_data['start'], TRUE);

			if ($year && $this->_check_date($post_data['end'])) // Check for valid dates
			{
				$post_data += array(
					'year' => $year
				);
                
                $start_date = strtotime($post_data['start']);
                $end_date = strtotime($post_data['end']);
                
                if ( $end_date > $start_date )
                {
                    if ($this->form_validation->run('professor_set')) // If passes validation
                    {
                        // Add the new set
                        $query = $this->msets->insert($post_data);

                        if ($query)
                        {
                            redirect('professor/thesis/index/addset_ok#addset');
                        }
                        else
                        {
                            $this->page_data += array(
                                'error_addset' => 'Παρουσιάστηκε κάποιο πρόβλημα και δεν προστέθηκε το σετ!'
                            );
                        }
                    }
                }
                else
                    $this->page_data += array( 'error_addset' => 'Οι ημερομηνίες δεν είναι έγκυρες!' );

			}
			else
			{
				$this->page_data += array(
					'error_addset' => 'Οι ημερομηνίες που συμπληρώθηκαν δεν είναι έγκυρες. Πρέπει έχουν τη μορφή έτος-μήνας-ημέρα (πχ 2010-05-18)'
				);
			}
		}

		// If user selected to edit, delete or publish a set
		if ( in_array($mode, $available_modes) )
		{
            if ( ! $this->_check_set($set_id, $this->session->userdata('id')) ) die();
            
			if ( $mode == 'edit' )
			{
                if ( $this->input->post('editset_button') )
                {
                    $post_data = array(
                        'start'		   => $this->input->post('start'),
                        'end'		   => $this->input->post('end')
                    );

                    $year = $this->_check_date($post_data['start'], TRUE);

                    if ($year && $this->_check_date($post_data['end'])) // Check for valid dates
                    {
                        $post_data += array(
                            'year' => $year
                        );
                        
                        $start_date = strtotime($post_data['start']);
                        $end_date = strtotime($post_data['end']);

                        if ( $end_date > $start_date )
                        {
                            if ($this->form_validation->run('professor_set')) // If passes validation
                            {
                                // Edit the set
                                $query = $this->msets->update($set_id, $post_data);

                                if ($query)
                                    redirect("professor/thesis/index/editset_ok");
                                else
                                    $this->page_data += array( 'error_editset' => 'Παρουσιάστηκε κάποιο πρόβλημα και δεν έγινε σωστά η ενημέρωση!' );
                            }
                        }
                        else
                            $this->page_data += array( 'error_editset' => 'Οι ημερομηνίες δεν είναι έγκυρες!' );
                    }
                    else
                    {
                        $this->page_data += array(
                            'error_editset' => 'Οι ημερομηνίες που συμπληρώθηκαν δεν είναι έγκυρες. Πρέπει έχουν τη μορφή έτος-μήνας-ημέρα (πχ 2010-05-18)'
                        );
                    }
                }
                
                $editset = $this->msets->get($set_id);

                $this->page_data += array(
                    'editset' => $editset
                );
			}
            else if ( $mode == 'delete' )
            {
                if ( ! $this->msets->set_published( FALSE, $set_id ) ) {
                    
                    if ( $this->mthesis->delete( FALSE, $set_id ) && $this->msets->delete( $set_id ) )
                        redirect("professor/thesis/index/deleteset_ok");
                    else
                        $this->page_data += array( 'error_deleteset' => 'Παρουσιάστηκε κάποιο πρόβλημα και το σετ δε διαγράφηκε!' );
                }
            }
            else if ( $mode == 'publish' )
            {
                if ( ! $this->msets->set_published( FALSE, $set_id ) ) {
                    
                    if ( $this->msets->update( $set_id, array( 'published' => 1 )) )
                        redirect("professor/thesis/index/pubset_ok");
                    else
                        $this->page_data += array( 'error_pubset' => 'Παρουσιάστηκε κάποιο πρόβλημα και το σετ δε δημοσιεύτηκε!' );
                }
            }
		}

		$this->page_data += array(
            'section'  => 'professor',
			'page'     => 'professor_thesis',
			'title'	   => 'Σετ διπλωματικών',
			'sets'	   => $sets
		);

		$this->load->view('professor/sets', $this->page_data);
	}

	/**
     * Loads the professor thesis edit view
     *
     * @access public
     */
	function edit()
	{
		$set_id = $this->uri->segment(4);

		if ($this->_check_set($set_id, $this->session->userdata('id')))
		{
			// Load models & libraries
			$this->load->model('m_sets', 'msets');
			$this->load->model('m_thesis', 'mthesis');
			$this->load->model('m_requests', 'mreq');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

			if ($this->input->post('addthesis_button')) // If the form to add a thesis has been submitted
			{
				$post_data = array(
					'title'	  => $this->input->post('thesis_title'),
					'content' => $this->input->post('thesis_content'),
					'set_id'  => $set_id
				);

				if ($this->form_validation->run('professor_add_thesis')) // If passes validation
				{
					// Add the new thesis
					$query = $this->mthesis->insert($post_data);

					if ($query)
					{
						redirect("professor/thesis/edit/$set_id/addthesis_ok#allthesis");
					}
					else
					{
						$this->page_data += array(
							'error_addthesis' => 'Παρουσιάστηκε κάποιο πρόβλημα και δεν προστέθηκε η διπλωματική!'
						);
					}
				}
			}

			$set = $this->msets->get($set_id, TRUE);

			$this->page_data += array(
                    'section'   => 'professor',
					'page'		=> 'professor_thesis',
					'title'		=> 'Επεξεργασία διπλωματικών',
					'set'		=> $set,
					'allthesis' => $this->mthesis->getall($set_id)
				);

			$this->load->view('professor/edit', $this->page_data);
		}
		else
		{
			redirect();
			exit();
		}	
	}

	/**
     * Loads the professor requests view
     *
     * @access public
     */
	function requests()
	{
		$set_id = $this->uri->segment(4);
		$student_id = $this->uri->segment(5);

		if ($this->_check_set($set_id, $this->session->userdata('id')))
		{
			$this->load->model('m_users', 'musers');
			$this->load->model('m_requests', 'mreq');
			$this->load->model('m_divisions', 'mdirs');
			$this->load->model('m_sets', 'msets');

			if ($student_id)
			{
				$query = $this->db->select('id')->from('requests')->where('set_id', $set_id)->where('student_id', $student_id)->get()->result_array();

				if ($query)
					$student = $this->musers->get($student_id);
				else
					$student = FALSE;

				$this->page_data += array(
					'student'   => $student,
					'allthesis' => $this->mreq->getallthesis($set_id, $student_id)
				);
			}
			else
			{
				if ($this->input->post('btn'))
				{
					$student_id = $this->input->post('id');
					$thesis_id = $this->input->post('thesis_id');

					if (!$this->db->where('student_id', $student_id)->where('selected', '1')->get('requests')->result_array())
						if ($this->db->where('id', $thesis_id)->where('set_id', $set_id)->get('thesis')->result_array())
							$this->mreq->update($thesis_id, $student_id, array('selected' => '1'));

					redirect('professor/thesis/requests/'.$set_id);
				}

				$this->load->model('m_thesis', 'mthesis');

				$this->page_data += array(
					'requests'  => $this->mreq->getnumreq($set_id),
					'allthesis' => $this->mthesis->getall($set_id)
				);
			}
            
            $set = $this->msets->get($set_id, TRUE);

			$this->page_data += array(
                    'section' => 'professor',
					'page'    => 'professor_thesis',
					'title'	  => 'Αιτήσεις',
                    'set'     => $set,
					'set_id'  => $set_id
				);

			$this->load->view('professor/requests', $this->page_data);
		}
		else
		{
			redirect();
			exit();
		}	
	}
    
    /**
     * Ajax handling (edit, submit, cancel, delete thesis)
     * 
     * @access public
     */
    function ajax()
    {
        $mode = $this->input->post('mode');
        
        // Load model
        $this->load->model('m_thesis', 'mthesis');
        
        $thesis_id = $this->input->post('thesis_id');
        $professor_id = $this->session->userdata('id');
        
        if ( $mode == 'cancel' ) // Cancel edit
        {
            $thesis = $this->mthesis->get($thesis_id);

            // Print thesis
            $this->_print_thesis( array( 'id' => $thesis['id'], 'title' => $thesis['title'], 'content' => $thesis['content'] ) );
        }
        else if ( $mode == 'edit' ) // Edit a thesis
        {
            $thesis = $this->mthesis->get($thesis_id);

            if ($this->_check_set($thesis['set_id'], $professor_id)) // Security check & print edit form
                $this->_print_thesis( array( 'id' => $thesis['id'], 'title' => $thesis['title'], 'content' => $thesis['content'] ), 'edit' );
        }
        else if ( $mode == 'submit' ) // Submit edited thesis
        {
            $post_data = array(
                'title'	  => $this->input->post('title'),
                'content' => $this->input->post('content')
            );

            if ($this->_check_set($this->mthesis->get($thesis_id, 'set_id'), $professor_id)) // Security check
            {
                $query = $this->mthesis->update($thesis_id, $post_data);

                if ($query)
                {
                    $thesis = $this->mthesis->get($thesis_id);
                    
                    $this->_print_thesis( array( 'id' => $thesis['id'], 'title' => $thesis['title'], 'content' => $thesis['content'] ) );
                }
            }
        }
        else if ( $mode == 'delete' ) // Delete a thesis
        {            
            if ( ($this->_check_set($this->mthesis->get($thesis_id, 'set_id'), $professor_id)) &&
                    ( ! $this->msets->set_published( $thesis_id ) ) )// Security check
                $this->mthesis->delete( $thesis_id );
        }
    }
	
	/**
     * Check if the date format is valid
     *
     * @access private
     */
	function _check_date( $date, $returnyear = FALSE )
	{
		// DATE FORMAT VALIDATION (2010-03-27)
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);

		$dash1 = substr($date, 4, 1);
        $dash2 = substr($date, 7, 1);

		if (is_numeric($year) && is_numeric($month) && is_numeric($day) &&
			$month < 13 && $day < 32 &&
			$dash1 == '-' && $dash2 == '-')
		{
			if ($returnyear)
			{
				if ($month > 0 && $month < 9)
					return $year - 1;
				else
					return $year;
			}
			else
				return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
     * Checks if a set belongs to a professor
     *
     * @access private
     */
	function _check_set( $set_id, $professor_id )
	{
		// Load model
        $this->load->model('m_sets', 'msets');

		// Check if the set belongs to this professor
		$pro_id = $this->msets->get($set_id, FALSE, 'professor_id');

		if ($pro_id == $professor_id)
			return TRUE;
		else
			return FALSE;
	}
    
    /**
     * Print the thesis edit form or default view
     *
     * @access private
     */
	function _print_thesis( $data, $mode = 'default' )
	{
        $this->load->model( 'm_sets', 'msets');
        
		if ( $mode == 'default' )
        {
            ?>
            <div id="options_<?php echo $data['id']; ?>" class="dis-none fright">
                <a href="#" onclick="return edit_thesis(<?php echo $data['id']; ?>)" class="edit-thesis-btn">
                    <img src="<?php echo theme_url(); ?>img/icon-edit.png" alt="edit" />
                </a>
                <?php if ( ! $this->msets->set_published( $data['id'] ) ) { ?>
                <a href="#" onclick="return delete_thesis(<?php echo $data['id']; ?>)" class="delete-thesis-btn mar-left">
                    <img src="<?php echo theme_url(); ?>img/icon-delete.png" alt="delete" />
                </a>
                <?php } ?>
            </div>
            <h6><?php echo $data['title']; ?></h6>
            <p><?php echo $data['content']; ?></p>
            <?php
        }
        else if ( $mode == 'edit' )
        {
            ?>
            <form method="post" action="#" onsubmit="return submit_edit(<? echo $data['id']; ?>)">
                <ul class="align-list">
                    <li>
                        <input type="text" name="edit_title" id="edit_title" maxlength="256" class="box-large" value="<?php echo $data['title']; ?>" />
                    </li>
                    <li>
                        <textarea name="edit_content" id="edit_content" class="iseditor_<? echo $data['id']; ?>" cols="80" rows="15"><?php echo $data['content']; ?></textarea>
                    </li>
                    <li>
                        <input type="submit" value="Ενημέρωση" name="editthesis_button" id="editthesis_button" class="dis-inline-block" />
                        <input type="submit" value="Ακύρωση" name="canceledit_button" id="canceledit_button" class="red dis-inline-block" onclick="return cancel_edit(<? echo $data['id']; ?>)" />
                    </li>
                </ul>
            </form>
            <?php
        }
	}
	
}

/* End of file thesis.php */