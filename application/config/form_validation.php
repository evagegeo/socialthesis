<?php

$config = array(
        'site_login' => array(
                array(
                        'field' => 'login_username',
                        'label' => 'Ψευδώνυμο',
                        'rules' => 'trim|required|min_length[3]|max_length[15]|alpha_dash'
                ),
                array(
                        'field' => 'login_password',
                        'label' => 'Κωδικός',
                        'rules' => 'trim|required|min_length[6]|max_length[15]|alpha_numeric'
                )
        ),
        'user_data' => array(
                array(
                        'field' => 'firstname',
                        'label' => 'Όνομα',
                        'rules' => 'required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Επώνυμο',
                        'rules' => 'required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Ηλεκτρονική διεύθυνση',
                        'rules' => 'required|valid_email|max_length[128]'
                )
        ),
		'admin_dir' => array(
                array(
                        'field' => 'title',
                        'label' => 'Τίτλος',
                        'rules' => 'required|min_length[3]|max_length[256]'
                )
        ),
        'professor_data' => array(
                array(
                        'field' => 'firstname',
                        'label' => 'Όνομα',
                        'rules' => 'required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Επώνυμο',
                        'rules' => 'required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Ηλεκτρονική διεύθυνση',
                        'rules' => 'required|valid_email|max_length[128]'
                ),
                array(
                        'field' => 'address',
                        'label' => 'Διεύθυνση',
                        'rules' => 'max_length[256]'
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Τηλέφωνο',
                        'rules' => 'numeric|max_length[15]'
                ),
                array(
                        'field' => 'professor_attr',
                        'label' => 'Ιδιότητα',
                        'rules' => 'required|max_length[128]'
                )
        ),
        'student_data' => array(
                array(
                        'field' => 'firstname',
                        'label' => 'Όνομα',
                        'rules' => 'required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Επώνυμο',
                        'rules' => 'required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Ηλεκτρονική διεύθυνση',
                        'rules' => 'required|valid_email|max_length[128]'
                ),
                array(
                        'field' => 'address',
                        'label' => 'Διεύθυνση',
                        'rules' => 'required|max_length[256]'
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Τηλέφωνο',
                        'rules' => 'required|numeric|max_length[15]'
                ),
				array(
                        'field' => 'student_aem',
                        'label' => 'ΑΕΜ',
                        'rules' => 'required|numeric|max_length[6]'
                ),
                array(
                        'field' => 'student_year',
                        'label' => 'Έτος σπουδών',
                        'rules' => 'required|numeric|max_length[2]'
                ),
                array(
                        'field' => 'student_grade',
                        'label' => 'Βαθμολογία',
                        'rules' => 'required|numeric|max_length[5]'
                ),
                array(
                        'field' => 'student_cleft',
                        'label' => 'Μαθήματα που απομένουν για λήψη πτυχίου',
                        'rules' => 'required|numeric|max_length[2]'
                )
        ),
        'data_password' => array(
                array(
                        'field' => 'old_password',
                        'label' => 'Κωδικός',
                        'rules' => 'trim|required|min_length[6]|max_length[15]|alpha_numeric'
                ),
                array(
                        'field' => 'new_password',
                        'label' => 'Νέος κωδικός',
                        'rules' => 'trim|required|min_length[6]|max_length[15]|alpha_numeric'
                ),
                array(
                        'field' => 'new_re_password',
                        'label' => 'Επανάληψη νέου κωδικού',
                        'rules' => 'trim|required|matches[new_password]'
                )
        ),
        'add_new' => array(
                array(
                        'field' => 'new_title',
                        'label' => 'Τίτλος',
                        'rules' => 'trim|required|min_length[3]|max_length[256]'
                ),
                array(
                        'field' => 'new_content',
                        'label' => 'Περιεχόμενο',
                        'rules' => 'trim|required|min_length[3]'
                )
        ),
        'edit_new' => array(
                array(
                        'field' => 'edit_title',
                        'label' => 'Τίτλος',
                        'rules' => 'trim|required|min_length[3]|max_length[256]'
                ),
                array(
                        'field' => 'edit_content',
                        'label' => 'Περιεχόμενο',
                        'rules' => 'trim|required|min_length[3]'
                )
        ),
        'register_user' => array(
                array(
                        'field' => 'register_username',
                        'label' => 'Ψευδώνυμο',
                        'rules' => 'trim|required|min_length[3]|max_length[15]|alpha_dash'
                ),
                array(
                        'field' => 'register_password',
                        'label' => 'Κωδικός',
                        'rules' => 'trim|required|min_length[6]|max_length[15]|alpha_numeric'
                ),
                array(
                        'field' => 'register_password2',
                        'label' => 'Επιβεβαίωση Κωδικού',
                        'rules' => 'trim|required|matches[register_password]'
                ),
                array(
                        'field' => 'register_email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|max_length[128]'
                ),
                array(
                        'field' => 'register_firstname',
                        'label' => 'Όνομα',
                        'rules' => 'trim|required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'register_lastname',
                        'label' => 'Επώνυμο',
                        'rules' => 'trim|required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'register_access',
                        'label' => 'Λογαριασμός φοιτητή',
                        'rules' => ''
                )
        ),
        'add_user' => array(
                array(
                        'field' => 'user_username',
                        'label' => 'Ψευδώνυμο',
                        'rules' => 'trim|required|min_length[3]|max_length[15]|alpha_dash'
                ),
                array(
                        'field' => 'user_password',
                        'label' => 'Κωδικός',
                        'rules' => 'trim|required|min_length[6]|max_length[15]|alpha_numeric'
                ),
                array(
                        'field' => 'user_email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|max_length[128]'
                ),
                array(
                        'field' => 'user_firstname',
                        'label' => 'Όνομα',
                        'rules' => 'trim|required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'user_lastname',
                        'label' => 'Επώνυμο',
                        'rules' => 'trim|required|min_length[3]|max_length[50]'
                )
        ),
        'edit_user' => array(
                array(
                        'field' => 'edit_username',
                        'label' => 'Ψευδώνυμο',
                        'rules' => 'trim|required|min_length[3]|max_length[15]|alpha_dash'
                ),
                array(
                        'field' => 'edit_password',
                        'label' => 'Κωδικός',
                        'rules' => 'trim|min_length[6]|max_length[15]|alpha_numeric'
                ),
                array(
                        'field' => 'edit_email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|max_length[128]'
                ),
                array(
                        'field' => 'edit_firstname',
                        'label' => 'Όνομα',
                        'rules' => 'trim|required|min_length[3]|max_length[50]'
                ),
                array(
                        'field' => 'edit_lastname',
                        'label' => 'Επώνυμο',
                        'rules' => 'trim|required|min_length[3]|max_length[50]'
                )
        ),
		'professor_set' => array(
                array(
                        'field' => 'start',
                        'label' => 'Έναρξη αιτήσεων',
                        'rules' => 'trim|required|min_length[10]|max_length[10]'
                ),
                array(
                        'field' => 'end',
                        'label' => 'Λήξη αιτήσεων',
                        'rules' => 'trim|required|min_length[10]|max_length[10]'
                )
        ),
	    'professor_add_thesis' => array(
                array(
                        'field' => 'thesis_title',
                        'label' => 'Τίτλος',
                        'rules' => 'required|min_length[4]|max_length[256]'
                ),
                array(
                        'field' => 'thesis_content',
                        'label' => 'Περιγραφή',
                        'rules' => 'required|min_length[5]'
                )
        ),
        'add_suggestion' => array(
                array(
                        'field' => 'title',
                        'label' => 'Τίτλος',
                        'rules' => 'trim|required|min_length[3]|max_length[256]'
                ),
                array(
                        'field' => 'content',
                        'label' => 'Περιγραφή',
                        'rules' => 'trim|required|min_length[3]'
                )
        ),
        'add_comment' => array(
                array(
                        'field' => 'content',
                        'label' => 'Σχόλιο',
                        'rules' => 'trim|required|min_length[3]|max_length[5000]'
                )
        )
);

/* End of file form_validation.php */