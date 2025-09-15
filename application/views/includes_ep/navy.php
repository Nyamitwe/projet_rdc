<?php 

	


    if ($this->session->userdata('PMS_USER_ID')<1 || empty($this->session->userdata('PMS_USER_ID'))) {
       // code...
      redirect(base_url());
    }
 ?>

<nav style="background-image: url(<?= base_url() ?>template_ep/images/bg_pms_header.png); background-repeat: no-repeat;background-size: cover" class="navbar navbar-expand-lg navbar-light">
        <div class="full">
            <div class="logo_section mr-4  mb-2">
                <a href="requerant.html"><img class="img-responsive" src="<?= base_url() ?>template_ep/images/DTF_light_logo.png" alt="#" /></a>
            </div>

          

           
            <div class="right_topbar">
               <div class="icon_info">      

                    
                    
                    <!-- Fin sortie en indivision -->

                   <ul class="user_profile_dd">
                     <li>
                        <a class="dropdown-toggle" data-toggle="dropdown"><span class="username"><i style="font-size: 18px;" class="fa fa-language" aria-hidden="true"></i> Lang</span></a>
                        <div class="dropdown-menu">
                           <a  class="dropdown-item <?php if($this->session->userdata('site_lang')=='french') echo 'active' ?>" href="<?php echo base_url(); ?>Language/index/french"> Français</a>
                           <a class="dropdown-item <?php if($this->session->userdata('site_lang')=='english') echo 'active' ?>" href="<?php echo base_url(); ?>Language/index/english"> English</a>


                           
                        </div>
                     </li>
                  </ul>

                  

                  <ul class="user_profile_dd">
                     <li>
                        <a class="dropdown-toggle" data-toggle="dropdown"><span class="username"><i style="font-size: 22px;" class="fa fa-user-circle-o" aria-hidden="true"></i> <?=$this->session->userdata('PMS_NOM').' '.$this->session->userdata('PMS_PRENOM')?></span></a>
                        <div class="dropdown-menu">
                          <!--  <a class="dropdown-item" href="#">Mon Profil</a> -->
                          <a class="dropdown-item" href="<?=base_url("personal_request/Change_Password") ?>">Mon Profil</a>
                           <a style="color: red" class="dropdown-item" href="<?= base_url() ?>Login/do_logout"><span>Déconnexion </span> <i class="fa fa-sign-out"></i></a>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
        
    </nav>
