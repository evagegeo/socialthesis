<?php

/**
 * Data
 *
 * @author Christine Naskopoulou
 */
class Data extends MY_Controller {

    function __construct() {

        parent::__construct();

        $this->check_user(1, TRUE);

    }

    /**
     * Loads the admin data view from where the admin can change his data
     *
     * @access public
     */
    function index() {

        // Load models & libraries
        $this->load->model('m_users', 'musers');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');
        
        // Get admin data
        $userdata = $this->musers->get($this->session->userdata('id'));
        
        if ($this->input->post('delete_photo_button')) // If the user wants to delete his photo
		{
			$old_photo = $this->musers->get($this->session->userdata('id'), 'photo');

			$query = $this->musers->update($this->session->userdata('id'), array('photo' => NULL));

			if ($old_photo && $query)
			{
				unlink("./uploads/photos/$old_photo");
                
                // Update session photo
                $this->session->set_userdata('photo', NULL);
                
				redirect('admin/data/index/delete_photo_ok#photo');
			}
			else
			{
				$this->page_data += array(
					'error_photo' => 'Παρουσιάστηκε κάποιο πρόβλημα και η φωτογραφία δεν διαγράφτηκε!'
				);
			}
		}

        if ($this->input->post('photo_button')) // If the user posted a photo
		{
			$inc_url = inc_url();

			$config['upload_path'] = './uploads/photos/';
			$config['file_name'] = "".$this->session->userdata('username')."_photo";
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']	= '1000';
			$config['max_width']  = '1000';
			$config['max_height']  = '1000';
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('photo'))
			{
				$this->page_data += array(
					'error_photo' => $this->upload->display_errors('', '')
				);
			}
			else
			{
				$old_photo = $this->musers->get($this->session->userdata('id'), 'photo');
				
				$photo_data = $this->upload->data();

				$query = $this->musers->update($this->session->userdata('id'), array('photo' => $photo_data['file_name']));

				if ($query)
                {
					if ($old_photo)
						unlink("./uploads/photos/$old_photo");
                    
                    // Update session photo
                    $this->session->set_userdata('photo', $photo_data['file_name']);

                    redirect('admin/data/index/update_photo_ok#photo');
                }
                else
                {
                    $this->page_data += array(
                        'error_photo' => 'Παρουσιάστηκε κάποιο πρόβλημα και δεν έγινε σωστά η ενημέρωση!'
                    );
                }
			}
		}
        else if ($this->input->post('data_button')) // If the user posted the data
        {
            $post_data = array(
                'firstname' => $this->input->post('firstname'),
                'lastname'  => $this->input->post('lastname'),
                'email'     => $this->input->post('email')
            );

            if ($this->form_validation->run('user_data')) // If passes validation
            {
                // Update the user data with the new
                $query = $this->musers->update($this->session->userdata('id'), $post_data);

                if ($query)
                {
                    // Update session data, Firstname & Lastname
                    $this->session->set_userdata('firstname', $post_data['firstname'] );
                    $this->session->set_userdata('lastname', $post_data['lastname'] );
                    
                    redirect('admin/data/index/update_ok#data');
                }
                else
                {
                    $this->page_data += array(
                        'error' => 'Παρουσιάστηκε κάποιο πρόβλημα και δεν έγινε σωστά η ενημέρωση!'
                    );
                }
            }
        }
        else if ($this->input->post('data_password_button')) // If the user posted the password data
        {
            $post_data = array(
                'old_password'    => $this->input->post('old_password'),
                'new_password'    => $this->input->post('new_password'),
                'new_re_password' => $this->input->post('new_re_password')
            );

            if ($this->form_validation->run('data_password')) // If passes validation
            {
                if (do_hash($post_data['old_password']) == $this->musers->get($this->session->userdata('id'), 'password')) // If the current password given is the correct one
                {
                    // Update the password
                    $query = $this->musers->update($this->session->userdata('id'), array('password' => do_hash($post_data['new_password'])));

                    if ($query)
                    {
                        redirect('admin/data/index/update_password_ok#pass');
                    }
                    else // Update failed
                    {
                        $this->page_data += array(
                            'error_2' => 'Παρουσιάστηκε κάποιο πρόβλημα και δεν έγινε σωστά η ενημέρωση!'
                        );
                    }
                }
                else // The current password isn't correct
                {
                    $this->page_data += array(
                        'error_2' => 'Ο κωδικός δεν είναι ο σωστός!'
                    );
                }
            }
        }

        $this->page_data += array(
            'section'   => 'admin',
            'page'      => 'admin_data',
            'title'     => 'Προφίλ',
            'userdata'  => $userdata
        );

        $this->load->view('admin/data', $this->page_data);

    }

}

/* End of file data.php */