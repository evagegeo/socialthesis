<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Main -->
<div id="main">

    <?php if ($this->uri->segment(4) == 'update_ok') echo '<div class="msg-ok">Η ενημέρωση πραγματοποιήθηκε με επιτυχία!</div>'; ?>
    <?php if (isset($error)) echo "<div class=\"msg-error\">{$error}</div>"; ?>

    <?php echo form_open('admin/page'); ?>

    <h3>Meta πληροφορίες</h3>
    
    <div class="body-con">
        
        <ul class="align-list">
            <li>
                <label for="page_title">Τίτλος σελίδας</label>
                <input type="text" name="page_title" id="page_title" value="<?php echo set_value('page_title', $page_title); ?>" />
            </li>
            <li>
                <label for="page_description">Περιγραφή</label>
                <textarea name="page_description" id="page_description" class="box-large" cols="30" rows="5"><?php echo set_value('page_description', $page_description); ?></textarea>
            </li>
            <li>
                <label for="page_keywords">Λέξεις κλειδιά</label>
                <input type="text" name="page_keywords" id="page_keywords" value="<?php echo set_value('page_keywords', $page_keywords); ?>" />
            </li>
            <li>
                <label for="page_robots">Ρομπότ</label>
                <input type="text" name="page_robots" id="page_robots" value="<?php echo set_value('page_robots', $page_robots); ?>" />
            </li>
        </ul>
        
    </div>

    <h3>Γενικά</h3>
    
    <div class="body-con">
        
        <ul class="align-list">
            <li>
                <label for="page_footer">Κείμενο footer</label>
                <input type="text" name="page_footer" id="page_footer" value="<?php echo set_value('page_footer', $page_footer); ?>" />
            </li>
        </ul>
    
    </div>

    <h3>Επιλογή θέματος</h3>
    
    <div class="body-con">
        
        <ul class="align-list">
            <li>
                <label for="page_theme">Όνομα θέματος</label>
                <select name="page_theme">
                    <?php foreach ($themenames as $themename) { ?>
                    <option <?php if ($theme == $themename) echo 'selected="selected"'; ?>><?php echo $themename; ?></option>
                    <?php } ?>
                </select>
            </li>
        </ul>
        
    </div>
    
    <div class="body-con-alone">
        <label></label>
        <input type="submit" value="Ενημέρωση" name="page_button" id="page_button" />
    </div>
        
    <?php echo form_close(); ?>

</div>
<!-- END Main -->

<?php $this->load->view('inc/footer'); ?>