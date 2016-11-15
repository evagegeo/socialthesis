<?php

/**
 * Users
 *
 * @author Christine Naskopoulou
 */
class Users extends MY_Controller {

    function __construct() {

        parent::__construct();

        $this->check_user(1, TRUE);

        $this->load->model('M_users', 'musers');

    }

    /**
     * Loads the admin users view from where the admin can create, edit and delete users
     *
     * @access public
     */
    function index() {

        // Manage news
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/admin/users/index/manage/';
        $config['total_rows'] = $this->db->get('users')->num_rows();
        $config['per_page'] = 20;
        $config['num_links'] = 3;
        $config['first_link'] = 'Πρώτη';
        $config['last_link'] = 'Τελευταία';
        $config['full_tag_open'] = '<ul class="pagination tcenter">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><span class="page-active radius">';
        $config['cur_tag_close'] = '</span></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['anchor_class'] = 'class="page radius"';

        // To solve the conflict when we edit a user (because of the ajax tabs)
        if ($this->uri->segment(4) == 'edit')
        {
            $offset = '';
            $config['uri_segment'] = 10;
        }
        else
        {
            $offset = $this->uri->segment(5);
            $config['uri_segment'] = 5;
        }

        $this->pagination->initialize($config);

        $users = $this->musers->getall($config['per_page'], $offset);

        // Add user
        if ($this->input->post('adduser_button')) // If the user posted the data
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

            $post_data = array(
                'username'  => $this->input->post('user_username'),
                'password'  => do_hash($this->input->post('user_password')),
                'email'     => $this->input->post('user_email'),
                'firstname' => $this->input->post('user_firstname'),
                'lastname'  => $this->input->post('user_lastname'),
                'access'    => $this->input->post('user_access')
            );

            if ($this->form_validation->run('add_user')) // If passes validation
            {
                $username_exists = $this->db->get_where('users', array('username' => $post_data['username']))->num_rows();
				$email_exists = $this->db->get_where('users', array('email' => $post_data['email']))->num_rows();

                if ($username_exists > 0) // If the submitted username exists
                {
                    $this->page_data += array(
                        'error_add' => 'Το ψευδώνυμο υπάρχει ήδη!'
                    );
                }
                else if ($email_exists > 0) // If the submitted email exists
                {
                    $this->page_data += array(
                        'error_add' => 'Το email υπάρχει ήδη!'
                    );
                }
				else
                {
                    $post_data += array(
                        'created' => date('y-m-d H:i:s')
                    );
                    
                    // Add the user to the database
                    $query = $this->musers->insert($post_data);

                    if ($query)
                    {
                        redirect('admin/users/index/add/add_ok#tabs');
                    }
                    else
                    {
                        $this->page_data += array(
                            'error_add' => 'Παρουσιάστηκε κάποιο πρόβλημα και ο χρήστης δεν προστέθηκε!'
                        );
                    }
                }
            }
        }

        // Edit user
        if ($this->uri->segment(4) == 'edit')
        {
            $edituser = $this->musers->get($this->uri->segment(5));

            $this->page_data += array(
                'edituser' => $edituser
            );

            if ($this->input->post('edituser_button')) // If the user posted the data
            {
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

                $post_data = array(
                    'username'  => $this->input->post('edit_username'),
                    'email'     => $this->input->post('edit_email'),
                    'firstname' => $this->input->post('edit_firstname'),
                    'lastname'  => $this->input->post('edit_lastname'),
                    'access'    => $this->input->post('edit_access')
                );

                if ($this->input->post('edit_password')) // If password submitted
                {
                    $post_data += array(
                        'password'  => do_hash($this->input->post('edit_password'))
                    );
                }

                if ($this->form_validation->run('edit_user')) // If passes validation
                {
                    $org_username = $this->musers->get($this->uri->segment('5'), 'username'); // User original username
					$org_email = $this->musers->get($this->uri->segment('5'), 'email'); // User original email

                    if ($org_username == $post_data['username']) // If submitted username hasn't changed
                        $username_exists = 0;
                    else // If changed check if the username exists
                        $username_exists = $this->db->get_where('users', array('username' => $post_data['username']))->num_rows();

					if ($org_email == $post_data['email']) // If submitted email hasn't changed
                        $email_exists = 0;
                    else // If changed check if the email exists
                        $email_exists = $this->db->get_where('users', array('email' => $post_data['email']))->num_rows();

                    if ($username_exists > 0) // If the submitted username exists
                    {
                        $this->page_data += array(
                            'error_edit' => 'Το ψευδώνυμο υπάρχει ήδη!'
                        );
                    }
					else if ($email_exists > 0) // If the submitted email exists
					{
						$this->page_data += array(
							'error_edit' => 'Το email υπάρχει ήδη!'
						);
					}
                    else
                    {
                        // Update user
                        $query = $this->musers->update($this->uri->segment(5), $post_data);

                        if ($query)
                        {
                            redirect("admin/users/index/edit/".$this->uri->segment(5)."/edit_ok#tabs");
                        }
                        else
                        {
                            $this->page_data += array(
                                'error_edit' => 'Παρουσιάστηκε κάποιο πρόβλημα και το προφίλ του χρήστη δεν ενημερώθηκε!'
                            );
                        }
                    }
                    
                }
            }
        }

        $this->page_data += array(
            'section'   => 'admin',
            'page'      => 'admin_users',
            'title'     => 'Διαχείριση χρηστών',
            'users'     => $users
        );

        $this->load->view('admin/users', $this->page_data);

    }
    
    /**
     * Ajax activate, deactivate users
     *
     * @access public
     */
    function ajax() {
        $mode = $this->input->post('mode');
        $user_id = $this->input->post('user_id');
        
        $this->load->model('m_users', 'musers');
        
        if ( $mode == 'activate' )
            $this->musers->update( $user_id, array( 'activated' => 1));
        else if ( $mode == 'approve' )
            $this->musers->update( $user_id, array( 'activated' => 1));
        else if ( $mode == 'deactivate' )
            $this->musers->update( $user_id, array( 'activated' => 0));
    }

}

/* End of file users.php */