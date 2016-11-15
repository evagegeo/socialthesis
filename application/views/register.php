<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header'); ?>

<!-- Login Content -->

<div class="center-con">

    <h3 class="tcenter">Εγγραφή</h3>

    <div class="body-con">

        <?php if ( $this->uri->segment(4) == 'adduserok' ) { ?>
        <div class="msg-ok tcenter"><p>Ο λογαριασμός σας δημιουργήθηκε με επιτυχία! Μπορείτε να συνδεθείτε.</p></div>
        <?php } else if ( $this->uri->segment(4) == 'addstudentok' ) { ?>
        <div class="msg-ok tcenter"><p>Ο λογαριασμός σας δημιουργήθηκε με επιτυχία!</p><p>Θα πρέπει όμως να περιμένετε μέχρι να εγκριθεί πριν μπορέσετε να συνδεθείτε.</p></div>
        <?php } else { ?>
        
            <?php if (isset($error)) echo "<div class=\"msg-error\">{$error}</div>"; ?>

            <?php echo validation_errors(); ?>

            <?php echo form_open('site/register'); ?>

            <ul class="align-list label-large">
                <li>
                    <label for="register_username">Ψευδώνυμο</label>
                    <input type="text" name="register_username" id="register_username" maxlength="15" value="<?php echo set_value('register_username'); ?>" />
                </li>
                <li>
                     <label for="register_password">Κωδικός</label>
                    <input type="password" name="register_password" id="register_password" maxlength="15" />
                </li>
                <li>
                     <label for="register_password2">Επιβεβαίωση Κωδικού</label>
                    <input type="password" name="register_password2" id="register_password2" maxlength="15" />
                </li>
                <li>
                    <label for="register_email">Email</label>
                    <input type="text" name="register_email" id="register_email" maxlength="128" value="<?php echo set_value('register_email'); ?>" />
                </li>
                <li>
                    <label for="register_firstname">Όνομα</label>
                    <input type="text" name="register_firstname" id="register_firstname" maxlength="50" value="<?php echo set_value('register_firstname'); ?>" />
                </li>
                <li>
                    <label for="register_lastname">Επώνυμο</label>
                    <input type="text" name="register_lastname" id="register_lastname" maxlength="50" value="<?php echo set_value('register_lastname'); ?>" />
                </li>
                <li>
                    <div class="msg-info tcenter">Αν είστε φοιτητής και θέλετε να κάνετε αιτήσεις για διπλωματικές επιλέξτε λογαριασμό φοιτητή.</div>
                    <label for="register_access">Λογαριασμός Φοιτητή;</label>
                    <input type="checkbox" id="register_access" name="register_access" value="3" <?php echo set_checkbox('register_access', 3); ?> /> 
                </li>
                <?php if ( ENVIRONMENT == 'production') { ?>
                <li>
                    <label></label>
                    Captcha!
                </li>
                <?php } ?>
                <li>
                    <label></label>
                    <input type="submit" value="Εγγραφή" name="register_button" id="register_button" />
                </li>
            </ul>

            <?php echo form_close(); ?>
        
        <?php } ?>

    </div>

</div>

<!-- END Login Content -->

<?php $this->load->view('inc/footer'); ?>