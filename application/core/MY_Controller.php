<?php

/**
 * MY_Controller
 *
 * @author Jason Koukliatis
 */
class MY_Controller extends CI_Controller {

    // Array that holds the data of the page
    public $page_data = array();

    function __construct()
    {
        parent::__construct();

        $this->load_essentials();
        
        // $this->output->enable_profiler(TRUE);
    }

    /**
     * Loads the essential data used in all pages (meta data & theme)
     *
     * @access public
     */
    function load_essentials()
    {
        // Load models
        $this->load->model('M_config', 'mcf');
            
        $config = $this->mcf->get_all();
        
        foreach ( $config as $row ) {
            
            // Put in the array the meta data from database
            $this->page_data += array(
                $row['name']  => $row['value']
            );
            
            if ( $row['name'] == 'page_theme')
                if ( $row['value'] )
                    $this->config->set_item('theme_name', $row['value']);
        }
        
        
    }

    /**
     * Checks if a user is logged in and if not, it redirects to homepage
     *
     * @access public
     * @param int
     * @param boolean 
     * @return boolean
     */
    function check_user($access = 0, $mode = FALSE)
    {
        if ($mode && $access) // If $mode = TRUE and $access = 'a number' then it will redirect to homepage (good for protecting pages)
        {
            if ($this->session->userdata('access') != $access)
                redirect('site/home');
        }
        else if ($access) // If $mode = FALSE then it will return a boolean (good for showing some stuff, eg a specific user menu)
        {
            if ($this->session->userdata('access') != $access)
                return FALSE;
            else
                return TRUE;
        }
        else // If $access = FALSE then it will return a boolean with the user log in status no matter what his access is
        {
            return $this->session->userdata('logged_in');
        }
    }
    
}

// End of file MY_Controller.php