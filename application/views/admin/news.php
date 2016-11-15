<?php $this->load->view('inc/top'); ?>

<style>.cleditorToolbar { height: 53px !important; }</style>

<script>$(function(){tabs($('.default'));});</script>

<?php $this->load->view('inc/header', array( 'enable_sidebar' => TRUE ) ); ?>

<?php $this->load->view('inc/sidebar'); ?>

<!-- Main -->
<div id="main">

    <ul class="content-tabs clearfix">
        <li><a rel="tab1" <?php if ($this->uri->segment(4) == 'manage') echo 'class="default"'; ?>>Διαχείριση νέων</a></li>
        <li><a rel="tab2" <?php if ($this->uri->segment(4) == 'add') echo 'class="default"'; ?>>Προσθήκη νέου</a></li>
        <?php if ($this->uri->segment(4) == 'edit') { ?>
        <li><a rel="tab3" class="default">Επεξεργασία <?php echo $this->uri->segment(5); ?>ου νέου</a></li>
        <?php } ?>
    </ul>

    <!-- Tab1 - Manage news -->
    <div id="tab1" class="istab">

		<?php if ($news->num_rows() > 0) { ?>
			<table>
				<thead>
					<tr>
						<th>Τίτλος</th>
						<th>Δημοσιεύση</th>
						<th>Συντάκτης</th>
						<th>Προβολή</th>
						<th class="tcenter">Επεξεργασία</th>
					</tr>
				</thead>
				<tbody>

                <?php foreach($news->result_array() as $new) { ?>

                <tr>
                    <td class="tleft backcolor"><?php echo $new['title']; ?></td>
                    <td><?php echo $new['published']; ?></td>
                    <td><?php echo $new['author']; ?></td>
                    <td><?php if ($new['view'] == 1) echo 'Ναι'; else echo '<span class="tred">Όχι</span>'; ?></td>
                    <td class="tcenter">
                        <a href="<?php echo site_url("admin/news/index/edit/".$new['id'].""); ?>">
                            <img src="<?php echo theme_url(); ?>img/icon-edit.png" alt="edit" class="tipt" title="Επεξεργασία <?php echo $new['id']; ?>ου νέου" />
                        </a>
                    </td>
                </tr>

                <?php } ?>

                <?php } else { ?>
					<div class="msg-info">Κανένα νέο!</div>
                <?php } ?>
                
            </tbody>
        </table>

        <?php echo $this->pagination->create_links(); ?>

    </div>

    <!-- Tab2 - Add new -->
    <div id="tab2" class="istab body-con">
        
        <?php if ($this->uri->segment(5) == 'add_ok') echo '<div class="msg-ok">Το νέο προστέθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error_add)) echo "<div class=\"msg-error\">{$error_add}</div>"; ?>
        
        <?php echo validation_errors(); ?>

        <?php echo form_open('admin/news/index/add#tabs'); ?>
        
        <ul class="align-list">
            <li>
                <label for="new_title">Τίτλος</label>
                <input type="text" name="new_title" id="new_title" maxlength="256" value="<?php echo set_value('new_title'); ?>" />
            </li>
            <li>
                <label for="new_content">Περιεχόμενο</label>
                <textarea name="new_content" id="new_content" cols="200" rows="15" class="iseditor box-large"><?php echo set_value('new_content'); ?></textarea>
            </li>
            <li>
                <label></label>
                <input type="submit" value="Προσθήκη νέου" name="addnew_button" id="addnew_button" />
            </li>
        </ul>

        <?php echo form_close(); ?>

    </div>

    <?php if ($this->uri->segment(4) == 'edit') { ?>
    
    <!-- Tab3 - Edit new -->
    <div id="tab3" class="istab body-con">
        
        <?php if ($this->uri->segment(6) == 'edit_ok') echo '<div class="msg-ok">Το νέο ενημερώθηκε με επιτυχία!</div>'; ?>
        <?php if (isset($error_edit)) echo "<div class=\"msg-error\">{$error_edit}</div>"; ?>

        <?php echo validation_errors(); ?>

        <?php echo form_open("admin/news/index/edit/".$this->uri->segment(5)."#tabs"); ?>

        <ul class="align-list">
            <li>
                <label for="edit_title">Τίτλος</label>
                <input type="text" name="edit_title" id="edit_title" maxlength="256" value="<?php echo set_value('edit_title', $editnew['title']); ?>" />
            </li>
            <li>
                <label for="new_content">Περιεχόμενο</label>
                <textarea name="edit_content" id="edit_content" cols="200" rows="15" class="iseditor box-large"><?php echo set_value('edit_content', $editnew['content']); ?></textarea>
            </li>
            <li>
                <label for="edit_view">Προβολή</label>
                <select name="edit_view" id="edit_view">
                    <option value="1">Ναι</option>
                    <option value="0"<?php if ($editnew['view'] != 1) echo 'selected="selected"'; ?>>Όχι</option>
                </select>
            </li>
            <li>
                <label></label>
                <input type="submit" value="Ενημέρωση" name="editnew_button" id="editnew_button" />
            </li>
        </ul>        

        <?php echo form_close(); ?>

    </div>

    <?php } ?>

</div>
<!-- END Main -->

<?php $this->load->view('inc/footer'); ?>