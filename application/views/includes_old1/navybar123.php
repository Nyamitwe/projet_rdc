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

                      

                     ?>

                     <!-- <li class="<?php if($get_url == 'Application') echo 'active' ?>"><a href="#"><i class="fa fa-tasks lightgreen_color"></i> <span>Applications</span></a></li> -->

                      <li class="<?php if($get_url == 'Traitement_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#application" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tasks lightgreen_color"></i> <span>Applications</span></a>
                        <ul class="collapse list-unstyled" id="application">
                           <li class="<?php if($get_url == 'Titres') echo 'active' ?>"><a href="<?php echo base_url() ?>titres/Titres/index"><span>Obtention du titre foncier définitif</span></a></li>
                           <li class="<?php if($get_url == 'Transfert') echo 'active' ?>"><a href="<?php echo base_url() ?>transfert/Traitement_Transfert_Titre_Foncier/index"><span>Transfert de titres fonciers</span></a></li>
                          
                        </ul>
                     </li>




                      <li class="<?php if($get_url == 'Departement') echo 'active' ?>"><a href="#"><i class="fa fa-th-large lightgreen_color"></i> <span>Departements</span></a></li>

                        <li class="<?php if($get_url == 'Users') echo 'active' ?>"><a href="<?php echo base_url() ?>ihm/Users/liste"><i class="fa fa-user lightgreen_color"></i> <span>Utilisateurs</span></a></li>

                      
                       <li>
                        <a href="#voyageur" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-credit-card lightgreen_color"></i> <span>Facturation</span></a>
                        <ul class="collapse list-unstyled" id="voyageur">
                           <li class="activated"><a href="arrivant.html"><span>Item 1</span></a></li>
                           <li><a href="sortant.html"><span>Item 2</span></a></li>
                        </ul>
                     </li>
                     
                    <!-- transfert/Declaration_Transfert -->

                    <li class="<?php if($get_url == 'Dashboard_Transfert_Titre_Foncier') echo 'active' ?>">
                        <a href="#rapports" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-bar-chart-o lightgreen_color"></i> <span>Rapports</span></a>
                        <ul class="collapse list-unstyled" id="rapports">

                            <li class="<?php if($get_url == 'Dashboard_Transfert_Titre_Foncier') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Transfert_Titre_Foncier"><span>Transfert de titres de propriétés</span></a></li>

                           <li class="<?php if($get_url == 'Dashboard_Titre_Propriete') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Titre_Propriete"><span>Titres de propriétés</span></a>
                           </li>

                           <li class="<?php if($get_url == 'Dashboard_Mise_Jour') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Mise_Jour"><span>Mise à jour de propriétés</span></a>
                           </li>

                           <li class="<?php if($get_url == 'Dashboard_Paiement') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Paiement"><span>Paiement</span></a>
                           </li>

                           <li class="<?php if($get_url == 'Dashboard_Performance') echo 'active' ?>"><a href="<?php echo base_url() ?>dashboard/Dashboard_Performance"><span>Performance</span></a>
                           </li>

                        </ul>
                     </li>


                      
                     
                         <!--  <li class="<?php if($get_url == 'Carte_Transfert') echo 'active' ?>"><a href="<?= base_url() ?>carto/Carte_Transfert"><i class="fa fa-map lightgreen_color"></i> <span>Cartographie</span></a></li>
 -->


                      <li>
                        <a href="#carto" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-map lightgreen_color"></i> <span>Cartographie</span></a>
                        <ul class="collapse list-unstyled" id="carto">
                           
                           <li class="<?php if($get_url == 'Map_Parcelle') echo 'active' ?>"><a href="<?php echo base_url() ?>carto/Map_Parcelle"><span>Parcelles</span></a></li>

                           <li class="<?php if($get_url == 'Carte_Tracking') echo 'active' ?>"><a href="<?php echo base_url() ?>carto/Carte_Tracking"><span>Tracking</span></a></li>
                          
                        </ul>
                     </li>


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