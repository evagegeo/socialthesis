<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header'); ?>

<!-- Archive View Content -->

<div class="profcon">
    <?php if ($professor['photo']) { ?>
        <img src="<?php echo base_url(); ?>uploads/photos/<?php echo $professor['photo']; ?>" width="100" height="100" alt="photo" />
    <?php } else { ?>
        <img src="<?php echo theme_url(); ?>img/nophoto.png" width="100" height="100" alt="photo" />
    <?php } ?>
    <a href="<?php echo site_url(); ?>/professor/profile/index/<?php echo $professor['id']; ?>" class="tbold">
        <?php echo $professor['firstname'].' '.$professor['lastname'].' ('.$professor['professor_attr'].')'; ?>
    </a>
</div>

<div class="allthesis-con">
    <?php foreach($allthesis->result_array() as $thesis) { ?>
        <h3 class="tleft"><?php echo $thesis['title']; ?></h3>
        <p class="thesis-desc"><?php echo $thesis['content']; ?></p>
    <?php } ?>
</div>
	
<!-- END Archive View Content -->

<?php $this->load->view('inc/footer'); ?>