<?php $this->load->view('inc/top'); ?>

<?php if ($this->session->userdata('logged_in') && isset($suggestion)) { ?>
<script>    
    function star_update(content_id, mode)
	{
		var star = $('#fav_status');
        
        $('#ajax-loading').fadeIn();

		star.load('<?php echo site_url(); ?>/site/suggestions/ajax', {mode: mode, content_id: content_id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(){  
            
            if ( mode == 'star' )
                $(this).html('<a href="#" onclick="return star_update( ' + content_id + ', \'unstar\');"><img src="<?php echo theme_url(); ?>img/star.png" width="20" height="20" alt="favorite" /></a>');
            else if ( mode == 'unstar')
                $(this).html('<a href="#" onclick="return star_update( ' + content_id + ', \'star\');"><img src="<?php echo theme_url(); ?>img/star_off.png" width="20" height="20" alt="favorite" /></a>');

            $(this).fadeIn(500);
            $('#ajax-loading').fadeOut();
		});

		return false;
	}
</script>
<?php } ?>

<?php 
if ( isset($suggestion) )
    $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) );
else
    $this->load->view('inc/header');
?>

<!-- Suggestions Content -->

<?php if ( isset($suggestion) ) { ?>

    <div id="sidebar">
        
        <div id="profile-image" class="tcenter">
            <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
            <?php if ($suggestion['uphoto']) { ?>
            <img src="<?php echo base_url(); ?>uploads/photos/<?php echo $suggestion['uphoto']; ?>" width="100" height="100" alt="photo" />
            <?php } else { ?>
            <img src="<?php echo theme_url(); ?>img/nophoto.png" width="100" height="100" alt="nophoto" />
            <?php } ?>
        </div>
        
        <p class="tcenter">
            <?php if ($suggestion['uaccess'] == 2) { // If professor ?>
                <a href="<?php echo site_url("professor/profile/index/".$suggestion['author_id'].""); ?>"><?php echo $suggestion['firstname'].' '.$suggestion['lastname']; ?></a>
            <?php } else { echo '<strong>'.$suggestion['firstname'].' '.$suggestion['lastname'].'</strong>'; } ?>
            <br/>
            (<?php echo $suggestion['author']; ?>)
        </p>
        
        <h3 class="mar-left tcenter">Επικοινωνία με το χρήστη</h3>
        <?php echo form_open('', 'onsubmit="return false;" class="mar-left"'); ?>
        <textarea name="msg" id="msg" rows="5" cols="25" class="box-auto"></textarea>
        <P class="tcenter"><input type="submit" value="Αποστολή" name="btn" id="btn" /></p>
        <?php echo form_close(); ?>
        
    </div>

    <div id="main">
        
        <h3>
            <?php if ($this->session->userdata('logged_in')) { ?>
            <div id="fav_status" class="extra">
                <?php if ( $this->db->get_where('favorites', array( 'user_id' => $this->session->userdata('id'), 'content_id' => $suggestion['id'], 'category' => 2))->num_rows() ) { ?>
                <a href="#" onclick="return star_update( <?php echo $suggestion['id']; ?>, 'unstar');"><img src="<?php echo theme_url(); ?>img/star.png" width="20" height="20" alt="favorite" /></a>
                <?php } else { ?>
                <a href="#" onclick="return star_update( <?php echo $suggestion['id']; ?>, 'star');"><img src="<?php echo theme_url(); ?>img/star_off.png" width="20" height="20" alt="favorite" /></a>
                <?php } ?>
            </div>
            <?php } ?>
            <div class="published"><?php echo $suggestion['published']; ?></div>
            <?php echo $suggestion['title']; ?>
        </h3>
        <div class="body-con"><?php echo $suggestion['content']; ?></div>

        <h3>Συζήτηση</h3>
        <div id="comments-con" class="body-con">
            
            <?php if ($comments->num_rows() > 0) { ?>
                
                <?php foreach($comments->result_array() as $com) { ?>
                    
                    <div id="com_<?php echo $com['id']; ?>" class="comment-con clearfix">
                        <div class="info">
                            <img src="<?php echo theme_url()."img/user-nav-active.png"; ?>" class="arrow" alt="arrow" />
                            <?php if ( $com['uphoto'] ) { ?>
                                <img src="<?php echo base_url()."uploads/photos/".$com['uphoto']; ?>" alt="photo" class="photo" width="40" height="40" />
                            <?php } else { ?>
                                <img src="<?php echo theme_url()."img/nophoto.png"; ?>" alt="photo" width="40" height="40" />
                            <?php } ?>
                            <?php if ($com['uaccess'] == 2) { // If professor ?>
                                <a href="<?php echo site_url("professor/profile/index/".$com['author_id'].""); ?>"><?php echo $com['author']; ?></a>
                            <?php } else { echo '<strong>'.$com['author'].'</strong>'; } ?><br/>
                            <?php echo $com['published']; ?>
                        </div>
                        <div class="content"><?php echo $com['content']; ?></div>
                    </div>
            
                <?php } ?>
            
            <?php } else { ?>
                <div class="msg-info">Δεν υπάρχουν ακόμη σχόλια!</div>
            <?php } ?>
                
            <?php if ($this->session->userdata('logged_in')) { ?>
                
                <?php if ($this->uri->segment(5) == 'add_ok') echo '<div class="msg-ok">To σχόλιο προστέθηκε με επιτυχία!</div>'; ?>
                <?php if (isset($error)) echo "<div class=\"msg-error\">{$error}</div>"; ?>

                <?php echo validation_errors(); ?>
                
                <?php echo form_open('site/suggestions/view/'.$suggestion['id'].'#add_comment', 'id="add_comment"'); ?>
                    
                    <ul class="align-list">
                        <li>
                            <textarea name="content" id="content" rows="4" cols="20" class="box-large"></textarea>
                        </li>
                        <li>
                            <input type="submit" value="Προσθήκη σχολίου" name="add_button" id="add_button" />
                        </li>
                    </ul>
                
                <?php echo form_close(); ?>
                
            <?php } ?>
            
        </div>
        
    </div>

<?php } else { ?>

    <?php if ($this->session->userdata('logged_in')) { $segm = $this->uri->segment(4); ?>
    <ul class="content-tabs-alone clearfix">
        <li><a href="<?php echo site_url(); ?>/site/suggestions/" <?php if ( empty( $segm ) || is_numeric( $segm ) ) echo 'class="active"'; ?>>Τελευταίες προτάσεις</a></li>
        <li><a href="<?php echo site_url(); ?>/site/suggestions/mode/pop" <?php if ($segm == 'pop') echo 'class="active"'; ?>>Πιο δημοφιλείς</a></li>
        <li><a href="<?php echo site_url(); ?>/site/suggestions/mode/my" <?php if ($segm == 'my') echo 'class="active"'; ?>>Οι δικές μου προτάσεις</a></li>
        <li><a href="<?php echo site_url(); ?>/site/suggestions/mode/fav" <?php if ($segm == 'fav') echo 'class="active"'; ?>>Αγαπημένες προτάσεις</a></li>
    </ul>
    <?php } ?>

    <?php if ($suggestions->num_rows() > 0) { ?>

        <div id="out-con" class="clearfix">

            <?php $i = 1; ?>

            <?php foreach($suggestions->result_array() as $suggestion) { ?>

            <div class="content-con <?php if ( ! ($i % 2) ) echo 'sug-left '; ?> clearfix">
                <div class="info">
                    <img src="<?php echo theme_url()."img/user-nav-active.png"; ?>" class="arrow" alt="arrow" />
                    <?php if ( $suggestion['uphoto'] ) { ?>
                        <img src="<?php echo base_url()."uploads/photos/".$suggestion['uphoto']; ?>" alt="photo" width="80" height="80" />
                    <?php } else { ?>
                        <img src="<?php echo theme_url()."img/nophoto.png"; ?>" alt="photo" width="80" height="80" />
                    <?php } ?>
                    <?php if ($suggestion['uaccess'] == 2) { // If professor ?>
                        <a href="<?php echo site_url("professor/profile/index/".$suggestion['author_id'].""); ?>"><?php echo $suggestion['author']; ?></a>
                    <?php } else { echo '<strong>'.$suggestion['author'].'</strong>'; } ?><br/>
                    <?php echo $suggestion['published']; ?>
                </div>
                <div class="content">
                    <a href="<?php echo site_url(); ?>/site/suggestions/view/<?php echo $suggestion['id']; ?>" class="sug-title"><?php echo $suggestion['title']; ?></a>
                    <p><?php echo substr($suggestion['content'], 0, 250); ?><a href="<?php echo site_url(); ?>/site/suggestions/view/<?php echo $suggestion['id']; ?>">...</a></p>
                </div>
                <div class="com-star titalic">Σχόλια: <strong><?php echo $this->db->from('comments')->where( array( 'view' => 1, 'category' => 2, 'content_id' => $suggestion['id']) )->count_all_results(); ?></strong>, Επισημάνσεις: <strong><?php echo $this->db->from('favorites')->where( array( 'category' => 2, 'content_id' => $suggestion['id']) )->count_all_results(); ?></strong></div>
            </div>

            <?php $i++; } ?>

        </div>

    <?php if ( $this->uri->segment(3) != 'mode' ) echo $this->pagination->create_links(); ?>

    <?php } else { ?>

        <div class="msg-info">Δεν βρέθηκαν προτάσεις διπλωματικών!</div>

    <?php } ?>

    <?php if ($this->session->userdata('logged_in')) { ?>

        <h3 id="add_suggestion">Καταχώρηση πρότασης για θέμα διπλωματικής</h3>

        <div class="body-con">

            <?php if (isset($error)) echo "<div class=\"msg-error\">{$error}</div>"; ?>
            <?php if ( $this->uri->segment(4) == 'add_ok' ) echo "<div class=\"msg-ok\">Η πρόταση καταχωρήθηκε με επιτυχία!</div>"; ?>

            <?php echo validation_errors(); ?>

            <?php echo form_open('site/suggestions#add_suggestion'); ?>

                <ul class="align-list">
                    <li>
                        <label for="title">Τίτλος</label>
                        <input type="text" name="title" id="title" maxlength="256" class="box-large" value="<?php echo set_value('title'); ?>" />
                    </li>
                    <li>
                        <label for="content">Περιγραφή</label>
                        <textarea name="content" id="content" class="box-large" cols="80" rows="8"><?php echo set_value('content'); ?></textarea>
                    </li>
                    <li>
                        <label></label>
                        <input type="submit" value="Καταχώρηση πρότασης" name="add_button" id="add_button" />
                    </li>
                </ul>

            <?php echo form_close(); ?>

        </div>

    <?php } ?>
    
<?php } ?>

<!-- END Suggestions Content -->

<?php $this->load->view('inc/footer'); ?>