<?php $this->load->view('inc/top'); ?>

<script>
$(function() {

    $('#start, #end').datepicker({
        beforeShow: customRange,
        dateFormat: 'yy-mm-dd'
    });

});

function customRange(input) {

    if (input.id == 'end') {
        var minDate = new Date($('#start').val());
        minDate.setDate(minDate.getDate() + 1)

        return {
            minDate: minDate

        };
    }

}​
</script>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Main -->
<div id="main">
    
    <?php if ($this->uri->segment(4) == 'deleteset_ok') echo '<div class="msg-ok">Το σετ διαγράφηκε με επιτυχία!</div>'; ?>
    <?php if ($this->uri->segment(4) == 'pubset_ok') echo '<div class="msg-ok">Το σετ δημοσιεύτηκε με επιτυχία!</div>'; ?>
    <?php if (isset($error_pubset)) echo "<div class=\"msg-error\">{$error_pubset}</div>"; ?>
    <?php if (isset($error_deleteset)) echo "<div class=\"msg-error\">{$error_deleteset}</div>"; ?>

    <?php if ($sets->num_rows() > 0) { ?>

    <table>
        <thead>
            <tr>
                <th class="tcenter">Ακαδημαϊκό έτος</th>
                <th class="tcenter">Έναρξη αιτήσεων</th>
                <th class="tcenter">Λήξη αιτήσεων</th>
                <th class="tcenter">Διπλωματικές</th>
                <th class="tcenter">Αιτήσεις</th>
                <th class="tcenter">Επιλογές</th>
                <th class="tcenter">Κατάσταση</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach($sets->result_array() as $set) { ?>
            
        <?php 
        if (strtotime(substr($set['end'], 6, 4).'-'.substr($set['end'], 3, 2).'-'.substr($set['end'], 0, 2)) < strtotime(date('Y-m-d')))
            $set_complete = TRUE;
        else
            $set_complete = FALSE;
        ?>

        <tr <?php if ($set_complete) echo 'class="status-green"'; ?>>
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
            <td class="tcenter">
                <a href="<?php echo site_url("professor/thesis/index/edit/".$set['id']."#editset"); ?>">
                    <img src="<?php echo theme_url(); ?>img/icon-edit.png" alt="edit" class="tipt" title="Επεξεργασία" />
                </a>
                <?php if ( $set['published'] != 1 ) { ?>
                <a href="<?php echo site_url("professor/thesis/index/delete/".$set['id'].""); ?>" onclick="return confirm('Θέλετε σίγουρα να διαγράψετε το σετ; Θα διαγραφούν και όλες οι διπλωματικές αυτού του σετ!')">
                    <img src="<?php echo theme_url(); ?>img/icon-delete.png" alt="delete" class="tipt mar-left" title="Διαγραφή" />
                </a>
                <?php } ?>
            </td>
            <td>
                <?php if ( $set['published'] == 1 ) { ?>
                    <?php if ( ! $set_complete) { ?>
                    <img src="<?php echo theme_url(); ?>img/icon-active.png" alt="active" class="tipt" title="Δημοσιεύτηκε! Οι φοιτητές θα μπορέσουν να κάνουν αιτήσεις στο διάστημα που είναι ενεργή!" />
                    <?php } else { ?>
                    <img src="<?php echo theme_url(); ?>img/icon-ok.png" alt="ok" class="tipt" title="Οι αιτήσεις σε αυτό το σετ ολοκληρώθηκαν!" />
                    <?php } ?>
                <?php } else { ?>
                <a href="<?php echo site_url("professor/thesis/index/publish/".$set['id'].""); ?>" class="btn" onclick="return confirm('Θέλετε σίγουρα να δημοσιεύσετε το σετ; Μετά τη δημοσίευση δε θα μπορείτε να διαγράψετε το σετ ή τις διπλωματικές του, ενώ οι φοιτητές θα μπορούν να κάνουν αιτήσεις!')">Δημοσίευση</a>
                <?php } ?>
            </td>
        </tr>

        <?php } ?>

        </tbody>
    </table>

    <?php } else { ?>

        <div class="msg-info">Δεν υπάρχουν σετ πτυχιακών προς το παρόν!</div>

    <?php } ?>
        
    <?php if ($this->uri->segment(4) == 'editset_ok') echo '<div class="msg-ok">Το σετ ενημερώθηκε με επιτυχία!</div>'; ?>
    <?php if ($this->uri->segment(4) == 'addset_ok') echo '<div class="msg-ok">Το σετ προστέθηκε με επιτυχία!</div>'; ?>
        
    <?php if ( ($this->uri->segment(4) == 'edit' ) && ( is_numeric($this->uri->segment(5)) ) ) { ?><!-- Edit set -->

		<h3 id="editset">Επεξεργασία σετ</h3>
        
        <div class="body-con">
            <?php if (isset($error_editset)) echo "<div class=\"msg-error\">{$error_editset}</div>"; ?>

            <?php echo validation_errors(); ?>

            <?php echo form_open("professor/thesis/index/edit/".$this->uri->segment(5)."#editset"); ?>

            <ul class="align-list boxes-small">
                <li>
                    <label for="editstart">Έναρξη αιτήσεων</label>
                    <input type="text" name="start" id="start" maxlength="10" value="<?php echo set_value('start', $editset['start']); ?>" />
                </li>
                <li>
                    <label for="end">Λήξη αιτήσεων</label>
                    <input type="text" name="end" id="end" maxlength="10" value="<?php echo set_value('end', $editset['end']); ?>" />
                </li>
                <li>
                    <label></label>
                    <input type="submit" value="Ενημέρωση σετ" name="editset_button" id="editset_button" />
                </li>
            </ul>

            <?php echo form_close(); ?>
        </div>      
        
	<?php } else { ?> <!-- Add a new set -->

        <h3 id="addset">Προσθήκη νέου σετ διπλωματικών</h3>

        <div class="body-con">
            <?php if (isset($error_addset)) echo "<div class=\"msg-error\">{$error_addset}</div>"; ?>

            <?php echo validation_errors(); ?>

            <?php echo form_open('professor/thesis/index#addset'); ?>

            <ul class="align-list boxes-small">
                <li>
                    <label for="start">Έναρξη αιτήσεων</label>
                    <input type="text" name="start" id="start" maxlength="10" value="<?php echo set_value('start'); ?>" />
                </li>
                <li>
                    <label for="end">Λήξη αιτήσεων</label>
                    <input type="text" name="end" id="end" maxlength="10" value="<?php echo set_value('end'); ?>" />
                </li>
                <li>
                    <label></label>
                    <input type="submit" value="Προσθήκη νέου σετ" name="addset_button" id="addset_button" />
                </li>
            </ul>		

            <?php echo form_close(); ?>
        </div>

	<?php } ?>

</div>
<!-- END main -->

<?php $this->load->view('inc/footer'); ?>