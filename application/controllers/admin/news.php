<?php

/**
 * News
 *
 * @author Christine Naskopoulou
 */
class News extends MY_Controller {

    function __construct() {

        parent::__construct();

        $this->check_user(1, TRUE);

        $this->load->model('M_news', 'mnews');

    }

    /**
     * Loads the admin news view from where the admin can create and edit news
     *
     * @access public
     */
    function index() {

        // Manage news
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/admin/news/index/manage/';
        $config['total_rows'] = $this->db->get('news')->num_rows();
        $config['per_page'] = 20;
        $config['uri_segment'] = 5;
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

        // To solve the conflict when we edit a new (because of the ajax tabs)
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

        $news = $this->mnews->getall($config['per_page'], $offset);

        // Add new
        if ($this->input->post('addnew_button')) // If the user posted the data
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

            if ($this->form_validation->run('add_new')) // If passes validation
            {
                $post_data = array(
                    'title'      => $this->input->post('new_title'),
                    'content'    => $this->input->post('new_content'),
                    'author_id'  => $this->session->userdata('id'),
                    'published'  => date('Y-m-d H:i:s')
                );
                
                // Add the new to the database
                $query = $this->mnews->insert($post_data);

                if ($query)
                    redirect('admin/news/index/add/add_ok#tabs');
                else
                    $this->page_data += array( 'error_add' => 'Παρουσιάστηκε κάποιο πρόβλημα και το νέο δεν προστέθηκε!' );
            }
        }

        // Edit new
        if ($this->uri->segment(4) == 'edit')
        {
            $editnew = $this->mnews->get($this->uri->segment(5));

            $this->page_data += array(
                'editnew' => $editnew
            );

            if ($this->input->post('editnew_button')) // If the user posted the data
            {
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<div class="msg-error">', '</div>');

                $post_data = array(
                    'title'   => $this->input->post('edit_title'),
                    'content' => $this->input->post('edit_content'),
                    'view'    => $this->input->post('edit_view')
                );

                if ($this->form_validation->run('edit_new')) // If passes validation
                {
                    // Update new
                    $query = $this->mnews->update($this->uri->segment(5), $post_data);

                    if ($query)
                    {
                        redirect("admin/news/index/edit/".$this->uri->segment(5)."/edit_ok#tabs");
                    }
                    else
                    {
                        $this->page_data += array(
                            'error_edit' => 'Παρουσιάστηκε κάποιο πρόβλημα και το νέο δεν ενημερώθηκε!'
                        );
                    }
                }
            }
        }
 
        $this->page_data += array(
            'section' => 'admin',
            'page'    => 'admin_news',
            'title'   => 'Διαχείριση νέων',
            'news'    => $news
        );

        $this->load->view('admin/news', $this->page_data);

    }

}

/* End of file news.php */