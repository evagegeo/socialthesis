<?php $this->load->view('inc/top'); ?>

<script>$(function(){ $('#login_username').focus(); });</script>

<?php $this->load->view('inc/header'); ?>

<!-- Login Content -->

<div class="center-con">

    <h3 class="tcenter">Σύνδεση</h3>

    <div class="body-con">

        <?php if (isset($error)) echo "<div class=\"msg-error\">{$error}</div>"; ?>

        <?php echo form_error('login_username'); ?>
        <?php echo form_error('login_password'); ?>

        <?php echo form_open('site/login'); ?>

        <ul class="align-list">
            <li>
                <label for="login_username">Ψευδώνυμο</label>
                <input type="text" name="login_username" id="login_username" maxlength="15" value="<?php echo set_value('login_username'); ?>" />
            </li>
            <li>
                 <label for="login_password">Κωδικός</label>
                <input type="password" name="login_password" id="login_password" maxlength="15" />
            </li>
            <li>
                <label></label>
                <input type="submit" value="Είσοδος" name="login_button" id="login_button" />
            </li>
        </ul>

        <?php echo form_close(); ?>

    </div>

</div>

<!-- END Login Content -->

<?php $this->load->view('inc/footer'); ?>