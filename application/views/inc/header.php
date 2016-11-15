</head>

<body>
    
<!-- Ajax Loading -->
<div id="ajax-loading"><img src="<?php echo theme_url(); ?>img/loading.gif" alt="loading" /></div>

<!-- Container -->
<div id="container">
    
<!-- Header -->
<div id="header">
    <?php echo anchor('site/home', "<img src=\"".theme_url()."img/logo.png\" alt=\"logo\" class=\"logo\" />"); ?>
    
    <?php if ($this->session->userdata('logged_in')) { // If is logged in ?>
    
        <?php
        $user_mode = '';
        if ($this->session->userdata('access') == 1) { // If admin is logged in
            $user_mode = 'admin';
        } else if ($this->session->userdata('access') == 2) { // If professor is logged in
            $user_mode = 'professor';
        } else if ($this->session->userdata('access') == 3) { // If student is logged in
            $user_mode = 'student';
        } else if ($this->session->userdata('access') == 4) { // If user is logged in    
            $user_mode = 'user';
        }
        ?>

        <div class="photo">
            <?php if ( $this->session->userdata('photo') ) { ?>
                <img src="<?php echo base_url()."uploads/photos/".$this->session->userdata('photo'); ?>" alt="photo" width="40" height="40" />
            <?php } else { ?>
                <img src="<?php echo theme_url()."img/nophoto.png"; ?>" alt="photo" width="40" height="40" />
            <?php } ?>
        </div>
        <div id="user-info">
            <?php if ($this->session->userdata('access') == 2) { // If professor is logged in ?>
                <a href="<?php echo site_url("professor/profile/index/".$this->session->userdata('id').""); ?>" class="alight">
                    <?php echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname'); ?>
                </a>
            <?php } else { ?>
                <strong><?php echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname'); ?></strong>
            <?php } ?>
            </br>
            <a href="<?php echo site_url($user_mode.'/data'); ?>" class="alight">Προφίλ</a>
        </div>
        
    <?php } ?>
        
</div>
<!-- END Header -->

<!-- Navigation -->
<ul id="nav" class="clearfix">
    <li>
        <a href="<?php echo site_url('site/home'); ?>" <?php if ($page == 'home') echo 'class="active"'; ?>>
            <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
            <img src="<?php echo theme_url(); ?>img/nav-home.png" alt="home" />
            Διπλωματικές
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('site/news'); ?>" <?php if ($page == 'news') echo 'class="active"'; ?>>
            <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
            <img src="<?php echo theme_url(); ?>img/nav-news.png" alt="news" />
            Νέα
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('site/suggestions'); ?>" <?php if ($page == 'suggestions') echo 'class="active"'; ?>>
            <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
            <img src="<?php echo theme_url(); ?>img/nav-suggestions.png" alt="suggestions" />
            Προτάσεις
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('site/thesis'); ?>" <?php if ($page == 'thesis') echo 'class="active"'; ?>>
            <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
            <img src="<?php echo theme_url(); ?>img/nav-thesis.png" alt="thesis" />
            Αιτήσεις
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('site/archive'); ?>" <?php if ($page == 'archive') echo 'class="active"'; ?>>
            <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
            <img src="<?php echo theme_url(); ?>img/nav-archive.png" alt="archive" />
            Αρχείο
        </a>
    </li>
    
    <?php if (!$this->session->userdata('logged_in')) { // If user isn't logged in ?>
    
        <li class="fright mar-none">
            <a href="<?php echo site_url('site/login'); ?>" <?php if ($page == 'login') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
                <img src="<?php echo theme_url(); ?>img/nav-auth.png" alt="login" />
                Είσοδος
            </a>
        </li>
        <li class="fright mar-left">
            <a href="<?php echo site_url('site/register'); ?>" <?php if ($page == 'register') echo 'class="active"'; ?>>
                <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
                <img src="<?php echo theme_url(); ?>img/nav-register.png" alt="register" />
                Εγγραφή
            </a>
        </li>
        
    <?php } ?>
    
    <?php if ($this->session->userdata('logged_in')) { // If user is logged in ?>
    
        <li class="fright mar-none">
            <a href="<?php echo site_url('site/logout'); ?>">
                <img src="<?php echo theme_url(); ?>img/nav-auth.png" alt="logout" />
                Έξοδος
            </a>
        </li>
    
        <?php if ($this->session->userdata('access') == 1) { // If admin is logged in ?>

            <li class="fright">
                <a href="<?php echo site_url('admin/news/index/manage'); ?>" <?php if ($section == 'admin') echo 'class="active"'; ?>>
                    <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
                    <img src="<?php echo theme_url(); ?>img/nav-user-panel.png" alt="user-panel" />
                    Διαχείριση
                </a>
            </li>

        <?php } else if ($this->session->userdata('access') == 2) { // If a professor is logged in ?>

            <li class="fright">
                <a href="<?php echo site_url('professor/thesis'); ?>" <?php if ($section == 'professor') echo 'class="active"'; ?>>
                    <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
                    <img src="<?php echo theme_url(); ?>img/nav-user-panel.png" alt="user-panel" />
                    Πάνελ
                </a>
            </li>

        <?php } else if ($this->session->userdata('access') == 3) { // If a student is logged in ?>

            <li class="fright">
                <a href="<?php echo site_url('student/requests'); ?>" <?php if ($section == 'student') echo 'class="active"'; ?>>
                    <img src="<?php echo theme_url(); ?>img/nav-active.png" alt="arrow" class="arrow" />
                    <img src="<?php echo theme_url(); ?>img/nav-user-panel.png" alt="user-panel" />
                    Πάνελ
                </a>
            </li>
            
        <?php } ?>
        
    <?php } ?>
</ul>
<!-- END Navigation -->

<!-- Content -->
<div id="content"<?php if ( isset( $enable_sidebar ) ) { if ( $enable_sidebar == TRUE ) echo ' class="enable_sidebar clearfix"'; } ?>>