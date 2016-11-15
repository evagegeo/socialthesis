<?php $this->load->view('inc/top'); ?>

<script>
    $(function(){tabs($('.default'));});
    
    function user_status_update(user_id, mode)
	{
		var user_status = $('#status_' + user_id);
        
        $('#ajax-loading').stop( true, true).fadeIn();

		user_status.load('<?php echo site_url(); ?>/admin/users/ajax', {mode: mode, user_id: user_id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(){  
            
            if ( mode == 'activate' || mode == 'approve' )
                $(this).html('<a href="#" onclick="return user_status_update( ' + user_id + ', \'deactivate\' );"><img src="<?php echo theme_url(); ?>img/icon-active.png" alt="active" title="Ο λογαριασμός είναι ενεργός, κλικ για απενεργοποίηση!" /></a>');
            else if ( mode == 'deactivate')
                $(this).html('<a href="#" onclick="return user_status_update( ' + user_id + ', \'activate\' );"><img src="<?php echo theme_url(); ?>img/icon-inactive.png" alt="inactive" title="Ο λογαριασμός είναι ανενεργός, κλικ για ενεργοποίηση!" /></a>');

            $(this).fadeIn(500);
            $('#ajax-loading').stop( true, true).fadeOut();
		});

		return false;
	}
</script>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Main -->
<div id="main">

    <ul class="content-tabs clearfix">
        <li><a rel="tab1" <?php if ($this->uri->segment(4) == 'manage') echo 'class="default"'; ?>>Διαχείριση χρηστών</a></li>
        <li><a rel="tab2" <?php if ($this->uri->segment(4) == 'add') echo 'class="default"'; ?>>Προσθήκη χρήστη</a></li>

        <?php if ($this->uri->segment(4) == 'edit') { ?>
        <li><a rel="tab3" class="default">Επεξεργασία <?php echo $edituser['username']; ?></a></li>
        <?php } ?>

        <div class="clear"></div>
    </ul>

    <!-- Tab1 - Manage users -->
    <div id="tab1" class="istab">

		<?php if ($users->num_rows() > 0) { ?>
			<table>
				<thead>
					<tr>
						<th>Ψευδώνυμο</th>
						<th>Ηλεκτρονική διεύθυνση</th>
						<th>Όνομα</th>
						<th>Επώνυμο</th>
						<th>Ιδιότητα</th>
						<th class="tcenter">Επεξεργασία</th>
                        <th>Κατάσταση</th>
					</tr>
				</thead>
				<tbody>
                <?php foreach($users->result_array() as $user) { ?>

                <tr>
                    <td class="tleft backcolor">
						<?php if ($user['access'] == 2)  { ?>

						<a href="<?php echo site_url('professor/profile/index/'.$user['id'].''); ?>"><?php echo $user['username']; ?></a>

						<?php } else echo $user['username']; ?>	
					</td>
                    <td class="tleft"><?php echo $user['email']; ?></td>
                    <td class="tleft"><?php echo $user['firstname']; ?></td>
                    <td class="tleft"><?php echo $user['lastname']; ?></td>
                    <td>
                        <?php 
                        if ($user['access'] == 1)
                            echo '<span class="tred">Διαχειριστής</span>';
                        else if ($user['access'] == 2)
                            echo '<span class="tgreen">Καθηγητής</span>';
                        else if ($user['access'] == 3)
                            echo 'Φοιτητής';
                        else if ($user['access'] == 4)
                            echo '<span class="tgrey">Χρήστης</span>';
                        ?>
                    </td>
                    <td class="tcenter">
                        <a href="<?php echo site_url("admin/users/index/edit/".$user['id'].""); ?>">
                            <img src="<?php echo theme_url(); ?>img/icon-edit.png" alt="edit" class="tipt" title="Επεξεργασία <?php echo $user['username']; ?>" />
                        </a>
                    </td>
                    <td id="status_<?php echo $user['id']; ?>">
                        <?php if ($user['activated'] == 1) { ?>
                        <a href="#" onclick="return user_status_update(<?php echo $user['id']; ?>, 'deactivate');">
                            <img src="<?php echo theme_url(); ?>img/icon-active.png" alt="active" title="Ο λογαριασμός είναι ενεργός, κλικ για απενεργοποίηση!" />
                        </a>
                        <?php } else if ($user['activated'] == 2) { ?>
                        <a href="#" onclick="return user_status_update(<?php echo $user['id']; ?>, 'approve');">
                            <img src="<?php echo theme_url(); ?>img/icon-waiting.png" alt="waiting" title="Ο λογαριασμός είναι προς έγκριση, κλικ για ενεργοποίηση!" />
                        </a>
                        <?php } else { ?>
                        <a href="#" onclick="return user_status_update(<?php echo $user['id']; ?>, 'activate');">
                            <img src="<?php echo theme_url(); ?>img/icon-inactive.png" alt="inactive" title="Ο λογαριασμός είναι ανενεργός, κλικ για ενεργοποίηση!" />
                        </a>
                        <?php } ?>
                    </td>
                </tr>

                <?php } ?>

                <?php } else { ?>
                    <div class="msg-info">Κανένας χρήστης!</div>
                <?php } ?>

            </tbody>
        </table>

        <?php echo $this->pagination->create_links(); ?>

    </div>

    <!-- Tab2 - Add user -->
    <div id="tab2" class="istab body-con">
        
        <?php if ($this->uri->segment(5) == 'add_ok') echo '<div class="msg-ok">Ο χρήστης προστέθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error_add)) echo "<div class=\"msg-error\">{$error_add}</div>"; ?>

		<?php echo validation_errors(); ?>

        <?php echo form_open('admin/users/index/add#tabs'); ?>
        
        <ul class="align-list labels-large">
            <li>
                <label for="user_username">Ψευδώνυμο</label>
                <input type="text" name="user_username" id="user_username" maxlength="15" value="<?php echo set_value('user_username'); ?>" />
            </li>
            <li>
                <label for="user_password">Κωδικός</label>
                <input type="password" name="user_password" id="user_password" maxlength="15" value="<?php echo set_value('user_password'); ?>" />
            </li>
            <li>
                <label for="user_email">Email</label>
                <input type="text" name="user_email" id="user_email" maxlength="128" value="<?php echo set_value('user_email'); ?>" />
            </li>
            <li>
                <label for="user_firstname">Όνομα</label>
                <input type="text" name="user_firstname" id="user_firstname" maxlength="50" value="<?php echo set_value('user_firstname'); ?>" />
            </li>
            <li>
                <label for="user_lastname">Επώνυμο</label>
                <input type="text" name="user_lastname" id="user_lastname" maxlength="50" value="<?php echo set_value('user_lastname'); ?>" />
            </li>
            <li>
                <label for="user_access">Ιδιότητα</label>
                <select name="user_access" id="user_access" size="1">
                    <option value="4">Χρήστης</option>
                    <option value="3">Φοιτητής</option>
                    <option value="2">Καθηγητής</option>
                    <option value="1" class="tred">Διαχειριστής</option>
                </select>
            </li>
            <li>
                <label></label>
                <input type="submit" value="Προσθήκη χρήστη" name="adduser_button" id="adduser_button" />
            </li>
        </ul>

        <?php echo form_close(); ?>

    </div>

    <?php if ($this->uri->segment(4) == 'edit') { ?>

    <!-- Tab3 - Edit user -->
    <div id="tab3" class="istab body-con">
        
        <?php if ($this->uri->segment(6) == 'edit_ok') echo '<div class="msg-ok">Ο χρήστης ενημερώθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error_edit)) echo "<div class=\"msg-error\">{$error_edit}</div>"; ?>

        <?php echo validation_errors(); ?>

        <?php echo form_open("admin/users/index/edit/".$this->uri->segment(5)."#tabs"); ?>
        
        <ul class="align-list labels-large">
            <li>
                <label for="edit_username">Ψευδώνυμο</label>
                <input type="text" name="edit_username" id="edit_username" maxlength="15" value="<?php echo set_value('edit_username', $edituser['username']); ?>" />
            </li>
            <li>
                <label for="edit_password">Κωδικός (συμπλήρωση για αλλαγή)</label>
                <input type="password" name="edit_password" id="edit_password" maxlength="15" value="<?php echo set_value('edit_password'); ?>" />
            </li>
            <li>
                <label for="edit_email">Email</label>
                <input type="text" name="edit_email" id="edit_email" maxlength="128" value="<?php echo set_value('edit_email', $edituser['email']); ?>" />
            </li>
            <li>
                <label for="edit_firstname">Όνομα</label>
                <input type="text" name="edit_firstname" id="edit_firstname" maxlength="50" value="<?php echo set_value('edit_firstname', $edituser['firstname']); ?>" />
            </li>
            <li>
                <label for="edit_lastname">Επώνυμο</label>
                <input type="text" name="edit_lastname" id="edit_lastname" maxlength="50" value="<?php echo set_value('edit_lastname', $edituser['lastname']); ?>" />
            </li>
            <li>
                <label for="edit_access">Ιδιότητα</label>
                <select name="edit_access" id="edit_access" size="1">
                    <option value="4">Χρήστης</option>
                    <option value="3"<?php if ($edituser['access'] == 3) echo 'selected="selected"'; ?>>Φοιτητής</option>
                    <option value="2"<?php if ($edituser['access'] == 2) echo 'selected="selected"'; ?>>Καθηγητής</option>
                    <option value="1" class="tred"<?php if ($edituser['access'] == 1) echo 'selected="selected"'; ?>>Διαχειριστής</option>
                </select>
                <span class="msg-form-error">Ιδιαίτερη προσοχή όταν αλλάζονται ρόλοι!</span>
            </li>
            <li>
                <label></label>
                <input type="submit" value="Ενημέρωση" name="edituser_button" id="edituser_button" />
            </li>
        </ul>

        <?php echo form_close(); ?>

    </div>

    <?php } ?>

</div>
<!-- END Main -->

<?php $this->load->view('inc/footer'); ?>