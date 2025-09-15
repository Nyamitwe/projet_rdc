<style type="text/css">
   


.dropdown-item.active, .dropdown-item:active {
    color: white;
    text-decoration: none;
    background-color: #1b7a6c;
}
</style>


<nav style="background-image: url(<?= base_url() ?>template_ep/images/bg_pms_header.png); background-repeat: no-repeat;background-size: cover" class="navbar navbar-expand-lg navbar-light">
        <div class="full">
            <div class="logo_section mr-4  mb-2">
                <a href="requerant.html"><img class="img-responsive" src="<?= base_url() ?>template_ep/images/DTF_light_logo.png" alt="#" /></a>
            </div>




            <div class="dropdown right_topbar mt-4 mr-4">

                                  
                <a class="text-white dropdown-toggle" role="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text-white font-weight-bold"><i class="fa fa-user-circle"></i> Bienvenu, <?=$this->session->userdata('PMS_NOM')?></span></a>
                <div class="dropdown-menu shadow" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="<?=base_url('index.php/Login/do_logout')?>"><span>Déconnexion</span> <i style="color: red" class="fa fa-sign-out"></i></a>
                </div>
            </div>


            
            <div class="dropdown right_topbar mt-4 mr-4">

                                  
                <a class="text-white dropdown-toggle" role="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text-white font-weight-bold"><i class="fa fa-language"></i> Lang</span></a>
                <div class="dropdown-menu shadow" aria-labelledby="profileDropdown">

                    <a  class="dropdown-item <?php if($this->session->userdata('site_lang')=='french') echo 'active' ?>" href="<?php echo base_url(); ?>Language/index/french"> Français</a>

                     <a class="dropdown-item <?php if($this->session->userdata('site_lang')=='english') echo 'active' ?>" href="<?php echo base_url(); ?>Language/index/english"> English</a>
                </div>
            </div>


        </div>
    </nav>


<!-- 
 
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
                           <a href="index.html"><img class="img-responsive" src="<?php echo base_url() ?>template/images/DTF_light_logo.png" alt="#" /></a>
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">

                               

                              <ul>
                                 <li><a href="#"><i class="fa fa-bell-o"></i><span class="badge">2</span></a></li>
                              </ul>

                               

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
                                       <a class="dropdown-item" href="#">Mon Profil</a>
                                       <a style="color: red" class="dropdown-item" href="<?= base_url() ?>Login/do_logout"><span>Déconnexion </span> <i class="fa fa-sign-out"></i></a>
                                    </div>
                                 </li>
                              </ul>
                              
                           </div>
                        </div>
                     </div>
                  </nav>


               </div>







<script>
const d = new Date();
let time = d.getTime();
let now = new Date();

document.getElementById("demo").innerHTML = now;
</script> -->