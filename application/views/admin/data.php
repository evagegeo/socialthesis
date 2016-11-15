<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Admin Data Content -->
<div id="main">
    
    <!-- Photo -->
    <h3 id="photo">Φωτογραφία</h3>

    <div class="body-con">

        <?php if ($this->uri->segment(4) == 'delete_photo_ok') echo '<div class="msg-ok">Η φωτογραφία διαφράφτηκε με επιτυχία!</div>'; ?>
        <?php if ($this->uri->segment(4) == 'update_photo_ok') echo '<div class="msg-ok">Η ενημέρωση πραγματοποιήθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error_photo)) echo "<div class=\"msg-error\">{$error_photo}</div>"; ?>

        <?php if ($userdata['photo']) { ?>

            <?php echo form_open_multipart('admin/data#photo'); ?>

            <ul class="align-list labels-large">
                <li>
                    <label>Επιλεγμένη φωτογραφία</label>
                    <img src="<?php echo base_url(); ?>uploads/photos/<?php echo $userdata['photo']; ?>" alt="photo" class="ver-align-top" />
                </li>
                <li>
                    <label for="photo">Επιλογή νέας φωτογραφίας</label>
                    <input type="file" name="photo" id="photo" />
                </li>
                <li>
                    <label></label>
                    <input type="submit" value="Ανέβασμα φωτογραφίας" name="photo_button" id="photo_button" class="dis-inline-block" />
                    <input type="submit" value="Διαγραφή φωτογραφίας" name="delete_photo_button" id="delete_photo_button" class="red dis-inline-block" />
                </li>
            </ul>

        <?php } else { ?>

            <div class="msg-alert"><h5>Δεν έχετε επιλέξει κάποια φωτογραφία!</h5><p>Μπορείτε να ανεβάσετε μία με μέγιστο μέγεθος <strong>100KB</strong>, τύπου <strong>gif - jpg - jpeg - png</strong> και διαστάσεων μέχρι <strong>100x100 pixel</strong>.</p></div>

            <?php echo form_open_multipart('admin/data#photo'); ?>

            <ul class="align-list labels-large">
                <li>
                    <label for="photo">Επιλογή φωτογραφίας</label>
                    <input type="file" name="photo" id="photo" />
                </li>
                <li>
                    <label></label>
                    <input type="submit" value="Ανέβασμα φωτογραφίας" name="photo_button" id="photo_button" />
                </li>
            </ul>

        <?php } ?>

        <?php echo form_close(); ?>

    </div>
    
    <!-- Personal Data -->
    <h3 id="data">Προσωπικά στοιχεία</h3>

    <div class="body-con">

        <?php if ($this->uri->segment(4) == 'update_ok') echo '<div class="msg-ok">Η ενημέρωση πραγματοποιήθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error)) echo "<div class=\"msg-error\">{$error}</div>"; ?>

        <?php echo form_error('firstname'); ?>
        <?php echo form_error('lastname'); ?>
        <?php echo form_error('email'); ?>

        <?php echo form_open('admin/data#data'); ?>

        <ul class="align-list labels-large">
            <li>
                <label for="firstname">Όνομα</label>
                <input type="text" name="firstname" id="firstname" maxlength="50" value="<?php echo set_value('firstname', $userdata['firstname']); ?>" />
            </li>
            <li>
                <label for="lastname">Επώνυμο</label>
                <input type="text" name="lastname" id="lastname" maxlength="50" value="<?php echo set_value('lastname', $userdata['lastname']); ?>" />
            </li>
            <li>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" maxlength="128" value="<?php echo set_value('email', $userdata['email']); ?>" />
            </li>
            <li>
                <label></label>
                <input type="submit" value="Ενημέρωση στοιχείων" name="data_button" id="data_button" />
            </li>
        </ul>

        <?php echo form_close(); ?>

    </div>


    <!-- Password -->
    <h3 id="pass">Αλλαγή κωδικού</h3>

    <div class="body-con">

        <?php if ($this->uri->segment(4) == 'update_password_ok') echo '<div class="msg-ok">Η ενημέρωση πραγματοποιήθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error_2)) echo "<div class=\"msg-error\">{$error_2}</div>"; ?>

        <?php echo form_error('old_password'); ?>
        <?php echo form_error('new_password'); ?>
        <?php echo form_error('new_re_password'); ?>

        <?php echo form_open('admin/data#pass'); ?>

         <ul class="align-list labels-large">
            <li>
                <label for="old_password">Κωδικός</label>
                <input type="password" name="old_password" id="old_password" maxlength="15" value="<?php echo set_value('old_password'); ?>" />
            </li>
            <li>
                <label for="new_password">Νέος κωδικός</label>
                <input type="password" name="new_password" id="new_password" maxlength="15" value="<?php echo set_value('new_password'); ?>" />
            </li>
            <li>
                <label for="new_re_password">Επανάληψη νέου κωδικού</label>
                <input type="password" name="new_re_password" id="new_re_password" maxlength="15" value="<?php echo set_value('new_re_password'); ?>" />
            </li>
            <li>
                <label></label>
                <input type="submit" value="Ενημέρωση κωδικού" name="data_password_button" id="data_password_button" />
            </li>
        </ul>

        <?php echo form_close(); ?>

    </div>
    
</div>
<!-- Admin Data Content -->

<?php $this->load->view('inc/footer'); ?>