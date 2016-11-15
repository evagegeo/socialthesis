<?php

/**
 * Logout
 *
 * @author Jason Koukliatis
 */
class Logout extends MY_Controller {

    function __construct() {

        parent::__construct();

    }

    /**
     * Logs out the user
     *
     * @access public
     */
    function index() {

        $items = array(
            'id'        => '',
            'username'  => '',
            'email'     => '',
            'access'    => '',
            'logged_in' => ''
        );

        $this->session->unset_userdata($items);

        redirect('site/home');

    }

}

/* End of file logout.php */