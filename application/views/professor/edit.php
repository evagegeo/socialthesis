<?php $this->load->view('inc/top'); ?>

<script>
	// Show edit button and change background of each thesis container
    function hover_thesis(thesis_id, mode)
	{
		var thesis = $('#thesis_' + thesis_id);
        var options = $('#options_' + thesis_id);
		
		if (mode == 1)
		{
			thesis.css('background-color', '#F9F9F9');
			options.show();
		}
		else
		{
			thesis.css('background-color', '#FFFFFF');
			options.hide();
		}
	}

	// Edit thesis (ajax)
	function edit_thesis(thesis_id)
	{
		var thesis = $('#thesis_' + thesis_id);
        
        $('#ajax-loading').fadeIn();

		thesis.load('<?php echo site_url(); ?>/professor/thesis/ajax', {mode: 'edit', thesis_id: thesis_id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(){
			$(this).fadeIn(500);
			$(function(){
                $('.iseditor_' + thesis_id).cleditor({
                      width:        '700px',
                      height:       '300px',
                      controls:     "bold italic underline strikethrough | alignleft center alignright justify | style color removeformat | bullets numbering | " +
                                    "undo redo | rule image link unlink | cut copy paste pastetext | source",
                      colors:       "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
                                    "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
                                    "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
                                    "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
                                    "666 900 C60 C93 990 090 399 33F 60C 939 " +
                                    "333 600 930 963 660 060 366 009 339 636 " +
                                    "000 300 630 633 330 030 033 006 309 303",    
                      styles:       [["Paragraph", "<p>"], ["Header 4","<h4>"],  ["Header 5","<h5>"], ["Header 6","<h6>"]],
                      useCSS:       false,
                      docType:      '<!DOCTYPE html>',
                      docCSSFile:   "", 
                      bodyStyle:    "margin:4px; font:10pt Arial,Verdana; cursor:text"
                });
            });
            
            $('#ajax-loading').fadeOut();
		});

		return false;
	}

	// Submit edited thesis (ajax)
	function submit_edit(thesis_id)
	{
		var thesis = $('#thesis_' + thesis_id);

		var title = $('#thesis_' + thesis_id + ' input#edit_title');
		var content = $('#thesis_' + thesis_id + ' textarea.iseditor_' + thesis_id);
        
        $('#ajax-loading').fadeIn();

		thesis.load('<?php echo site_url(); ?>/professor/thesis/ajax', {mode: 'submit', thesis_id: thesis_id, title: title.val(), content: content.val(), <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(){
			$(this).fadeIn(500);
            $('#ajax-loading').fadeOut();
		});

		return false;
	}

	// Cancel edit (ajax)
	function cancel_edit(thesis_id)
	{
		var thesis = $('#thesis_' + thesis_id);
        
        $('#ajax-loading').fadeIn();

		thesis.load('<?php echo site_url(); ?>/professor/thesis/ajax', {mode: 'cancel', thesis_id: thesis_id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(){
			$(this).fadeIn(500);
            $('#ajax-loading').fadeOut();
		});

		return false;
	}
    
    // Delete thesis (ajax)
	function delete_thesis(thesis_id)
	{
        if ( confirm('Θέλετε σίγουρα να διαγράψετε αυτή τη διπλωματική;') )
        {
            var thesis = $('#thesis_' + thesis_id);
            var thesis_num = $('#thesis-num a');
        
            $('#ajax-loading').fadeIn();

            thesis.slideUp().load('<?php echo site_url(); ?>/professor/thesis/ajax', {mode: 'delete', thesis_id: thesis_id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(){
                $('#ajax-loading').fadeOut();
                var tnum = thesis_num.html();
                thesis_num.html( tnum - 1 );
                
                if ( (tnum - 1) == 0 )
                    thesis_num.removeClass('btn-blue').addClass('btn');
            });
        }

		return false;
	}
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
                <td id="thesis-num" class="tcenter">
                    <?php ($this->mthesis->getnum($set['id']) == '0') ? $btnclass = 'btn' : $btnclass = 'btn-blue'; ?>
                    <a href="<?php echo site_url("professor/thesis/edit/".$set['id'].""); ?>" class="tbold <?php echo $btnclass; ?>"><?php echo $this->mthesis->getnum($set['id']); ?></a>
                </td>
                <td class="tcenter">
                    <?php ($this->mreq->getnumreq($set['id']) == '0') ? $btnclass = 'btn' : $btnclass = 'btn-green'; ?>
                    <a href="<?php echo site_url("professor/thesis/requests/".$set['id'].""); ?>" class="tbold <?php echo $btnclass; ?>"><?php $req_num = $this->mreq->getnumreq($set['id']); echo $req_num; ?></a>
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

	<h3 id="allthesis">Διπλωματικές του σετ</h3>
    
    <div class="body-con">

        <?php if ($allthesis->num_rows() > 0) { ?>
        
            <?php foreach($allthesis->result_array() as $thesis) { ?>

            <div id="thesis_<?php echo $thesis['id']; ?>" class="thesis-con" onmouseover="hover_thesis(<?php echo $thesis['id']; ?>, 1)" onmouseout="hover_thesis(<?php echo $thesis['id']; ?>, 0)">
                <div id="options_<?php echo $thesis['id']; ?>" class="dis-none fright">
                    <a href="#" onclick="return edit_thesis(<?php echo $thesis['id']; ?>)" class="edit-thesis-btn">
                        <img src="<?php echo theme_url(); ?>img/icon-edit.png" alt="edit" />
                    </a>
                    <?php if ( $set['published'] != 1 ) { ?>
                    <a href="#" onclick="return delete_thesis(<?php echo $thesis['id']; ?>)" class="delete-thesis-btn mar-left">
                        <img src="<?php echo theme_url(); ?>img/icon-delete.png" alt="delete" />
                    </a>
                    <?php } ?>
                </div>
                <h6 class="tleft"><?php echo $thesis['title']; ?></h6>
                <p><?php echo $thesis['content']; ?></p>
            </div>

            <?php } ?>
        <?php } else { ?>
            <div id="msg-nothesis" class="msg-info">Δεν υπάρχει καμία διπλωματική σε αυτό το σετ προς το παρόν!</div>
        <?php } ?>
            
    </div>
    
    <?php if ($this->uri->segment(5) == 'addthesis_ok') echo '<div class="msg-ok">Η διπλωματική προστέθηκε με επιτυχία!</div>'; ?>
        
    <h3 id="addthesis">Προσθήκη νέας διπλωματικής</h3>
    
    <div class="body-con">
        
        <?php if ( $req_num > 0 ) { ?>
        <div class="msg-alert tcenter">Αυτό το σετ έχει δημοσιευτεί και έχουν ήδη πραγματοποιηθεί αιτήσεις!</div>
        <?php } ?>
        
        <?php if (isset($error_addthesis)) echo "<div class=\"msg-error\">{$error_addthesis}</div>"; ?>

        <?php echo validation_errors(); ?>

        <?php echo form_open("professor/thesis/edit/".$set['id']."#addthesis"); ?>

        <ul class="align-list">
            <li>
                <label for="thesis_title">Τίτλος</label>
                <input type="text" name="thesis_title" id="thesis_title" maxlength="256" class="box-large" value="<?php echo set_value('thesis_title'); ?>" />
            </li>
            <li>
                <label for="thesis_content">Περιγραφή</label>
                <textarea name="thesis_content" id="thesis_content" class="iseditor" cols="80" rows="15"><?php echo set_value('thesis_content'); ?></textarea>
            </li>
            <li>
                <label></label>
                <input type="submit" value="Προσθήκη νέας διπλωματικής" name="addthesis_button" id="addthesis_button" />
            </li>
        </ul>

        <?php echo form_close(); ?>
    </div>

</div>
<!-- END main -->

<?php $this->load->view('inc/footer'); ?>