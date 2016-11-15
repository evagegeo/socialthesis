<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<!-- Sidebar -->
<div id="sidebar">
    
    <div id="profile-image" class="tcenter">
        <img src="<?php echo theme_url(); ?>img/user-nav-active.png" alt="arrow" class="arrow" />
        <?php if ($userdata['photo']) { ?>
        <img src="<?php echo base_url(); ?>uploads/photos/<?php echo $userdata['photo']; ?>" width="100" height="100" alt="photo" />
        <?php } else { ?>
        <img src="<?php echo theme_url(); ?>img/nophoto.png" width="100" height="100" alt="nophoto" />
        <?php } ?>
        
        <table>
            <tr>
                <td><?php echo $userdata['email']; ?></td>
            </tr>
            <?php if ($userdata['address']) { ?>
            <tr>
                <td><?php echo $userdata['address']; ?></td>
            </tr>
            <?php } ?>
            <?php if ($userdata['phone']) { ?>
            <tr>
                <td><?php echo $userdata['phone']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    
</div>
<!-- END Sidebar -->

<!-- Main -->
<div id="main">
    
    <h3>
        <?php echo $userdata['firstname'].' '.$userdata['lastname']; if ($userdata['professor_attr']) echo ' - '.$userdata['professor_attr']; ?>
        <span class="fright"><?php $dir = $this->mdirs->get($userdata['professor_dir_id']); if (isset($dir['title'])) echo $dir['title']; ?></span>
    </h3>
    
    <div class="body-con">
        <?php if ($userdata['professor_bio']) echo $userdata['professor_bio']; else echo 'Δεν έχει συμπληρωθεί βιογραφικό!'; ?>
    </div>

</div>
<!-- END main -->

<?php $this->load->view('inc/footer'); ?>