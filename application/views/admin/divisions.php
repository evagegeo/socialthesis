<?php $this->load->view('inc/top'); ?>

<script>
    function edit(dir_id)
	{
		$('#edit_' + dir_id).hide();

		var dircon = $('#dir_' + dir_id);
		var content = dircon.html();

		dircon.html('<form><input type="text" name="title_' + dir_id + '" id="title_' + dir_id + '" maxlength="256" value="' + content + '" /><input type="submit" value="Ενημέρωση" onclick="return update(' + dir_id + ')" /><input type="submit" value="Άκυρο" class="red" onclick="return cancel(' + dir_id + ', \'' + content + '\')" /></form>')

		return false;
	}

	function update(dir_id)
	{
		var dircon = $('#dir_' + dir_id);
		var title = $('#title_' + dir_id).val();
        
        $('#ajax-loading').fadeIn();
        
		dircon.load('<?php echo site_url(); ?>/admin/divisions/update', {id: dir_id, title: title, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(){
            $('#edit_' + dir_id).show();
            $('#ajax-loading').fadeOut();
        });

		return false;
	}
    
    function cancel(dir_id, content)
	{
		$('#dir_' + dir_id).html( content );
        $('#edit_' + dir_id).show();

		return false;
	}
</script>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Main -->
<div id="main">
    
    <?php if ($this->uri->segment(4) == 'delete_ok') echo '<div class="msg-ok">Ο τομέας διαγράφηκε με επιτυχία!</div>'; ?>
    
	<table>
		<thead>
			<tr>
				<th class="tleft">Όνομα</th>
				<th class="tcenter">Επιλογές</th>
			</tr>
		</thead>
		<tbody>
		<?php if ($divisions) { ?>
			<?php foreach ($divisions as $dir) { ?>
				<tr>
					<td id="dir_<?php echo $dir['id']; ?>" class="tleft backcolor"><?php echo $dir['title']; ?></td>
					<td class="tcenter">
						<a id="edit_<?php echo $dir['id']; ?>" href="#" onclick="return edit(<?php echo $dir['id']; ?>);">
                            <img src="<?php echo theme_url(); ?>img/icon-edit.png" alt="edit" class="tipt" title="Επεξεργασία τομέα" />
                        </a>
						<a href="<?php echo site_url(); ?>/admin/divisions/delete/<?php echo $dir['id']; ?>" class="mar-left" onclick="return confirm('Εάν διαγράψετε τον τομέα θα αφαιρεθεί από κάθε καθηγητή και φοιτητή που ανήκει σε αυτόν! Θέλετε να προχωρήσετε;')">
                            <img src="<?php echo theme_url(); ?>img/icon-delete.png" alt="delete" class="tipt" title="Διαγραφή τομέα" />
                        </a>
					</td>
				</tr>
			<?php } ?>
		<?php } ?>
		</tbody>
	</table>

	<h3>Προσθήκη τομέα</h3>
    
    <div class="body-con">
        
        <?php if ($this->uri->segment(4) == 'add_ok') echo '<div class="msg-ok">Ο τομέας προστέθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error)) echo "<div class=\"msg-error\">{$error}</div>"; ?>

        <?php echo validation_errors(); ?>
        
        <?php echo form_open('admin/divisions'); ?>
        
        <ul class="align-list">
            <li>
                <label for="title">Όνομα τομέα</label>
                <input type="text" name="title" id="title" maxlength="256" value="<?php echo set_value('title'); ?>" />
            </li>
            <li>
                <label></label>
                <input type="submit" id="adddir_button" value="Προσθήκη τομέα" name="adddir_button" />
            </li>
        </ul>
        
        <?php echo form_close(); ?>
        
    </div>

</div>
<!-- END main -->

<?php $this->load->view('inc/footer'); ?>