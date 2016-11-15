<?php $this->load->view('inc/top'); ?>

<?php if ($this->session->userdata('logged_in') && isset($thesis)) { ?>
<script>    
    function star_update(content_id, mode)
	{
		var star = $('#fav_status');
        
        $('#ajax-loading').fadeIn();

		star.load('<?php echo site_url(); ?>/site/home/ajax', {mode: mode, content_id: content_id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(){  
            
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
if ( isset($thesis) )
    $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) );
else
    $this->load->view('inc/header');
?>

<!-- Homepage Content -->

<?php if ( isset($thesis) ) { ?>

    <div id="sidebar">
        
        <h3 class="mar-left tcenter">Φοιτητής</h3>
        
        <div id="profile-image" class="tcenter">
            <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
            <?php if ($thesis['uphoto']) { ?>
            <img src="<?php echo base_url(); ?>uploads/photos/<?php echo $thesis['uphoto']; ?>" width="100" height="100" alt="photo" />
            <?php } else { ?>
            <img src="<?php echo theme_url(); ?>img/nophoto.png" width="100" height="100" alt="nophoto" />
            <?php } ?>
        </div>
        
        <p class="tcenter">
            <strong><?php echo $thesis['firstname'].' '.$thesis['lastname']; ?></strong>
            <br/>
            (<?php echo $thesis['author']; ?>)
        </p>
        
        <h3 class="mar-left tcenter">Επικοινωνία με φοιτητή</h3>
        <?php echo form_open('', 'onsubmit="return false;" class="mar-left"'); ?>
        <ul class="align-list">
            <li><textarea name="msg" id="msg" rows="5" cols="25" class="box-auto"></textarea></li>
            <li class="tcenter"><input type="submit" value="Αποστολή" name="btn" id="btn" /></li>
        </ul>
        <?php echo form_close(); ?>
        
        <h3 class="mar-left tcenter">Υπεύθυνος Καθηγητής</h3>
        
        <div id="profile-image" class="tcenter">
            <?php if ($professor['photo']) { ?>
            <img src="<?php echo base_url(); ?>uploads/photos/<?php echo $professor['photo']; ?>" width="100" height="100" alt="photo" />
            <?php } else { ?>
            <img src="<?php echo theme_url(); ?>img/nophoto.png" width="100" height="100" alt="nophoto" />
            <?php } ?>
        </div>
        
        <p class="tcenter">
            <a href="<?php echo site_url("professor/profile/index/".$professor['id'].""); ?>"><?php echo $professor['firstname'].' '.$professor['lastname']; ?></a>
            <br/>
            (<?php echo $professor['username']; ?>)
        </p>
        
    </div>

    <div id="main">
        
        <h3>
            <?php if ($this->session->userdata('logged_in')) { ?>
            <div id="fav_status" class="extra">
                <?php if ( $this->db->get_where('favorites', array( 'user_id' => $this->session->userdata('id'), 'content_id' => $thesis['id'], 'category' => 1))->num_rows() ) { ?>
                <a href="#" onclick="return star_update( <?php echo $thesis['id']; ?>, 'unstar');"><img src="<?php echo theme_url(); ?>img/star.png" width="20" height="20" alt="favorite" /></a>
                <?php } else { ?>
                <a href="#" onclick="return star_update( <?php echo $thesis['id']; ?>, 'star');"><img src="<?php echo theme_url(); ?>img/star_off.png" width="20" height="20" alt="favorite" /></a>
                <?php } ?>
            </div>
            <?php } ?>
            <div class="published"><?php echo $thesis['published']; ?></div>
            <?php echo $thesis['title']; ?>
        </h3>
        
        <h3 class="tcenter">Περίληψη</h3>
        <div class="body-con">
            <?php echo $thesis['abstract']; ?>
            <?php if ( $thesis['file'] ) { ?>
            <p class="tcenter">
                <a href="#" onclick="return false;"><img src="<?php echo theme_url(); ?>img/icon-download.png" alt="file" class="tipt" title="Μεταφόρτωση αρχείου διπλωματικής" /></a>
            </p>
            <?php } ?>
            <?php if ( $thesis['link'] ) { ?>
            <p class="tcenter">
                <a href="<?php echo $thesis['link']; ?>" target="_blank"><?php echo $thesis['link']; ?></a>
            </p>
            <?php } ?>
        </div>

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
                
                <?php echo form_open('site/home/view/'.$thesis['id'].'#add_comment', 'id="add_comment"'); ?>
                    
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
        <li><a href="<?php echo site_url(); ?>/site/home/" <?php if ( empty( $segm ) || is_numeric( $segm ) ) echo 'class="active"'; ?>>Τελευταίες διπλωματικές</a></li>
        <li><a href="<?php echo site_url(); ?>/site/home/mode/pop" <?php if ($segm == 'pop') echo 'class="active"'; ?>>Πιο δημοφιλείς</a></li>
        <li><a href="<?php echo site_url(); ?>/site/home/mode/fav" <?php if ($segm == 'fav') echo 'class="active"'; ?>>Αγαπημένες διπλωματικές</a></li>
    </ul>
    <?php } ?>

    <?php if ($allthesis->num_rows() > 0) { ?>

        <div id="out-con" class="clearfix">

            <?php $i = 1; ?>

            <?php foreach($allthesis->result_array() as $thesis) { ?>

            <div class="content-con <?php if ( ! ($i % 2) ) echo 'sug-left '; ?> clearfix">
                <div class="info">
                    <img src="<?php echo theme_url()."img/user-nav-active.png"; ?>" class="arrow" alt="arrow" />
                    <?php if ( $thesis['uphoto'] ) { ?>
                        <img src="<?php echo base_url()."uploads/photos/".$thesis['uphoto']; ?>" alt="photo" width="80" height="80" />
                    <?php } else { ?>
                        <img src="<?php echo theme_url()."img/nophoto.png"; ?>" alt="photo" width="80" height="80" />
                    <?php } ?>
                    <strong><?php echo $thesis['author']; ?></strong><br/>
                    <?php echo $thesis['published']; ?>
                </div>
                <div class="content">
                    <a href="<?php echo site_url(); ?>/site/home/view/<?php echo $thesis['id']; ?>" class="sug-title"><?php echo $thesis['title']; ?></a>
                    <p><?php echo substr($thesis['abstract'], 0, 250); ?><a href="<?php echo site_url(); ?>/site/home/view/<?php echo $thesis['id']; ?>">...</a></p>
                </div>
                <div class="com-star titalic">Σχόλια: <strong><?php echo $this->db->from('comments')->where( array( 'view' => 1, 'category' => 1, 'content_id' => $thesis['id']) )->count_all_results(); ?></strong>, Επισημάνσεις: <strong><?php echo $this->db->from('favorites')->where( array( 'category' => 1, 'content_id' => $thesis['id']) )->count_all_results(); ?></strong></div>
            </div>

            <?php $i++; } ?>

        </div>

        <?php if ( $this->uri->segment(3) != 'mode' ) echo $this->pagination->create_links(); ?>

    <?php } else { ?>

        <div class="msg-info">Δεν βρέθηκαν διπλωματικές!</div>

    <?php } ?>
    
<?php } ?>

<!-- END Homepage Content -->

<?php $this->load->view('inc/footer'); ?>