<?php $this->load->view('inc/top'); ?>

<?php $this->load->view('inc/header'); ?>

<!-- Archive Content -->

<?php if ($professors->num_rows() > 0) { ?>

    <?php $preprof = NULL; ?>

    <?php foreach($professors->result_array() as $prof) { ?>

        <?php if ($preprof != $prof['id']) { ?>
            <div class="profcon">
                <?php if ($prof['photo']) { ?>
                    <img src="<?php echo base_url(); ?>uploads/photos/<?php echo $prof['photo']; ?>" width="100" height="100" alt="photo" />
                <?php } else { ?>
                    <img src="<?php echo theme_url(); ?>img/nophoto.png" width="100" height="100" alt="photo" />
                <?php } ?>
                <a href="<?php echo site_url(); ?>/professor/profile/index/<?php echo $prof['id']; ?>" class="tbold">
                    <?php echo $prof['firstname'].' '.$prof['lastname'].' ('.$prof['professor_attr'].')'; ?>
                </a>
                <span class="fright tred tbold"><?php if ($prof['title']) echo $prof['title']; ?></span>
            </div>

            <div class="thesis-set-con">
                <table>
                    <thead>
                        <tr>
                            <th class="tcenter">Ακαδημαϊκό έτος</th>
                            <th class="tcenter">Έναρξη αιτήσεων</th>
                            <th class="tcenter">Λήξη αιτήσεων</th>
                            <th class="tcenter">Διπλωματικές</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($professors->result_array() as $profin) { ?>
                        <?php if ($prof['id'] == $profin['id']) { ?>
                        <tr>
                            <td class="tcenter tbold"><?php echo $profin['year'].'-'.substr(($profin['year'] + 1), 2, 2); ?></td>
                            <td class="tcenter tbold tgreen"><?php echo $profin['start']; ?></td>
                            <td class="tcenter tbold tred"><?php echo $profin['end']; ?></td>
                            <td class="tcenter">
                                <a href="<?php echo site_url("site/archive/viewthesis/".$profin['sid'].""); ?>" class="tbold">
                                    <?php echo $this->mthesis->getnum($profin['sid']); ?>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

    <?php
    $preprof = $prof['id'];
    } ?>

<?php } else { ?>

    <div class="msg-info">Δεν υπάρχουν ακόμη διπλωματικές στο αρχείο!</div>

<?php } ?>

<!-- END Archive Content -->

<?php $this->load->view('inc/footer'); ?>