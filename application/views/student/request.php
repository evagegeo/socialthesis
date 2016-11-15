<?php $this->load->view('inc/top'); ?>

<script>
    $(function(){
		$("ul.droptrue").sortable({
			connectWith: 'ul',
			cursor:	'pointer',
			opacity: 0.6
		});

		$("#allthesis_req, #allthesis_req_selected").disableSelection();

	});

	function new_request(set_id)
	{
		var content = $('.request-content');
		var result = $('#allthesis_req_selected').sortable('toArray');

		if (!result[0])
			alert('Δεν έχετε επιλέξει καμία διπλωματική ακόμη! Σύρετε τις διπλωματικές που επιθυμείτε στο κίτρινο πλαίσιο, ταξινομήστε τις με τη σειρά προτίμησής σας (από πάνω προς τα κάτω) και ξαναδοκιμάστε!');
		else
		{
			var answer = confirm('Να καταχωρηθεί η αίτηση; Από αυτό το σημείο και έπειτα δε θα μπορείτε να αλλάξετε την αίτηση!');

			if (answer)
			{
				$('#req-content').hide(1, function(){
					$('#req-loading').show(1, function(){
						content.load('<?php echo site_url(); ?>/student/requests/addrequest', {'request[]': result, set_id: set_id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(){});
					});
				});
				
			}
		}
		
		return false;
	}
</script>

<?php $this->load->view('inc/header'); ?>

<!-- Main -->
<div id="main" class="request-content">

	<div id="req-loading" class="tcenter dis-none">Παρακαλώ περιμένετε..<br/><img src="<?php echo theme_url(); ?>img/loading.gif" alt="loading" /></div>

	<div id="req-content">
		<?php if (isset($error)) { ?>
			<div class="msg-alert"><?php echo $error; ?></div>
		<?php } else { ?>
			<table>
				<thead>
					<tr>
						<th class="tcenter">Επιβλέπων</th>
						<th class="tcenter">Αναδημαϊκό έτος</th>
						<th class="tcenter">Έναρξη αιτήσεων</th>
						<th class="tcenter">Λήξη αιτήσεων</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="tcenter">
							<a href="<?php echo site_url(); ?>/professor/profile/index/<?php echo $set['id']; ?>" class="tbold">
								<?php echo $set['firstname'].' '.$set['lastname'].' ('.$set['professor_attr'].')';?>
							</a>
						</td>
						<td class="tcenter tbold"><?php echo $set['year'].'-'.substr(($set['year'] + 1), 2, 2); ?></td>
						<td class="tcenter tbold tgreen"><?php echo $set['start']; ?></td>
						<td class="tcenter tbold tred"><?php echo $set['end']; ?></td>
					</tr>
				</tbody>
			</table>
			<br/>
			<table>
				<thead>
					<tr>
						<th class="tcenter th-thesis">Διπλωματικές</th>
						<th class="tcenter">Σειρά προτιμήσης</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2">
							<?php if ($allthesis->num_rows() > 0) { ?>
								<ul id="allthesis_req" class="droptrue">
								<?php foreach($allthesis->result_array() as $thesis) { ?>
									<li id="<?php echo $thesis['id']; ?>" class="thesis-con-req tbold"><?php echo $thesis['title']; ?></li>
								<?php } ?>
								</ul>
							<?php } ?>
							<ul id="allthesis_req_selected" class="droptrue tipt" title="Σύρετε τις διπλωματικές που επιθυμείτε εδώ και ταξινομήστε τις με τη σειρά προτίμησής σας (από πάνω προς τα κάτω)">
							</ul>
						</td>
					</tr>
					<tr>
						<td colspan="3"><a href="#" class="tbold" onclick="return new_request(<?php echo $this->uri->segment(4); ?>);">Καταχώρηση αίτησης</a></td>
					</tr>
				</tbody>
			</table>
		<?php } ?>
	</div>

</div>
<!-- END Main -->

<?php $this->load->view('inc/footer'); ?>