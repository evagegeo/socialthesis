<?php

/**
 * Suggestions
 *
 * @author Jason Koukliatis
 */
class Suggestions extends MY_Controller {

    function __construct() {

        parent::__construct();
        
        $this->load->model('m_suggestions', 'msugs');
        
    }

    /**
     * Loads the suggestions view
     *
     * @access public
     */
    function index() {
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/site/suggestions/index/';
        $config['total_rows'] = $this->db->get_where('suggestions', array('view' => '1'))->num_rows();
        $config['per_page'] = 8;
        $config['uri_segment'] = 4;
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

        $this->pagination->initialize($config);

        $suggestions = $this->msugs->getall($config['per_page'], $this->uri->segment(4), TRUE);

        $this->page_data += array(
            'section'     => 'general',
            'page'        => 'suggestions',
            'title'       => 'Προτάσεις',
            'suggestions' => $suggestions
        );
        
        // Add new
        if ($this->input->post('add_button') && $this->check_user()) // If the user posted the data
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

            if ($this->form_validation->run('add_suggestion')) // If passes validation
            {
                $post_data = array(
                    'title'      => $this->input->post('title'),
                    'content'    => $this->input->post('content'),
                    'author_id'  => $this->session->userdata('id'),
                    'published'  => date('Y-m-d H:i:s')
                );
                
                // Add the suggestion to the database
                $query = $this->msugs->insert($post_data);
                
                if ($query)
                    redirect('site/suggestions/index/add_ok');
                else
                    $this->page_data += array( 'error' => 'Παρουσιάστηκε κάποιο πρόβλημα και η πρόταση δεν καταχωρήθηκε!' );
            }
        }

        $this->load->view('suggestions', $this->page_data);
    }
    
    /**
     * Loads the suggestion single view
     * 
     * @access public
     */
    function view() {
        
        $sug_id = $this->uri->segment(4);
        
        if ( is_numeric($sug_id) )
        {
            $suggestion = $this->msugs->get( $sug_id );
            
            if ($suggestion)
            {
                $this->load->model('m_comments', 'mcoms');
                
                $this->page_data += array(
                    'section'    => 'general',
                    'page'       => 'suggestions',
                    'title'      => 'Προτάσεις - '.$suggestion['title'],
                    'suggestion' => $suggestion,
                    'comments'   => $this->mcoms->get_all( $sug_id, 2, 1)
                );
                
                // Add comment
                if ($this->input->post('add_button') && $this->check_user()) // If the user posted the data
                {
                    $this->load->library('form_validation');
                    $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

                    if ($this->form_validation->run('add_comment')) // If passes validation
                    {
                        $post_data = array(
                            'content'    => $this->input->post('content'),
                            'author_id'  => $this->session->userdata('id'),
                            'published'  => date('Y-m-d H:i:s'),
                            'category'   => 2,
                            'content_id' => $sug_id
                        );

                        // Add the comment to the database
                        $query = $this->mcoms->insert($post_data);

                        if ($query)
                            redirect('site/suggestions/view/'.$sug_id.'/add_ok#add_comment');
                        else
                            $this->page_data += array( 'error' => 'Παρουσιάστηκε κάποιο πρόβλημα και το σχόλιο δεν προστέθηκε!' );
                    }
                }

                $this->load->view('suggestions', $this->page_data);
            }
        }
    }
    
    /**
     * Mode
     * 
     * @access public
     */
    function mode() {
        
        if ($this->check_user())
        {
            $mode = $this->uri->segment(4);
            
            if ( $mode == 'my' )
                $suggestions = $this->msugs->getall( FALSE, FALSE, TRUE, array('suggestions.author_id' => $this->session->userdata['id']));
            else if ( $mode == 'fav' )
                $suggestions = $this->msugs->getall( FALSE, FALSE, TRUE, FALSE, $this->session->userdata['id']);
            else if ( $mode == 'pop' )
                $suggestions = $this->msugs->getall( FALSE, FALSE, TRUE, FALSE, FALSE, TRUE);
            else
                exit(0);
            
            $this->page_data += array(
                'section'     => 'general',
                'page'        => 'suggestions',
                'title'       => 'Προτάσεις',
                'suggestions' => $suggestions
            );
                        
            $this->load->view('suggestions', $this->page_data);
        }
    }
    
    /**
     * Ajax Functionality
     * 
     * @access public
     */
    function ajax() {
        
        if ($this->check_user())
        {
            $mode = $this->input->post('mode');
            $content_id = $this->input->post('content_id');

            if ($mode == 'star')
                $this->db->insert('favorites', array('user_id' => $this->session->userdata('id'), 'content_id' => $content_id, 'category' => 2));
            else if ($mode == 'unstar')
                $this->db->delete('favorites', array('user_id' => $this->session->userdata('id'), 'content_id' => $content_id, 'category' => 2));
        }
    }
    
}

/* End of file suggestions.php */