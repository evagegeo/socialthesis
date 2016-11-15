<?php

/**
 * Register
 *
 * @author Jason Koukliatis
 */
class Register extends MY_Controller {

    function __construct() {

        parent::__construct();
        
        if ( $this->check_user() )
            redirect('site/home');
    }

    /**
     * Loads the register view
     *
     * @access public
     */
    function index() {
        
        $this->page_data += array(
            'section' => 'general',
            'page'    => 'register',
            'title'   => 'Εγγραφή'
        );
        
        // Add user
        if ($this->input->post('register_button')) // If the user posted the data
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

            if ($this->form_validation->run('register_user')) // If passes validation
            {
                $post_data = array(
                    'username'  => $this->input->post('register_username'),
                    'password'  => do_hash($this->input->post('register_password')),
                    'email'     => $this->input->post('register_email'),
                    'firstname' => $this->input->post('register_firstname'),
                    'lastname'  => $this->input->post('register_lastname')
                );
                
                $username_exists = $this->db->get_where('users', array('username' => $post_data['username']))->num_rows();
				$email_exists = $this->db->get_where('users', array('email' => $post_data['email']))->num_rows();

                if ($username_exists > 0) // If the submitted username exists
                    $this->page_data += array( 'error' => 'Το ψευδώνυμο υπάρχει ήδη!' );
                else if ($email_exists > 0) // If the submitted email exists
                    $this->page_data += array( 'error' => 'Το email υπάρχει ήδη!' );
				else
                {
                    $this->load->model('m_users', 'musers');
                            
                    $msg_mode = 'adduserok';
                    
                    if ( ENVIRONMENT == 'production')
                    {
                        // Captcha validation
                    }
                    
                    if ( $this->input->post('register_access') == 3 ) // Student account
                    {
                        $post_data += array( 'access' => 3, 'activated' => 2 );
                        $msg_mode = 'addstudentok';
                    }
                    else // User account
                        $post_data += array( 'access' => 4 );
                            
                    $post_data += array( 'created' => date('y-m-d H:i:s') );
                    
                    // Add the user to the database
                    $query = $this->musers->insert($post_data);

                    if ($query)
                        redirect('site/register/index/'.$msg_mode);
                    else
                        $this->page_data += array( 'error' => 'Παρουσιάστηκε κάποιο πρόβλημα και η εγγραφή δεν πραγματοποιήθηκε!' );
                }
            }
        }

        $this->load->view('register', $this->page_data);

    }

}

/* End of file register.php */