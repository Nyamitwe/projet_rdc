<?php 

if (empty($this->session->userdata('PMS_USER_ID'))) {
   // code...
  redirect(base_url());
}
?>

<nav style="background-image: url(<?php echo base_url() ?>template/images/bg_sidebar.png); background-size: cover; background-repeat: no-repeat" id="sidebar">
  <div class="sidebar_blog_1">
    <div class="sidebar-header">
        <div class="logo_section">
            <a href=""><img class="logo_icon img-responsive" src="<?php echo base_url() ?>template/images/logo/Blason_du_Burundi.png" alt="#" /></a>
        </div>
    </div>
    <div class="sidebar_user_info text-center">
        <a href=""><img width="150" class="img-responsive" src="<?php echo base_url() ?>template/images/pms_logo.svg" alt="#" /></a>
        <h5 class="text-white">PROJET</h5>
    </div>
</div>

              <div class="sidebar_blog_2">
                  <ul class="list-unstyled components">

                    <?php 

                    $get_url = $this->uri->segment(2);
                    $get_url1 = $this->uri->segment(1);
                    
                    ?>
                    
                    

                        <li class="<?php if($get_url == 'Applications') echo 'active' ?>"><a href="<?php echo base_url() ?>applications/Applications/applications"><i class="fa fa-cogs lightgreen_color"></i> <span>PARAMETRE</span></a></li>

                    

                    <hr>
                                <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                                    <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tachometer lightgreen_color"></i> <span>DASHBOARD</span></a>
                                    <ul class="collapse list-unstyled" id="dashboard">

                                     
                                        <li class="<?php if($get_url == 'Dashboad_Global_New') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboad_Global_New"><span><?=lang('menu_tableau_de_bord_requete')?></span></a>
                                        </li>
                                    

                              
                                    </ul>
                                </li>

                            
                    <hr>  

                                        <hr>
                                <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier2') echo 'active' ?>">
                                    <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tachometer lightgreen_color"></i> <span>ACTIVITÉS</span></a>
                                    <ul class="collapse list-unstyled" id="dashboard">

                                     
                                        <li class="<?php if($get_url == 'Dashboad_Global_New') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboad_Global_New"><span><?=lang('menu_tableau_de_bord_requete')?></span></a>
                                        </li>
                                    

                              
                                    </ul>
                                </li>

                            
                    <hr>  
                                        <hr>
                                <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier3') echo 'active' ?>">
                                    <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tachometer lightgreen_color"></i> <span>UTILISATEUR</span></a>
                                    <ul class="collapse list-unstyled" id="dashboard">

                                     
                                        <li class="<?php if($get_url == 'Dashboad_Global_New') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboad_Global_New"><span><?=lang('menu_tableau_de_bord_requete')?></span></a>
                                        </li>
                                    

                              
                                    </ul>
                                </li>

                            
                    <hr>  
                                        <hr>
                                <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier4') echo 'active' ?>">
                                    <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tachometer lightgreen_color"></i> <span>DOMAINES</span></a>
                                    <ul class="collapse list-unstyled" id="dashboard">

                                     
                                        <li class="<?php if($get_url == 'Dashboad_Global_New') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboad_Global_New"><span><?=lang('menu_tableau_de_bord_requete')?></span></a>
                                        </li>
                                    

                              
                                    </ul>
                                </li>

                            
                    <hr>  
                                        <hr>
                                <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier5') echo 'active' ?>">
                                    <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tachometer lightgreen_color"></i> <span>PRODUITS</span></a>
                                    <ul class="collapse list-unstyled" id="dashboard">

                                     
                                        <li class="<?php if($get_url == 'Dashboad_Global_New') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboad_Global_New"><span><?=lang('menu_tableau_de_bord_requete')?></span></a>
                                        </li>
                                    

                              
                                    </ul>
                                </li>

                            
                    <hr>  
                                        <hr>
                                <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier6') echo 'active' ?>">
                                    <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tachometer lightgreen_color"></i> <span>FACTURES</span></a>
                                    <ul class="collapse list-unstyled" id="dashboard">

                                     
                                        <li class="<?php if($get_url == 'Dashboad_Global_New') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboad_Global_New"><span><?=lang('menu_tableau_de_bord_requete')?></span></a>
                                        </li>
                                    

                              
                                    </ul>
                                </li>

                            
                    <hr>  
                                        <hr>
                                <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier7') echo 'active' ?>">
                                    <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tachometer lightgreen_color"></i> <span>REQUETES</span></a>
                                    <ul class="collapse list-unstyled" id="dashboard">

                                     
                                        <li class="<?php if($get_url == 'Dashboad_Global_New') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboad_Global_New"><span><?=lang('menu_tableau_de_bord_requete')?></span></a>
                                        </li>
                                    

                              
                                    </ul>
                                </li>
   </ul>
</li>




                    <!--   <li>
                        <a href="#voyageur" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-user lightgreen_color"></i> <span>Items</span></a>
                        <ul class="collapse list-unstyled" id="voyageur">
                           <li class="activated"><a href="arrivant.html"><span>Item 1</span></a></li>
                           <li><a href="sortant.html"><span>Item 2</span></a></li>
                        </ul>
                    </li> -->
                    
                    
                    
                    
                </ul>
            </div>

            <!--  <footer> -->
              <!--  <br>
               <br>
               <br>
               <br>
               <br>
               <br>
                  <div style="height: 50px;bottom: 0;width: 100%;">
                        <div class="row">
                           <div class="footer">
                               <p id="copyright">Copyright &copy; <script> document.write(new Date().getFullYear())</script> - Conçu et développé par <a href="mediabox.bi">Mediabox SA Burundi <img alt="Mediabox Logo" width="30px" src="<?php echo base_url() ?>template/images/mediabox_logo.png"></a></p>
                           </div>
                        </div>
                    </div> -->
                    <!--   </footer> -->

                    

                </nav>


                <!--   <footer> -->
  <!--                      </div>
  </footer> -->


  <style type="text/css">


      .padding_infor_info {
        padding: 5px;
        padding-top: 5px;
        padding-right: 5px;
        padding-bottom: 5px;
        padding-left: 5px;
    }
</style>