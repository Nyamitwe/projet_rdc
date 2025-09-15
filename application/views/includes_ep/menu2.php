<?php 
// Redirection si pas connecté
if ($this->session->userdata('PMS_USER_ID') < 1) {
 redirect(base_url());
}

// Petite fonction utilitaire pour marquer le lien actif
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

      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
       <div class="navbar-nav">
        <a class="<?= set_active([2 => 'Faire_Demande', 3 => 'get_form']) ?>" href="<?= base_url('personal_request/Faire_Demande/get_form') ?>">
         <i class="fa fa-plus-circle"></i> <?= lang('menu_nvlle_declaration') ?>
        </a> 

        <a class="<?= set_active([2 => 'Demande_Information', 3 => 'listing']) ?>" href="<?= base_url('personal_request/Demande_Information/listing/') ?>">
         <i class="fa fa-bars"></i> <?= lang('menu_mes_declarations') ?>
        </a>
        <a class="<?= set_active([2 => 'Demande_User', 3 => 'index']) ?>" href="<?= base_url('personal_request/Demande_User/index/4') ?>">
         <i class="fa fa-bars"></i> Suivi du transfert
        </a>

        <a class="<?= set_active([2 => 'Change_Password']) ?>" href="<?= base_url('personal_request/Change_Password') ?>">
         <i class="fa fa-user"></i> <?= lang('menu_mon_profil') ?>
        </a>

        <a class="<?= set_active([2 => 'Projets_vente']) ?>" href="<?= base_url('personal_request/Projets_vente/') ?>">
         <i class="fa fa-list"></i> Projets de vente
        </a>

        <a class="<?= set_active([2 => 'NotificationEnvoye']) ?>" href="<?= base_url('personal_request/NotificationEnvoye/') ?>">
         <span class="text-danger"><?= ($non_lu['non_lu'] > 0) ? $non_lu['non_lu'] : ''; ?></span> Notifications
        </a>
       </div>
      </div>
     </nav>
     

    </nav>
