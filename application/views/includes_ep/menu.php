<?php 
// Redirection si pas connecté
if ($this->session->userdata('PMS_USER_ID') < 1) {
    redirect(base_url());
}

// Fonction pour activer le lien
if (!function_exists('set_active')) {
    /**
     * Vérifie si l'URL correspond aux segments donnés
     * @param array $segments [position => valeur]
     * Exemple: set_active([2 => 'Faire_Demande', 3 => 'get_form'])
     */
    function set_active($segments) {
        $CI =& get_instance();
        foreach ($segments as $pos => $val) {
            if ($CI->uri->segment($pos) != $val) {
                return ''; // un seul mismatch => pas actif
            }
        }
        return 'active'; // tous matchent => actif
    }
}
?>

<head>
    <style>
        .navbar-nav .nav-link.active {
            color: #fff !important;           /* texte blanc */
            background-color: #0d6efd !important; /* fond bleu */
            font-weight: 500;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            margin-right: 5px; /* petit espace entre les liens */
        }
        .navbar-nav .nav-link.active i {
            color: #fff !important; /* icône blanche */
        }
    </style>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-second">
    <button class="navbar-toggler" type="button" data-toggle="collapse" 
            data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" 
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <?php 
        $USER_ID   = $this->session->userdata('PMS_USER_ID');
        $PROFIL_ID = $this->session->userdata('PMS_PROFIL_ID');

        // Notifications non lues
        $non_lu = $this->Model->getRequeteOne("
            SELECT count(`NOTIFICATION_ID`) non_lu 
            FROM `pms_notifications` 
            WHERE STATUT = 0 AND USER_NOTIFIE = ".$USER_ID
        );
    ?>

    <?php if (in_array($PROFIL_ID, [1,2,5,8,9,10,11])): ?>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            

                <a class="<?= set_active([2 => 'Demande_User']) ?>" href="<?= base_url('personal_request/Demande_User/') ?>">
                    <i class="fa fa-dashboard"></i> <?= lang('menu_tableau_de_bord') ?>
                </a>

                <a class="<?= set_active([2 => 'Paiement']) ?>" href="<?= base_url('personal_request/Paiement/') ?>">
                    <i class="fa fa-bars"></i> <?= lang('menu_paiement') ?>
                </a>

                <a class="<?= set_active([2 => 'Faire_Demande']) ?>" href="<?= base_url('personal_request/Faire_Demande/') ?>">
                    <i class="fa fa-plus-circle"></i> <?= lang('menu_faire_demande') ?>
                </a>

                <a class="<?= set_active([2 => 'Demandes']) ?>" href="<?= base_url('personal_request/Demandes/') ?>">
                    <i class="fa fa-bars"></i> <?= lang('menu_demande') ?>
                </a>

                <?php if ($PROFIL_ID != 9): ?>
                    <a class="<?= set_active([2 => 'Mes_Propriete']) ?>" href="<?= base_url('personal_request/Mes_Propriete/') ?>">
                        <i class="fa fa-plus-circle"></i> <?= lang('menu_proprietes') ?>
                    </a>
                <?php endif; ?>

                <a class="<?= set_active([2 => 'NotificationEnvoye']) ?>" href="<?= base_url('personal_request/NotificationEnvoye/') ?>">
                    <i class="fa fa-bell text-danger"></i>
                    <span class="text-danger"><?= ($non_lu['non_lu'] > 0) ? $non_lu['non_lu'] : ''; ?></span> Notifications
                </a>

            </div>
        </div>

    <?php elseif (in_array($PROFIL_ID, [3,9])): ?>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">

                <a class="<?= set_active([2 => 'Demande_User']) ?>" href="<?= base_url('personal_request/Demande_User/') ?>">
                    <i class="fa fa-dashboard"></i> <?= lang('menu_tableau_de_bord') ?>
                </a>

                <a class="<?= set_active([2 => 'Paiement']) ?>" href="<?= base_url('personal_request/Paiement/') ?>">
                    <i class="fa fa-bars"></i> <?= lang('menu_paiement') ?>
                </a>

                <a class="<?= set_active([2 => 'Faire_Demande']) ?>" href="<?= base_url('personal_request/Faire_Demande/') ?>">
                    <i class="fa fa-plus-circle"></i> <?= lang('menu_faire_demande') ?>
                </a>

                <a class="<?= set_active([2 => 'Demandes']) ?>" href="<?= base_url('personal_request/Demandes/') ?>">
                    <i class="fa fa-bars"></i> <?= lang('menu_demande') ?>
                </a>

            </div>
        </div>

    <?php elseif (in_array($PROFIL_ID, [2,4])): ?> 
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">

                <?php if ($PROFIL_ID == 4): ?>
                    <a class="<?= set_active([2 => 'Faire_Demande', 3 => 'get_form']) ?>" href="<?= base_url('personal_request/Faire_Demande/get_form') ?>">
                        <i class="fa fa-plus-circle"></i> <?= lang('menu_nvlle_declaration') ?>
                    </a>
                <?php endif; ?>

                <a class="<?= set_active([2 => 'Demande_Information', 3 => 'listing']) ?>" href="<?= base_url('personal_request/Demande_Information/listing/') ?>">
                    <i class="fa fa-bars"></i> <?= lang('menu_mes_declarations') ?>
                </a>

                <?php if ($PROFIL_ID == 4): ?>
                    <a class="<?= set_active([2 => 'Demande_User', 3 => 'index']) ?>" href="<?= base_url('personal_request/Demande_User/index/4') ?>">
                        <i class="fa fa-bars"></i> Suivi du transfert
                    </a>
                <?php endif; ?>

                <?php if (in_array($PROFIL_ID, [2,3,4,8,9,10,11])): ?>
                    <a class="<?= set_active([2 => 'Change_Password']) ?>" href="<?= base_url('personal_request/Change_Password') ?>">
                        <i class="fa fa-user"></i> <?= lang('menu_mon_profil') ?>
                    </a>
                <?php else: ?>
                    <a href="#"><i class="fa fa-user"></i> <?= lang('menu_mon_profil') ?></a>
                <?php endif; ?>

                <?php if ($PROFIL_ID == 4): ?>
                    <a class="<?= set_active([2 => 'Projets_vente']) ?>" href="<?= base_url('personal_request/Projets_vente/') ?>">
                        <i class="fa fa-list"></i> Projets de vente
                    </a>
                <?php endif; ?>

                <a class="<?= set_active([2 => 'NotificationEnvoye']) ?>" href="<?= base_url('personal_request/NotificationEnvoye/') ?>">
                    <span class="text-danger"><?= ($non_lu['non_lu'] > 0) ? $non_lu['non_lu'] : ''; ?></span> Notifications
                </a>

            </div>
        </div>
    <?php endif; ?>

</nav>



