<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Student Data Content -->
<div id="main">
    
    <!-- Photo -->
    <h3 id="photo">Φωτογραφία</h3>

    <div class="body-con">

        <?php if ($this->uri->segment(4) == 'delete_photo_ok') echo '<div class="msg-ok">Η φωτογραφία διαφράφτηκε με επιτυχία!</div>'; ?>
        <?php if ($this->uri->segment(4) == 'update_photo_ok') echo '<div class="msg-ok">Η ενημέρωση πραγματοποιήθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error_photo)) echo "<div class=\"msg-error\">{$error_photo}</div>"; ?>

        <?php if ($userdata['photo']) { ?>

            <?php echo form_open_multipart('student/data#photo'); ?>

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

            <?php echo form_open_multipart('student/data#photo'); ?>

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

    <!-- Student file with required data-->
    <h3 id="file">Αρχείο φοιτητή</h3>

    <div class="body-con">

        <?php if ($this->uri->segment(4) == 'delete_zipfile_ok') echo '<div class="msg-ok">Το αρχείο διαφράφτηκε με επιτυχία!</div>'; ?>
        <?php if ($this->uri->segment(4) == 'update_zipfile_ok') echo '<div class="msg-ok">Η ενημέρωση πραγματοποιήθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error_zipfile)) echo "<div class=\"msg-error\">{$error_zipfile}</div>"; ?>

        <?php if ($userdata['student_file']) { ?>

            <div class="tcenter">
                <a href="<?php echo base_url(); ?>uploads/files/<?php echo $userdata['student_file']; ?>">
                    <img src="<?php echo theme_url(); ?>img/icon-download.png" alt="download" class="tipt" title="Μεταφόρτωση αρχείου" />
                </a>
            </div>  

            <?php echo form_open_multipart('student/data#file'); ?>

            <ul class="align-list labels-large">
                <li>
                    <label for="zipfile">Επιλογή νέου αρχείου</label>
            <input type="file" name="zipfile" id="zipfile" />
                </li>
                <li>
                    <label></label>
                    <input type="submit" value="Ανέβασμα αρχείου" name="zipfile_button" id="zipfile_button" class="dis-inline-block" />
                    <input type="submit" value="Διαγραφή αρχείου" name="delete_zipfile_button" id="delete_zipfile_button" class="red dis-inline-block" />
                </li>
            </ul>

        <?php } else { ?>

            <div class="msg-info">Ανέβασμα συμπιεσμένου αρχείου τύπου <strong>zip</strong> και μέγιστου μεγέθους <strong>2MB</strong>. Το αρχείο πρέπει να περιλαμβάνει όλα τα απαραίτητα έγγραφα (αναλυτική βαθμολογία, βιογραφικό κτλ) που απαιτούνται για την αίτηση πτυχιακής. Θα συμπεριληφθει αυτόματα στην αίτηση.</div>

            <?php echo form_open_multipart('student/data#file'); ?>

            <ul class="align-list labels-large">
                <li>
                    <label for="zipfile">Επιλογή αρχείου</label>
                    <input type="file" name="zipfile" id="zipfile" />
                </li>
                <li>
                    <label></label>
                    <input type="submit" value="Ανέβασμα αρχείου" name="zipfile_button" id="zipfile_button" />
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
        <?php echo form_error('address'); ?>
        <?php echo form_error('phone'); ?>
        <?php echo form_error('student_aem'); ?>
        <?php echo form_error('student_year'); ?>
        <?php echo form_error('student_grade'); ?>
        <?php echo form_error('student_cleft'); ?>

        <?php echo form_open('student/data#data'); ?>

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
                <label for="address">Διεύθυνση</label>
                <input type="text" name="address" id="address" maxlength="256" value="<?php echo set_value('address', $userdata['address']); ?>" />
            </li>
            <li>
                <label for="phone">Τηλέφωνο</label>
                <input type="text" name="phone" id="phone" maxlength="15" value="<?php echo set_value('phone', $userdata['phone']); ?>" />
            </li>
            <li>
                <label for="student_aem">ΑΕΜ</label>
                <input type="text" name="student_aem" id="student_aem" maxlength="6" value="<?php echo set_value('student_aem', $userdata['student_aem']); ?>" />
            </li>
            <li>
                <label for="student_year">Έτος σπουδών</label>
                <input type="text" name="student_year" id="student_year" maxlength="2" value="<?php echo set_value('student_year', $userdata['student_year']); ?>" />
            </li>
            <li>
                <label for="student_grade">Βαθμολογία (μέσος όρος)</label>
                <input type="text" name="student_grade" id="student_grade" maxlength="5" value="<?php echo set_value('student_grade', $userdata['student_grade']); ?>" class="tipt" title="Χρήση τελείας για υποδιαστολή!" />
            </li>
            <li>
                <label for="student_cleft">Μαθήματα για λήψη πτυχίου</label>
                <input type="text" name="student_cleft" id="student_cleft" maxlength="2" value="<?php echo set_value('student_cleft', $userdata['student_cleft']); ?>" />
            </li>
            <li>
                <label for="student_dir_id">Τομέας</label>
                <select name="student_dir_id" id="student_dir_id" size="1">
                    <option value="0">Καμία</option>
                    <?php if ($divisions) { foreach ($divisions as $dir) { ?>
                        <option value="<?php echo $dir['id']; ?>"<?php if ($dir['id'] == $userdata['student_dir_id']) echo 'selected="selected"'; ?>><?php echo $dir['title']; ?></option>
                    <?php } } ?>
                </select>
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

        <?php echo form_open('student/data#pass'); ?>

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
<!-- END Student Data Content -->

<?php $this->load->view('inc/footer'); ?>