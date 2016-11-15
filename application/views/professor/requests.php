<?php $this->load->view('inc/top'); ?>

<script src="<?php echo inc_url(); ?>js/jquery.tablesorter.min.js"></script>

<script>
    $(function(){
		$('.sortable').tablesorter({
			headers: {
				7: { sorter: false },
				8: { sorter: false },
				9: { sorter: false }
			}
		});
	});
</script>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Main -->
<div id="main">
    
    <?php 
    if (strtotime(substr($set['end'], 6, 4).'-'.substr($set['end'], 3, 2).'-'.substr($set['end'], 0, 2)) < strtotime(date('Y-m-d')))
        $set_complete = TRUE;
    else
        $set_complete = FALSE;
    ?>
    
    <table>
		<thead>
			<tr>
				<th class="tcenter">Ακαδημαϊκό έτος</th>
				<th class="tcenter">Έναρξη αιτήσεων</th>
				<th class="tcenter">Λήξη αιτήσεων</th>
				<th class="tcenter">Διπλωματικές</th>
				<th class="tcenter">Αιτήσεις</th>
                <?php if ( $set['published'] == 1 ) { ?>
                <th class="tcenter">Κατάσταση</th>
                <?php } ?>
			</tr>
        </thead>
        <tbody>
            <tr>
                <td class="tcenter tbold"><?php echo $set['year'].'-'.substr(($set['year'] + 1), 2, 2); ?></td>
                <td class="tcenter tbold tgreen"><?php echo $set['start']; ?></td>
                <td class="tcenter tbold tred"><?php echo $set['end']; ?></td>
                <td class="tcenter">
                    <?php ($this->mthesis->getnum($set['id']) == '0') ? $btnclass = 'btn' : $btnclass = 'btn-blue'; ?>
                    <a href="<?php echo site_url("professor/thesis/edit/".$set['id'].""); ?>" class="tbold <?php echo $btnclass; ?>"><?php echo $this->mthesis->getnum($set['id']); ?></a>
                </td>
                <td class="tcenter">
                    <?php ($this->mreq->getnumreq($set['id']) == '0') ? $btnclass = 'btn' : $btnclass = 'btn-green'; ?>
                    <a href="<?php echo site_url("professor/thesis/requests/".$set['id'].""); ?>" class="tbold <?php echo $btnclass; ?>"><?php echo $this->mreq->getnumreq($set['id']); ?></a>
                </td>
                <?php if ( $set['published'] == 1 ) { ?>
                    <?php if ( ! $set_complete) { ?>
                    <td><img src="<?php echo theme_url(); ?>img/icon-active.png" alt="active" class="tipt" title="Δημοσιεύτηκε! Οι φοιτητές θα μπορέσουν να κάνουν αιτήσεις στο διάστημα που είναι ενεργή!" /></td>
                    <?php } else { ?>
                    <td><img src="<?php echo theme_url(); ?>img/icon-ok.png" alt="ok" class="tipt" title="Οι αιτήσεις σε αυτό το σετ ολοκληρώθηκαν!" /></td>
                    <?php } ?>
                <?php } ?>
            </tr>
        </tbody>
    </table>

	<?php if (isset($student) && $student) { ?>
	<a href="<?php echo site_url(); ?>/professor/thesis/requests/<?php echo $set_id; ?>/">Πίσω</a>
		<table>
			<thead>
				<tr>
					<th class="tleft">Όνομα</th>
					<th class="tcenter">ΑΕΜ</th>
					<th class="tcenter">Βαθμολογία</th>
					<th class="tcenter">Έτος</th>
					<th class="tcenter tipt" title="Μαθήματα που απομένουν για λήψη πτυχίου">Μαθήματα</th>
					<th class="tcenter">Τομέας</th>
					<th class="tcenter">Email</th>
					<th class="tcenter">Στοιχεία</th>
					<th class="tcenter">Αρχείo</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="tleft">
						<a href="<?php echo site_url(); ?>/professor/thesis/requests/<?php echo $this->uri->segment(4); ?>/<?php echo $student['id']; ?>" class="tipt tbold" title="<?php if ($student['photo']) { ?><img src='<?php echo base_url(); ?>uploads/photos/<?php echo $student['photo']; ?>' alt='photo_<?php echo $student['id']; ?>' /><? } else { ?><img src='<?php echo theme_url(); ?>img/nophoto.png' width='100' height='100' alt='nophoto' /><?php } ?>">
							<?php echo $student['firstname'].' '.$student['lastname']; ?>
						</a>
					</td>
					<td class="tcenter"><?php echo $student['student_aem']; ?></td>
					<td class="tcenter tbold"><?php echo $student['student_grade']; ?></td>
					<td class="tcenter tbold"><?php echo $student['student_year']; ?></td>
					<td class="tcenter"><?php echo $student['student_cleft']; ?></td>
					<td class="tcenter"><?php echo $this->mdirs->get($student['student_dir_id'], 'title'); ?></td>
					<td class="tcenter">
						<a href="mailto:<?php echo $student['email']; ?>">
							<img src="<?php echo theme_url(); ?>img/icon-newmail.png" alt="email_<?php echo $student['id']; ?>" class="tipt" title="Αποστολή email" />
						</a>
					</td>
					<td class="tcenter">
						<img src="<?php echo theme_url(); ?>img/icon-address.png" alt="address_<?php echo $student['id']; ?>" class="tipt" title="<?php echo $student['address']; ?><br/><br/>Τηλ: <?php echo $student['phone']; ?>" />
					</td>
					<td class="tcenter">
						<a href="<?php echo base_url(); ?>uploads/files/<?php echo $student['student_file']; ?>">
							<img src="<?php echo theme_url(); ?>img/icon-download.png" width="20" height="20" alt="file_<?php echo $student['id']; ?>" class="tipt" title="Μεταφόρτωση αρχείου" />
						</a>
					</td>
				</tr>
			</tbody>
		</table>
		<?php if ($allthesis->num_rows() > 0) { ?>
			<br/>
			<table>
				<thead>
					<tr>
						<th class="tcenter">Προτίμηση</th>
						<th class="tleft">Διπλωματική</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($allthesis->result_array() as $thesis) { ?>
					<tr>
						<td class="<?php if ($thesis['selected']) echo 'tdgreen '; ?> tcenter tbold"><?php echo $thesis['order']; ?></td>
						<td class="<?php if ($thesis['selected']) echo 'tdgreen '; ?>tleft"><?php echo $thesis['title']; ?></td>
					</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php } ?>
	<?php } else if (isset($requests) && $requests) { ?>

		<a href="<?php echo site_url(); ?>/professor/thesis/">Πίσω</a>
		
		<table>
			<thead>
				<tr>
					<th class="tcenter" colspan="3">Αιτήσεις: <?php echo $this->mreq->getnumreq($set_id); ?></th>
				</tr>
				<tr>
					<th class="tleft">Όνομα φοιτητή</th>
					<th class="tcenter">Έχει κάνει αίτηση αλλού;</th>
					<th class="tleft">Ανάθεση διπλωματικής</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$allstudents = $this->mreq->getstudentsset($set_id)->result_array();

				if ($allstudents) {
					foreach ($allstudents as $st) {
						$elsewhere = $this->db->where('student_id', $st['id'])->where('selected', '1')->where('set_id !=', $set_id)->get('requests')->row_array(); // Check if student has already taken a thesis elseware
				?>
				<tr>
					<td class="tleft">
						<a href="<?php echo site_url(); ?>/professor/thesis/requests/<?php echo $set_id; ?>/<?php echo $st['id']; ?>" class="tipt tbold" title="<?php if ($st['photo']) { ?><img src='<?php echo base_url(); ?>uploads/photos/<?php echo $st['photo']; ?>' alt='photo_<?php echo $st['id']; ?>' /><? } else { ?><img src='<?php echo theme_url(); ?>img/nophoto.png' width='100' height='100' alt='nophoto' /><?php } ?>">
							<?php echo $st['firstname'].' '.$st['lastname']; ?>
						</a>
					</td>
					<td class="tcenter">
						<?php if ($this->db->where('student_id', $st['id'])->where('set_id !=', $set_id)->get('requests')->result_array()) { ?>
						<span class="tgreen tbold">Ναι</span>
						<?php } else { ?>
						<span class="tred tbold">Όχι</span>
						<?php } ?>
					</td>
					<td class="tleft">
						<?php if ($elsewhere) { ?>
							<span class="tred tipt" title="Από καθηγητή τομεα: <?php echo $this->mdirs->get($this->musers->get($this->msets->get($elsewhere['set_id'], FALSE, 'professor_id'), 'professor_dir_id'),'title'); ?>">Έχει ανατεθεί ήδη μία διπλωματική στο φοιτητή!</span>
						<?php } else { ?>
							<?php $ast = $this->mreq->getallthesis($set_id, $st['id'])->result_array(); ?>
							<?php
							$counthesis = 0;
							$title = NULL;
							$file = NULL;
							foreach ($ast as $t)
							{
								if ($this->db->where('thesis_id', $t['id'])->where('student_id', $st['id'])->where('selected', '1')->get('requests')->result_array())
								{
									$title = $t['title'];
									$file = $t['zipfile'];
								}

								if (!$this->db->where('thesis_id', $t['id'])->where('selected', '1')->get('requests')->result_array())
									$counthesis++;
							}
							?>

							<?php if ($title) { ?>
								<?php if ($file) { ?>
								<a href="<?php echo base_url(); ?>uploads/thesis/<?php echo $file; ?>">
									<img src="<?php echo theme_url(); ?>img/icon-download.png" alt="download" class="tipt" title="Ο φοιτητής ολοκλήρωσε τη διπλωματική! Κάνετε κλικ για να την κατεβάσετε!" />
								</a>
								<?php } ?>
								<span class="tgreen tbold"><?php echo $title; ?></span>
							<?php } else if ($counthesis == '0') echo '<span class="tred">Δεν έμεινε ελεύθερη κάποια διπλωματική για τον φοιτητή!</span>'; else { ?>

								<?php echo form_open('professor/thesis/requests/'.$set_id, array('style' => 'margin:0')); ?>
									<input type="hidden" name="id" id="id" value="<?php echo $st['id']; ?>" />
									<select name="thesis_id" id="thesis_id" size="1" class="dis-inline-block">
										<?php foreach ($ast as $t) { ?>
										<?php if (!$this->db->where('thesis_id', $t['id'])->where('selected', '1')->get('requests')->result_array()) { ?>
											<option value="<?php echo $t['id']; ?>"><?php echo $t['order'].'. '.$t['title']; ?></option>
										<?php } } ?>
									</select>
									<input type="submit" value="Ανάθεση" name="btn" id="btn" class="dis-inline-block" onclick="return confirm('Θέλετε σίγουρα να αναθέσετε αυτή τη διπλωματική στον φοιτητή; Δεν υπάρχει δυνατότητα αλλαγής μετά την επιλογή!')" />
								<?php echo form_close(); ?>
							<?php } ?>
						<?php } ?>
					</td>
				</tr>
				<?php } } ?>
			</tbody>
		</table>

		<?php if ($allthesis->num_rows() > 0) { ?>
			<?php foreach ($allthesis->result_array() as $thesis) {  ?>
				<?php if (!$this->db->where('thesis_id', $thesis['id'])->where('selected', '1')->get('requests')->result_array()) { ?>
					<h2 class="tleft"><?php echo $thesis['title']; ?></h2>

					<?php $students = $this->mreq->getstudents($thesis['id'])->result_array(); ?>

					<?php
					$counter = 0;
					if ($students) { foreach ($students as $s) {
						if (!$this->db->where('student_id', $s['id'])->where('selected', '1')->get('requests')->result_array())
							$counter++;
					} }
					?>

					<?php if ($students && $counter > 0) { ?>
						<table class="sortable">
							<thead>
								<tr>
									<th class="tcenter">Προτίμηση</th>
									<th class="tleft">Όνομα</th>
									<th class="tcenter">ΑΕΜ</th>
									<th class="tcenter">Βαθμολογία</th>
									<th class="tcenter">Έτος</th>
									<th class="tcenter tipt" title="Μαθήματα που απομένουν για λήψη πτυχίου">Μαθήματα</th>
									<th class="tcenter">Τομέας</th>
									<th class="tcenter">Email</th>
									<th class="tcenter">Στοιχεία</th>
									<th class="tcenter">Αρχείo</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($students as $student) { ?>
								<?php if (!$this->db->where('student_id', $student['id'])->where('selected', '1')->get('requests')->result_array()) { ?>
									<tr>
										<td class="tcenter tbold"><?php echo $student['order']; ?></td>
										<td class="tleft">
											<a href="<?php echo site_url(); ?>/professor/thesis/requests/<?php echo $set_id; ?>/<?php echo $student['id']; ?>" class="tipt tbold" title="<?php if ($student['photo']) { ?><img src='<?php echo base_url(); ?>uploads/photos/<?php echo $student['photo']; ?>' alt='photo_<?php echo $student['id']; ?>' /><? } else { ?><img src='<?php echo theme_url(); ?>img/nophoto.png' width='100' height='100' alt='nophoto' /><?php } ?>">
												<?php echo $student['firstname'].' '.$student['lastname']; ?>
											</a>
										</td>
										<td class="tcenter"><?php echo $student['student_aem']; ?></td>
										<td class="tcenter tbold"><?php echo $student['student_grade']; ?></td>
										<td class="tcenter tbold"><?php echo $student['student_year']; ?></td>
										<td class="tcenter"><?php echo $student['student_cleft']; ?></td>
										<td class="tcenter"><?php echo $this->mdirs->get($student['student_dir_id'], 'title'); ?></td>
										<td class="tcenter">
											<a href="mailto:<?php echo $student['email']; ?>">
												<img src="<?php echo theme_url(); ?>img/icon-newmail.png" alt="email_<?php echo $student['id']; ?>" class="tipt" title="Αποστολή email" />
											</a>
										</td>
										<td class="tcenter">
											<img src="<?php echo theme_url(); ?>img/icon-address.png" alt="address_<?php echo $student['id']; ?>" class="tipt" title="<?php echo $student['address']; ?><br/><br/>Τηλ: <?php echo $student['phone']; ?>" />
										</td>
										<td class="tcenter">
											<a href="<?php echo base_url(); ?>uploads/files/<?php echo $student['student_file']; ?>">
												<img src="<?php echo theme_url(); ?>img/icon-download.png" width="20" height="20" alt="file_<?php echo $student['id']; ?>" class="tipt" title="Μεταφόρτωση αρχείου" />
											</a>
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
							</tbody>
						</table>
					<?php } else { ?>
					<div class="msg-alert">Δεν έχει δηλώσει κανένας φοιτητής αυτή την διπλωματική!</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>

	<?php } else { ?>
		<div class="msg-info">Δεν υπάρχουν ακόμη αιτήσεις φοιτητών σε αυτό το σετ!</div>
	<?php } ?>

</div>
<!-- END main -->

<?php $this->load->view('inc/footer'); ?>