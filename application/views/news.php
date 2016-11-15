<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header'); ?>

<!-- News Content -->

<?php if ($news->num_rows() > 0) { ?>

    <?php foreach($news->result_array() as $new) { ?>

    <h3 class="tleft"><span class="published"><?php echo 'από <strong>'.$new['author'].'</strong> στις '.$new['published']; ?></span><?php echo $new['title']; ?></h3>

    <div class="body-con"><?php echo $new['content']; ?></div>

<?php } ?>

<?php echo $this->pagination->create_links(); ?>

<?php } else { ?>

    <div class="msg-info">Κανένα νέο!</div>

<?php } ?>

<!-- END News Content -->

<?php $this->load->view('inc/footer'); ?>