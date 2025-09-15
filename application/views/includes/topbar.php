
<style type="text/css">
   


.dropdown-item.active, .dropdown-item:active {
    color: white;
    text-decoration: none;
    background-color: #D7D7D7;
}
</style>

<div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section">
                           <a href=""><img class="img-responsive" src="<?php echo base_url() ?>template/images/DTF_light_logo.png" alt="#" /></a>
                        </div>


                        <div class="right_topbar">
                           <div class="icon_info">

                               

                           

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
                                       <a class="dropdown-item" href="<?= base_url() ?>parametrage/Backend_User_profile"><?=lang('menu_mon_profil')?></a>
                                       <a style="color: red" class="dropdown-item" href="<?= base_url() ?>Login/do_logout"><span><?=lang('deconnexion')?></span> <i class="fa fa-sign-out"></i></a>
                                    </div>
                                 </li>
                              </ul>
                              
                           </div>
                        </div>
                     </div>
                  </nav>


               </div>


<!-- 
                <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Titre de la page</h2>
                           </div>
                        </div>
                     </div> -->



 