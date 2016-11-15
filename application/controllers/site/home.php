<?php

/**
 * Home
 *
 * @author Jason Koukliatis
 */
class Home extends MY_Controller {

    function __construct() {
        
        parent::__construct();
        
        $this->load->model('m_thesis', 'mthesis');
    }

    /**
     * Loads the home view
     *
     * @access public
     */
    function index() {
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/site/home/index/';
        $config['total_rows'] = $this->db->get_where('thesis', array('directory' => '1'))->num_rows();
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

        $allthesis = $this->mthesis->get_dir_all($config['per_page'], $this->uri->segment(4));

        $this->page_data += array(
            'section'     => 'general',
            'page'        => 'home',
            'title'       => 'Αρχική - Κατάλογος Διπλωματικών',
            'allthesis'   => $allthesis
        );

        $this->load->view('home', $this->page_data);   
    }
    
    /**
     * Loads the thesis single view
     * 
     * @access public
     */
    function view() {
        
        $thesis_id = $this->uri->segment(4);
        
        if ( is_numeric($thesis_id) )
        {
            $thesis = $this->mthesis->get_dir( $thesis_id );
            
            if ($thesis)
            {
                $this->load->model('m_comments', 'mcoms');
                
                $this->page_data += array(
                    'section'    => 'general',
                    'page'       => 'home',
                    'title'      => $thesis['title'],
                    'thesis'     => $thesis,
                    'comments'   => $this->mcoms->get_all( $thesis_id, 1, 1),
                    'professor'  => $this->db->select('users.id, users.username, users.firstname, users.lastname, users.photo')->from('users')->join('sets', 'sets.professor_id = users.id')->where('sets.id', $thesis['set_id'])->get()->row_array()
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
                            'category'   => 1,
                            'content_id' => $thesis_id
                            
                        );

                        // Add the comment to the database
                        $query = $this->mcoms->insert($post_data);

                        if ($query)
                            redirect('site/home/view/'.$thesis_id.'/add_ok#add_comment');
                        else
                            $this->page_data += array( 'error' => 'Παρουσιάστηκε κάποιο πρόβλημα και το σχόλιο δεν προστέθηκε!' );
                    }
                }

                $this->load->view('home', $this->page_data);
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
            
            if ( $mode == 'fav' )
                $allthesis = $this->mthesis->get_dir_all( FALSE, FALSE, $this->session->userdata['id']);
            else if ( $mode == 'pop' )
                $allthesis = $this->mthesis->get_dir_all( FALSE, FALSE, FALSE, TRUE);
            else
                exit(0);
            
            $this->page_data += array(
                'section'     => 'general',
                'page'        => 'home',
                'title'       => 'Αρχική - Κατάλογος Διπλωματικών',
                'allthesis'   => $allthesis
            );
                        
            $this->load->view('home', $this->page_data);
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
                $this->db->insert('favorites', array('user_id' => $this->session->userdata('id'), 'content_id' => $content_id, 'category' => 1));
            else if ($mode == 'unstar')
                $this->db->delete('favorites', array('user_id' => $this->session->userdata('id'), 'content_id' => $content_id, 'category' => 1));
        }
    }

}

/* End of file home.php */