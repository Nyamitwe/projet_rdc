<?php 

if (!empty($this->session->userdata('PMS_USER_ID'))) {
   // code...

   //redirect(base_url());
}


?>

<nav style="background-image: url(<?php echo base_url() ?>template/images/bg_sidebar.png); background-size: cover; background-repeat: no-repeat" id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="index.html"><img class="logo_icon img-responsive" src="<?php echo base_url() ?>template/images/logo/Blason_du_Burundi.png" alt="#" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_info">
                           <h6>Property Management System (PMS)</h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <ul class="list-unstyled components">

                    <?php 

                      $get_url = $this->uri->segment(2);
                      $get_url1 = $this->uri->segment(1);
 
                     ?>


                        <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tachometer lightgreen_color"></i> <span>Tableaux de bord</span></a>
                        <ul class="collapse list-unstyled" id="dashboard">


                           <li class="<?php if($get_url == 'Dashboard_Actualisation_Morcellement') echo 'active' ?>"><a href="<?php echo base_url() ?>index.php/dashboard_Actualisation/Dashboard_Actualisation_Morcellement"><span>Actualisation</span></a></li>

                           <li class="<?php if($get_url == 'Dashboard_Paiement') echo 'active' ?>"><a href="<?php echo base_url() ?>index.php/dashboard_Actualisation/Dashboard_Paiement"><span>Paiement</span></a>
                           </li>

                           <li class="<?php if($get_url == 'Dashboard_Performance_Morcellement') echo 'active' ?>"><a href="<?php echo base_url() ?>index.php/dashboard_performance/Dashboard_Performance_Morcellement"><span>Morcellement - Traitement des dossiers</span></a>
                           </li>

                           <li class="<?php if($get_url == 'Dashboard_Performance_Reunification') echo 'active' ?>"><a href="<?php echo base_url() ?>index.php/dashboard_performance/Dashboard_Performance_Reunification"><span>Réunification - Traitement des dossiers</span></a>
                           </li>

                       </ul>
                   		</li>

                   		<hr>

                      <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#service" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-hand-lizard-o lightgreen_color"></i> <span>Demande de service</span></a>
                        <ul class="collapse list-unstyled" id="service">


                           <li class="<?php if($get_url == 'Attestation_possessions') echo 'active' ?>"><a href="<?php echo base_url() ?>attestations/Attestation_possessions/application"><span>Attestation de possession</span></a></li>

                           <li class="<?php if($get_url == 'Attestation_non_possessions') echo 'active' ?>"><a href="<?php echo base_url() ?>non_possession/Attestation_non_possessions/application"><span>Attestation de non possession</span></a></li>

                            <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Demande d'information</span></a></li>

                              <li class="<?php if($get_url == 'Opposition') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Opposition/application"><span>Demande d'Opposition</span></a></li>

                        
                        </ul>
                     </li>
                    

                      <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#actualisation" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-american-sign-language-interpreting lightgreen_color"></i> <span>Demande d'Actualisation</span></a>
                        <ul class="collapse list-unstyled" id="actualisation">


                           <li class="<?php if($get_url == 'Opposition') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Opposition/application"><span>Augmentation de la superficie</span></a></li>

                           <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Diminution de la superficie</span></a></li>

                            <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Changement d'Usage</span></a></li> 

                              <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Changement du numéro cadastral</span></a></li>

                               <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Changement de plan de la propriété</span></a></li>  

                                <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Incorporation des constructions</span></a></li>  
                                <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Suppression des constructions</span></a></li>  
                          
                        </ul>
                     </li>


                      <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#hypotheque" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-credit-card lightgreen_color"></i> <span>Demande hypothècaire</span></a>
                        <ul class="collapse list-unstyled" id="hypotheque">


                           <li class="<?php if($get_url == 'Opposition') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Opposition/application"><span>Inscription de l'hypothèque</span></a></li>

                           <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Levée de l'hypothèque</span></a></li>

                            <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Rachat de l'hypothèque</span></a></li> 
                          
                        </ul>
                     </li>


                      <li class="">
                        <a href="#miseajour" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-pencil-square-o lightgreen_color"></i> <span>Demande de mise à jour</span></a>
                        <ul class="collapse list-unstyled" id="miseajour">


                           <li class="<?php if($get_url1 == 'maj') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Mise_a_jmrdp/application"><span>Morcellement et Réunification</span></a></li>

                         

                            <li class="<?php if($get_url == 'Mise_a_jr_Deterioration') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Mise_a_jr_Deterioration/application"><span>Détérioration</span></a></li>

                            <li class="<?php if($get_url == 'Mise_a_jr_Perte') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Mise_a_jr_Perte/application"><span>Perte d'un titre de propriété</span></a></li> 
                          
                        </ul>
                     </li>





              <li class="<?php if($get_url1 == 'transfert') echo 'active' ?>"><a href="<?php echo base_url() ?>transfert/Transfert_Propriete"><i class="fa fa-exchange lightgreen_color"></i> <span>Transfert de titre</span></a></li> 

                     <li class="<?php if($get_url1 == '') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Mise_a_jmrdp/application"><i class="fa fa-th-large lightgreen_color"></i> <span>Départements</span></a></li> 

                     <li class="<?php if($get_url1 == '') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Mise_a_jmrdp/application"><i class="fa fa-address-card-o lightgreen_color"></i> <span>Requérants</span></a></li> 

                     
 

                    
                     <hr>


                        <li>
                        <a href="#parametres" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-cog lightgreen_color"></i> <span>Paramètres</span></a>
                        <ul class="collapse list-unstyled" id="parametres">
                           <!-- <li class="activated"><a href="#"><span>Parcelles</span></a></li> -->
                           <li class="<?php if($get_url == 'Parcelle') echo 'active' ?>"><a href="<?php echo base_url() ?>ihm/Parcelle/liste"><span>Parcelles</span></a></li>
                          
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