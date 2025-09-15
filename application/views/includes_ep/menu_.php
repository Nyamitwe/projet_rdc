<?php 

if ($this->session->userdata('PMS_USER_ID')<1) {
   // code...
  redirect(base_url());
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-second">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php 

			$get_url = $this->uri->segment(2);
			$get_url1 = $this->uri->segment(3);

		  
		 ?>
		 <?php 
			if ($this->session->userdata('PMS_PROFIL_ID')==1 || $this->session->userdata('PMS_PROFIL_ID')== 5 || $this->session->userdata('PMS_PROFIL_ID')== 8 || $this->session->userdata('PMS_PROFIL_ID')== 10 || $this->session->userdata('PMS_PROFIL_ID')== 11 || $this->session->userdata('PMS_PROFIL_ID')==2 || $this->session->userdata('PMS_PROFIL_ID')==9) { ?>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="<?php if($get_url == 'Demande_User') echo 'active' ?>" href="<?=base_url('personal_request/Demande_User/') ?>"><i class="fa fa-dashboard"></i> <?=lang('menu_tableau_de_bord') ?></a>
					<a class="<?php if($get_url == 'Paiement') echo 'active' ?>" href="<?=base_url('personal_request/Paiement/') ?>"><i class="fa fa-bars"></i> <?=lang('menu_paiement') ?></a>
					<a class="<?php if($get_url == 'Faire_Demande') echo 'active' ?>" href="<?=base_url('personal_request/Faire_Demande/') ?>"><i class="fa fa-plus-circle"></i> <?=lang('menu_faire_demande') ?></a>
					<a class="<?php if($get_url == 'Demandes') echo 'active' ?>" href="<?=base_url('personal_request/Demandes/') ?>"><i class="fa fa-bars"></i> <?=lang('menu_demande') ?></a>

					<?php if ($this->session->userdata('PMS_PROFIL_ID')!=9){ ?>
					<a class="<?php if($get_url == 'Mes_Propriete') echo 'active' ?>" href="<?=base_url('personal_request/Mes_Propriete/') ?>"><i class="fa fa-plus-circle"></i> <?=lang('menu_proprietes') ?></a>
					<?php } ?>

					<?php  
					 $USER_ID = $this->session->userdata('PMS_USER_ID');
					 $non_lu=$this->Model->getRequeteOne("SELECT count(`NOTIFICATION_ID`) non_lu FROM `pms_notifications` WHERE STATUT = 0 AND USER_NOTIFIE=".$USER_ID); 
					   ?>
					 <a  href="<?=base_url('personal_request/NotificationEnvoye') ?>" ><i class="fa fa-bell text-danger"></i><span class="text-danger"><?=($non_lu['non_lu']>0) ? $non_lu['non_lu'] : ''; ?></span> Notifications</a>

				</div>
			</div>
		   <?php }elseif ($this->session->userdata('PMS_PROFIL_ID')==3 or $this->session->userdata('PMS_PROFIL_ID')==9){?>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
				<a class="<?php if($get_url == 'Demande_User') echo 'active' ?>" href="<?=base_url('personal_request/Demande_User/') ?>"><i class="fa fa-dashboard"></i> <?=lang('menu_tableau_de_bord') ?></a>
				<a class="<?php if($get_url == 'Paiement') echo 'active' ?>" href="<?=base_url('personal_request/Paiement/') ?>"><i class="fa fa-bars"></i> <?=lang('menu_paiement') ?></a>
				<a class="<?php if($get_url == 'Faire_Demande') echo 'active' ?>" href="<?=base_url('personal_request/Faire_Demande/') ?>"><i class="fa fa-plus-circle"></i> <?=lang('menu_faire_demande') ?></a>
				<a class="<?php if($get_url == 'Demandes') echo 'active' ?>" href="<?=base_url('personal_request/Demandes/') ?>"><i class="fa fa-bars"></i> <?=lang('menu_demande') ?></a>
					</div>
				</div>
			<?php }elseif ($this->session->userdata('PMS_PROFIL_ID')==4 || $this->session->userdata('PMS_PROFIL_ID')==2) {?>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
				<?php  if ($this->session->userdata('PMS_PROFIL_ID')==4) { 

				  ?>
					<a class="<?php if($get_url1 == 'index') echo 'active' ?>" href="<?=base_url('personal_request/Faire_Demande/get_form') ?>"><i class="fa fa-plus-circle"></i> <?=lang('menu_nvlle_declaration') ?></a>

				  <?php  }  ?>
					
					<a class="<?php if($get_url1 == 'listing') echo 'active' ?>" href="<?=base_url('personal_request/Demande_Information/listing/') ?>"><i class="fa fa-bars"></i> <?=lang('menu_mes_declarations') ?></a>
		<?php  if ($this->session->userdata('PMS_PROFIL_ID')==4) { 

				  ?>
				   <a class="<?php if($get_url1 == 'index') echo 'active' ?>" href="<?=base_url('personal_request/Demande_User/index/4') ?>"><i class="fa fa-bars"></i> Suivi du transfert</a>

				<?php  }  ?>
					<?php if ($this->session->userdata('PMS_PROFIL_ID')==4 || $this->session->userdata('PMS_PROFIL_ID')== 3 || $this->session->userdata('PMS_PROFIL_ID')==2 || $this->session->userdata('PMS_PROFIL_ID')==8 || $this->session->userdata('PMS_PROFIL_ID')==9  || $this->session->userdata('PMS_PROFIL_ID')== 10 || $this->session->userdata('PMS_PROFIL_ID')== 11) {?>
				  
					<a  href="<?=base_url('personal_request/Change_Password') ?>"><i class="fa fa-user"></i> <?=lang('menu_mon_profil') ?></a>
					 <?php }else {?>

					  <a  href="#"><i class="fa fa-user"></i> <?=lang('menu_mon_profil') ?></a>

					<?php }?>

					<?php if ($this->session->userdata('PMS_PROFIL_ID')==4) { ?> 
				  
					<a  href="<?=base_url('personal_request/Projets_vente') ?>" ><i class="fa fa-list"></i> Projets de vente</a>
					 <?php } ?>

					 <?php  
					 $USER_ID = $this->session->userdata('PMS_USER_ID');
					 $non_lu=$this->Model->getRequeteOne("SELECT count(`NOTIFICATION_ID`) non_lu FROM `pms_notifications` WHERE STATUT = 0 AND USER_NOTIFIE=".$USER_ID); 
					   ?>
					 <a  href="<?=base_url('personal_request/NotificationEnvoye') ?>" ><i class="fa fa-bell text-danger"></i><span class="text-danger"><?=($non_lu['non_lu']>0) ? $non_lu['non_lu'] : ''; ?></span> Notifications</a>
					 


				</div> 
			</div>
		   <?php }
		  ?>

	</nav>