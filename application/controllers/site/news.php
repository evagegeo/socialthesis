<?php

/**
 * News
 *
 * @author Jason Koukliatis
 */
class News extends MY_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model('M_news', 'mnews');
        
    }

    /**
     * Loads the news view
     *
     * @access public
     */
    function index() {

        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/site/news/index/';
        $config['total_rows'] = $this->db->get_where('news', array('view' => '1'))->num_rows();
        $config['per_page'] = 6;
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

        $news = $this->mnews->getall($config['per_page'], $this->uri->segment(4), TRUE);

        $this->page_data += array(
            'section' => 'general',
            'page'    => 'news',
            'title'   => 'Νέα',
            'news'    => $news
        );

        $this->load->view('news', $this->page_data);

    }

}

/* End of file news.php */