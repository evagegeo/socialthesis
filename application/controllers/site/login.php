<?php

/**
 * Login
 *
 * @author Jason Koukliatis
 */
class Login extends MY_Controller {

    function __construct() {

        parent::__construct();
        
    }

    /**
     * Loads the login view and logs in the user
     *
     * @access public
     */
    function index() {

        if ($this->session->userdata('logged_in')) // If user is logged in redirect to homepage
        {
            redirect('site/home');
        }
        else // Else try to login or show the login page
        {
            // Add to the page_data array the 'page' and 'title' value of login page
            $this->page_data += array(
                'section'   => 'general',
                'page'      => 'login',
                'title'     => 'Είσοδος'
            );

            if ($this->input->post('login_button')) // If the user posts the login form
            {
                // Load form validation & set error delimeters
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

                // Run form validation
                if ($this->form_validation->run('site_login') == FALSE) // If validation fails go back and show the errors
                {
                    $this->load->view('login', $this->page_data);
                }
                else // If validation succeeds
                {
                    // Load models
                    $this->load->model('M_users', 'musers');

                    // Check the user's credentials through m_users model
                    $result = $this->musers->check($this->input->post('login_username'), do_hash($this->input->post('login_password')));
                    
                    if ( $result == 'inactive' ) // if user account is inactive
                    {
                        $this->page_data += array(
                            'error'  => 'Ο λογαριασμός είναι ανενεργός!'
                        );

                        $this->load->view('login', $this->page_data);
                    }
                    else if ( $result == 'awaiting_activation' ) // if user account is awaiting activation
                    {
                        $this->page_data += array(
                            'error'  => 'Ο λογαριασμός δεν έχει εγκριθεί ακόμη!'
                        );

                        $this->load->view('login', $this->page_data);
                    }
                    else if ($result) // If user exists save the user data to the session
                    {
                        // Update logged date
                        $this->musers->update( $result['id'] , array( 'logged' => date('y-m-d H:i:s') ));
                        
                        $userdata = array(
                            'id'        => $result['id'],
                            'username'  => $result['username'],
                            'email'     => $result['email'],
                            'access'    => $result['access'],
                            'firstname' => $result['firstname'],
                            'lastname'  => $result['lastname'],
                            'photo'     => $result['photo'],
                            'logged_in' => TRUE
                        );

                        $this->session->set_userdata($userdata);

                        // Go back to the site
                        redirect('site/home');
                    }
                    else // If the user doesn't exist show the error
                    {
                        $this->page_data += array(
                            'error'  => 'Τα στοιχεία δεν είναι σωστά!'
                        );

                        $this->load->view('login', $this->page_data);
                    }
                }

            }
            else // Load the login view
            {
                $this->load->view('login', $this->page_data);
            }
        }

    }

}

/* End of file login.php */