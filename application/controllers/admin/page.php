<?php

/**
 * Page
 *
 * @author Christine Naskopoulou
 */
class Page extends MY_Controller {

    function __construct() {

        parent::__construct();

        $this->check_user(1, TRUE);

        $this->load->helper('directory');

    }

    /**
     * Loads the admin page view from where the admin can change the data from the paga (meta data ++)
     *
     * @access public
     */
    function index() {

        if ($this->input->post('page_button')) // If admin submits the form
        {
            if ($this->mcf->update('page_title', $this->input->post('page_title')) &&
                $this->mcf->update('page_description', $this->input->post('page_description')) &&
                $this->mcf->update('page_keywords', $this->input->post('page_keywords')) &&
                $this->mcf->update('page_robots', $this->input->post('page_robots')) &&
                $this->mcf->update('page_theme', $this->input->post('page_theme')) &&
                $this->mcf->update('page_footer', $this->input->post('page_footer'))
                ) // If all the updates are ok
            {
                redirect('admin/page/index/update_ok');
            }
            else // Else create an error message
            {
                $this->page_data += array(
                    'error' => 'Παρουσιάστηκε κάποιο πρόβλημα και δεν έγινε σωστά η ενημέρωση!'
                );
            }
        }

        // find the names of the available themes
        $themes = directory_map('assets/themes/', TRUE);

        $this->page_data += array(
            'section'       => 'admin',
            'page'          => 'admin_page',
            'title'         => 'Ρυθμίσεις σελίδας',
            'theme'         => $this->mcf->get('page_theme'),
            'themenames'    => $themes
        );

        $this->load->view('admin/page', $this->page_data);

    }

}

/* End of file page.php */