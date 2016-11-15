<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Main -->
<div id="main">

	<table>
		<thead>
			<tr>
				<th class="tcenter">Επιβλέπων</th>
				<th class="tcenter">Email</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="tcenter">
					<a href="<?php echo site_url(); ?>/professor/profile/index/<?php echo $professor['id']; ?>" class="tipt tbold" title="<?php if ($professor['photo']) { ?><img src='<?php echo base_url(); ?>uploads/photos/<?php echo $professor['photo']; ?>' alt='photo_<?php echo $professor['id']; ?>' /><? } else { ?><img src='<?php echo theme_url(); ?>img/nophoto.png' width='100' height='100' alt='nophoto' /><?php } ?>">
						<?php echo $professor['firstname'].' '.$professor['lastname'].' ('.$professor['professor_attr'].')';?>
					</a>
				</td>
				<td class="tcenter">
					<a href="mailto:<?php echo $professor['email']; ?>" class="tipt" title="Αποστολή email">
						<img src="<?php echo theme_url(); ?>img/icon-newmail.png" alt="email" />
					</a>
				</td>
			</tr>
		</tbody>
	</table>

	<h2 class="tleft"><?php echo $thesis['title']; ?></h2>
	<p><?php echo $thesis['content']; ?></p>

	<h2 class="tleft">Αποστολή διπλωματικής</h2>

	<?php if ($thesis['zipfile']) { ?>

		<div class="msg-ok">Έχετε αποστείλει με επιτυχία τη διπλωματική σας!</div>
		<table>
			<thead>
				<tr>
					<th class="tcenter">Μεταφόρτωση αρχείου</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="tcenter">
						<a href="<?php echo base_url(); ?>uploads/thesis/<?php echo $thesis['zipfile']; ?>">
							<img src="<?php echo theme_url(); ?>img/icon-download.png" alt="download" />
						</a>
					</td>
				</tr>
			</tbody>
		</table>

	<?php } else { ?>

		<?php echo form_open_multipart('student/thesis'); ?>

		<?php if ($this->uri->segment(4) == 'add_zipfile_ok') echo '<div class="msg-ok">Έχετε αποστείλει με επιτυχία τη διπλωματική σας!</div>'; ?>
		<?php if (isset($error_zipfile)) echo "<div class=\"msg-error\">{$error_zipfile}</div>"; ?>

		<div class="msg-info">Ανέβασμα συμπιεσμένου αρχείου τύπου <strong>zip</strong> και μέγιστου μεγέθους <strong>10MB</strong>. Το αρχείο πρέπει να περιλαμβάνει όλα τα απαραίτητα έγγραφα και αρχεία της διπλωματικής.</div>

		<label for="photo">Επιλογή αρχείου</label>
		<input type="file" name="zipfile" id="zipfile" />

		<input type="submit" value="Ανέβασμα αρχείου" name="zipfile_button" id="zipfile_button" onclick="return confirm('Είστε σίγουροι για την αποστολή της διπλωματικής; Δε θα μπορείτε να την ενημερώσετε μετά από την αποστολή!')" />

		<?php echo form_close(); ?>

	<?php } ?>

</div>
<!-- END Main -->

<?php $this->load->view('inc/footer'); ?>