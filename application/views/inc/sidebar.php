<!-- Sidebar -->
<div id="sidebar">

    <?php if ($this->session->userdata('logged_in')) { // If user is logged in ?>

    <ul id="user-nav">

    <?php if ($this->session->userdata('access') == 1) { // If admin is logged in ?>

        <li>
            <a href="<?php echo site_url('admin/news/index/manage'); ?>" <?php if ($page == 'admin_news') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Νέα
            </a>
        </li>
        <li>
            <a href="<?php echo site_url('admin/users/index/manage'); ?>" <?php if ($page == 'admin_users') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Χρήστες
            </a>
        </li>
        <li>
            <a href="<?php echo site_url('admin/divisions'); ?>" <?php if ($page == 'admin_divisions') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Τομείς
            </a>
        </li>
        <li>
            <a href="<?php echo site_url('admin/page'); ?>" <?php if ($page == 'admin_page') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Ρυθμίσεις Σελίδας
            </a>
        </li>
        <li class="section"></li>
        <li>
            <a href="<?php echo site_url('admin/data'); ?>" <?php if ($page == 'admin_data') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Ρυθμίσεις Προφίλ
            </a>
        </li>

    <?php } else if ($this->session->userdata('access') == 2) { // If a professor is logged in ?>

        <?php if ( ( $this->uri->segment(3) == 'edit' ) && ( is_numeric( $this->uri->segment(4) ) ) ) { ?>
        <li>
            <a href="<?php echo site_url('professor/thesis'); ?>" class="active">Διαχείριση</a>
        </li>
        <li class="sub">
            <a href="<?php echo site_url('professor/thesis/edit/'.$this->uri->segment(4)); ?>" class="active">
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Διπλωματικές σετ
            </a>
        </li>
        <?php } else if ( ( $this->uri->segment(3) == 'requests' ) && ( is_numeric( $this->uri->segment(4) ) ) ) { ?>
        <li>
            <a href="<?php echo site_url('professor/thesis'); ?>" class="active">Διαχείριση</a>
        </li>
        <li class="sub">
            <a href="<?php echo site_url('professor/thesis/requests/'.$this->uri->segment(4)); ?>" class="active">
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Αιτήσεις σετ
            </a>
        </li>
        <?php } else { ?>
        <li>
            <a href="<?php echo site_url('professor/thesis'); ?>" <?php if ($page == 'professor_thesis') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Διαχείριση
            </a>
        </li>
        <?php } ?>
        <li class="section"></li>
        <li>
            <a href="<?php echo site_url('professor/data'); ?>" <?php if ($page == 'professor_data') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Ρυθμίσεις Προφίλ
            </a>
        </li>

    <?php } else if ($this->session->userdata('access') == 3) { // If a student is logged in ?>

		<?php if ($this->db->where('student_id', $this->session->userdata('id'))->where('selected', '1')->get('requests')->result_array()) { ?>
		<li>
            <a href="<?php echo site_url('student/thesis'); ?>" class="tbold<?php if ($page == 'student_thesis') echo ' active'; ?>">
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Ανάθεση διπλωματικής
            </a>
        </li>
		<?php } ?>
		<li>
            <a href="<?php echo site_url('student/requests'); ?>" <?php if ($page == 'student_requests') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Αιτήσεις
            </a>
        </li>
        <li class="section"></li>
        <li>
            <a href="<?php echo site_url('student/data'); ?>" <?php if ($page == 'student_data') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Ρυθμίσεις Προφίλ
            </a>
        </li>

    <?php } else if ($this->session->userdata('access') == 4) { // If a user is logged in ?>
        
        <li>
            <a href="<?php echo site_url('user/data'); ?>" <?php if ($page == 'user_data') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
                Ρυθμίσεις Προφίλ
            </a>
        </li>
        
    <?php } ?>

    </ul>
    
    <?php } ?>

</div>
<!-- END Sidebar -->