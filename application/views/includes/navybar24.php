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


                      <li class="<?php if($get_url == 'Registres') echo 'active' ?>"><a href="<?php echo base_url() ?>registres/Registres"><i class="fa fa-book lightgreen_color"></i> <span><?= lang('menu_registre') ?></span></a></li>


                       <li class="<?php if($get_url == 'Requerants') echo 'active' ?>"><a href="<?php echo base_url() ?>ihm/Requerants"><i class="fa fa-address-card-o lightgreen_color"></i> <span><?= lang('menu_service_publique') ?></span></a></li>

                       <!-- <li class="<?php if($get_url == 'Demande_Information') echo 'active' ?>"><a href="<?php echo base_url() ?>ihm/Demande_Information"><i class="fa fa-address-card-o lightgreen_color"></i> Demande infos notaire</span></a></li> -->


                       <hr>

                


                        <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tachometer lightgreen_color"></i> <span><?= lang('menu_tableau_de_bord') ?></span></a>
                        <ul class="collapse list-unstyled" id="dashboard">

                        <li class="<?php if($get_url == 'Dashboard_Paiement') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard_Actualisation/Dashboard_Paiement"><span><?= lang('sous_menu_dash_paiement') ?></span></a>
                        </li>

                        <li class="<?php if($get_url == 'Dashboard_Titre_Transfert') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Titre_Transfert"><span>TDB Transfert titre</span></a>
                        </li> 

                        <li class="<?php if($get_url == 'Dashboard_Titre_Transfert') echo 'active' ?>"><a href="#"><span>TDB Demande de service</span></a>
                        </li> 

                        <li class="<?php if($get_url == 'Dashboard_maj') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_maj"><span>TDB Mise à jour</span></a>
                        </li> 

                       

                        <li class="<?php if($get_url == 'Dashboard_Actualisation') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Actualisation"><span>TDB Actualisation</span></a>
                           </li>

                          <li class="<?php if($get_url == 'Dashboard_Hypothecaire') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Hypothecaire"><span>TDB Hypothècaire</span></a>
                           </li> 

                       </ul>
                   		</li>




                        <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#reporting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-pie-chart lightgreen_color"></i> <span><?= 'Reporting' ?></span></a>
                        <ul class="collapse list-unstyled" id="reporting">

                           

                        <li class="<?php if($get_url == 'Rapport_Titre_Transfert') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Rapport_Titre_Transfert"><span><?= 'Transfert de titre de propriété'?></span></a>
                        </li>

                        <li class="<?php if($get_url == 'Dashboard_inscription_hypo') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_inscription_hypo"><span><?= 'Inscription hypothèque'?></span></a>
                        </li>

                         <li class="<?php if($get_url == 'Dashboard_levee_hypo') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_levee_hypo"><span><?= 'Levée hypothèque'?></span></a>
                        </li>

                         <li class="<?php if($get_url == 'Dashboard_rachat_hypo') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_rachat_hypo"><span><?= 'Rachat hypothèque'?></span></a>
                        </li>



                        <li class="<?php if($get_url == 'Dashboard_Morcellement') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Morcellement"><span><?= 'Morcellement'?></span></a>
                        </li>


                        <li class="<?php if($get_url == 'Dashboard_Reunification') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Reunification"><span><?= 'Réunification'?></span></a>
                        </li>


                         <li class="<?php if($get_url == 'Dashboard_Deterioration') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Deterioration"><span><?= 'Détérioration'?></span></a>
                        </li>

                         <li class="<?php if($get_url == 'Dashboard_Perte') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Perte"><span><?= 'Perte d\'un titre de propriété'?></span></a>
                        </li>


                         <li class="<?php if($get_url == 'Dashboard_Aug_Surface') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Aug_Surface"><span><?= 'Augmentation de la superficie'?></span></a>
                        </li>

                         <li class="<?php if($get_url == 'Dashboard_Dim_Surface') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Dim_Surface"><span><?= 'Diminution de la superficie'?></span></a>
                        </li>

                         <li class="<?php if($get_url == 'Dashboard_Chg_Usage') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Chg_Usage"><span><?= 'Changement d\'Usage'?></span></a>
                        </li>

                         <li class="<?php if($get_url == 'Dashboard_Chd_Plan') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Chd_Plan"><span><?= 'Changement du plan de la propriété'?></span></a>
                        </li>


                        <li class="<?php if($get_url == 'Dashboard_Chg_Construction') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Chg_Construction"><span><?= 'Incorporation des constructions'?></span></a>
                        </li>

                        <li class="<?php if($get_url == 'Dashboard_Supr_Construction') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Supr_Construction"><span><?= 'Suppression des constructions'?></span></a>
                        </li>

                       
                       
 

                       </ul>
                      </li>

                   		<hr>

                        <li class="<?php if($get_url == 'Transfert_Propriete_New') echo 'active' ?>"><a href="<?php echo base_url() ?>transfert_new/Transfert_Propriete_New"><i class="fa fa-exchange lightgreen_color"></i> <span><?= lang('menu_transfert_titre') ?></span></a></li>


                      <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#service" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-hand-lizard-o lightgreen_color"></i> <span><?= lang('menu_demande_service') ?></span></a>
                        <ul class="collapse list-unstyled" id="service">


                           <li class="<?php if($get_url == 'Attestation_possessions') echo 'active' ?>"><a href="<?php echo base_url() ?>attestations/Attestation_possessions/application"><span>Attestation de possession</span></a></li>

                           <li class="<?php if($get_url == 'Attestation_non_possessions') echo 'active' ?>"><a href="<?php echo base_url() ?>non_possession/Attestation_non_possessions/application"><span>Attestation de non possession</span></a></li>

                            <li class="<?php if($get_url == 'Demande_Info') echo 'active' ?>"><a href="<?php echo base_url() ?>demande_info/Demande_Info"><span>Demande d'information</span></a></li>
                            
                            <li class="<?php if($get_url == 'Demande_Info_Cas_Notaire') echo 'active' ?>"><a href="<?php echo base_url() ?>demande_info/Demande_Info_Cas_Notaire/application"><span>Demande infos cas du notaire</span></a></li>

                             <!-- <li class="<?php if($get_url == 'Demande_Info_Cas_Notaire') echo 'active' ?>"><a href="<?php echo base_url() ?>demande_info/Demande_Info_Cas_Notaire/application"><i class="fa fa-address-card-o lightgreen_color"></i>Traitement demande infos cas du notaire</span></a></li> -->



                              <li class="<?php if($get_url == 'Opposition') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Opposition/application"><span>Demande d'Opposition</span></a></li>

                              <li class="<?php if($get_url == 'Requisitions') echo 'active' ?>"><a href="<?php echo base_url() ?>requisition/Requisitions/application"><span>Réquisition d'Expert par la justice</span></a></li>

                        
                        </ul>
                     </li>




            




                      <li class="">
                        <a href="#miseajour" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-pencil-square-o lightgreen_color"></i> <span><?= lang('menu_demande_mise_a_jour') ?></span></a>
                        <ul class="collapse list-unstyled" id="miseajour">


                           <li class="<?php if($get_url1 == 'maj') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Mise_a_jr_Morcellement/application"><span>Morcellement</span></a></li>

                           <li class="<?php if($get_url1 == 'Mise_a_Reunification') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Mise_a_Reunification/application"><span>Réunification</span></a></li>

                         

                            <li class="<?php if($get_url == 'Mise_a_jr_Deterioration') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Mise_a_jr_Deterioration/application"><span>Détérioration</span></a></li>

                            <li class="<?php if($get_url == 'Mise_a_jr_Perte') echo 'active' ?>"><a href="<?php echo base_url() ?>maj/Mise_a_jr_Perte/application"><span>Perte d'un titre de propriété</span></a></li> 
                          
                        </ul>
                     </li>









                    

                      <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#actualisation" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-american-sign-language-interpreting lightgreen_color"></i> <span><?= lang('menu_demande_actualisation') ?></span></a>
                        <ul class="collapse list-unstyled" id="actualisation">


                           <li class="<?php if($get_url == 'Augmentations') echo 'active' ?>"><a href="<?php echo base_url() ?>augmentation/Augmentations/application"><span>Augmentation de la superficie</span></a></li>

                           <li class="<?php if($get_url == 'Diminution') echo 'active' ?>"><a href="<?php echo base_url() ?>diminution/Diminution/application"><span>Diminution de la superficie</span></a></li>

                           <li class="<?php if($get_url == 'Changement_Usage') echo 'active' ?>"><a href="<?php echo base_url() ?>changement_usage/Changement_Usage"><span>Changement d'Usage</span></a></li> 

                             <!--  <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Changement du numéro cadastral</span></a></li> -->

                               <li class="<?php if($get_url == 'Plan_Propriete') echo 'active' ?>"><a href="<?php echo base_url() ?>plan_propriete/Plan_Propriete/application"><span>Changement de plan de la propriété</span></a></li>  

                                <li class="<?php if($get_url == 'Incorporation_Construction') echo 'active' ?>"><a href="<?php echo base_url() ?>incorporation/Incorporation_Construction"><span>Incorporation des constructions</span></a></li>  
                                <li class="<?php if($get_url == 'Suppression_Construction') echo 'active' ?>"><a href="<?php echo base_url() ?>suppression/Suppression_Construction"><span>Suppression des constructions</span></a></li>  
                          
                        </ul>
                     </li>


                      <li class="<?php if($get_url1 == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#hypotheque" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-credit-card lightgreen_color"></i> <span><?= lang('menu_demande_hypothecaire') ?></span></a>
                        <ul class="collapse list-unstyled" id="hypotheque">


                           <li class="<?php if($get_url == 'Hypotheque_new') echo 'active' ?>"><a href="<?php echo base_url() ?>hypotheque/Hypotheque_new/application"><span>Inscription de l'hypothèque</span></a></li>

                           <li class="<?php if($get_url == 'Levee_Hypotheque') echo 'active' ?>"><a href="<?php echo base_url() ?>levee_hypotheque/Levee_Hypotheque"><span>Levée de l'hypothèque</span></a></li>

                            <li class="<?php if($get_url == 'Rachat_new') echo 'active' ?>"><a href="<?php echo base_url() ?>rachat/Rachat_new/application"><span>Rachat de l'hypothèque</span></a></li> 
                          
                        </ul>
                     </li>


                      
            
 

                    
                     <hr>


                        <li>
                        <a href="#parametres" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-cogs lightgreen_color"></i> <span><?= lang('menu_administration') ?></span></a>
                        <ul class="collapse list-unstyled" id="parametres">
                           <!-- <li class="activated"><a href="#"><span>Parcelles</span></a></li> -->
                           <li class="<?php if($get_url == 'Droits') echo 'active' ?>"><a href="<?php echo base_url() ?>administration/Droits"><span>Profil et droits</span></a></li>

                           <li class="<?php if($get_url == 'Backend_Users') echo 'active' ?>"><a href="<?php echo base_url() ?>ihm/Backend_Users/liste"><span>Utilisateurs</span></a></li>
                          
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