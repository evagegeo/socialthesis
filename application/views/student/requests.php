<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Main -->
<div id="main">

	<?php if ($sets) { ?>
		<?php 
		foreach ($sets as $set) {
			$setinfo = $this->msets->getsetinfo($set['id']);
			$reqthesis = $this->db->select('requests.selected, requests.order, thesis.id AS tid, thesis.title, thesis.content')->from('requests')->join('thesis', 'requests.thesis_id = thesis.id')->where('requests.student_id', $this->session->userdata('id'))->where('requests.set_id', $set['id'])->order_by('requests.order', 'ASC')->get()->result_array();
		?>
			<table>
				<thead>
					<tr>
						<th class="tcenter">Επιβλέπων</th>
						<th class="tcenter">Ακαδημαϊκό έτος</th>
						<th class="tcenter">Έναρξη αιτήσεων</th>
						<th class="tcenter">Λήξη αιτήσεων</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="tcenter">
							<a href="<?php echo site_url(); ?>/professor/profile/index/<?php echo $setinfo['id']; ?>" class="tbold">
								<?php echo $setinfo['firstname'].' '.$setinfo['lastname'].' ('.$setinfo['professor_attr'].')';?>
							</a>
						</td>
						<td class="tcenter tbold"><?php echo $setinfo['year'].'-'.substr(($setinfo['year'] + 1), 2, 2); ?></td>
						<td class="tcenter tbold tgreen"><?php echo $setinfo['start']; ?></td>
						<td class="tcenter tbold tred"><?php echo $setinfo['end']; ?></td>
					</tr>
				</tbody>
			</table>

			<div class="thesis-set-con thesis-set-con2">
				<table>
					<thead>
						<tr>
							<th class="tcenter thesis-con-order">Σειρά προτίμησης</th>
							<th class="tleft thesis-con-title">Τίτλος διπλωματικής</th>
							<th class="tleft">Περιγραφή</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($reqthesis as $rt) { ?>
						<tr>
							<td class="<?php if ($rt['selected']) echo 'tdgreen '; ?>tcenter thesis-con-order"><?php echo $rt['order']; ?></td>
							<td class="<?php if ($rt['selected']) echo 'tdgreen '; ?>tleft thesis-con-title"><?php echo $rt['title']; ?></td>
							<td class="<?php if ($rt['selected']) echo 'tdgreen '; ?>tleft">
								<a href="#" onclick="$(this).hide(100, function(){$('#thesis_<?php echo $rt['tid']; ?>').show()}); return false;">Εμφάνιση περιγραφής</a>
								<span id="thesis_<?php echo $rt['tid']; ?>" class="dis-none">
									<?php echo $rt['content']; ?>
								</span>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	<?php } else { ?>
		<div class="msg-info">Δεν υπάρχει ακόμη καμία αίτηση!</div>
	<?php } ?>

</div>
<!-- END Main -->

<?php $this->load->view('inc/footer'); ?>