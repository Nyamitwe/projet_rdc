<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header_pub.php' ?>
</head>

<body>
    <!-- Back to top button -->
    <div class="back-to-top"></div>
    <header>
        <!-- ======= Top Bar start ======= -->
        <section style="background-image: url(<?php echo base_url() ?>template/assets_new/img/bg_pms_header.png)" id="topbar" class="d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-none d-sm-flex align-items-center">
                    <i class="fa fa-envelope d-flex align-items-center"><a class="topbar_icon" href="mailto:contact@pms.gov.bi">contact@pms.gov.bi</a></i>
                    <i class="fa fa-phone"><a class="topbar_icon" href="tel:+25722248153">+257 22 24 81 53 - Bujumbura,</a><a class="topbar_icon" href="tel:+25722402308">+257 22 40 23 08 - Gitega,</a><a class="topbar_icon" href="tel:+25722302385">+257 22 30 23 85 - Ngozi</a></i>
                </div>
                <div class="social-links d-flex align-items-center">
                    <a href=""><i class="fa fa-facebook d-flex align-items-center"></i></a>
                    <a href=""><i class="fa fa-twitter d-flex align-items-center"></i></a>
                </div>
            </div>
        </section>
        <!-- ======= Top Bar end ======= -->
        <!-- Navbar start -->
        <nav class="navbar navbar-expand-lg navbar-light shadow sticky" data-offset="0">
            <div class="container">
                 <a href="#" class="navbar-brand"><img alt="" width='200' src='<?php echo base_url() ?>template/assets_new/img/pms_logo_2.svg'></a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                <div class="navbar-collapse collapse" id="navbarContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Home')?>">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Home/FAQs')?>">FAQs</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="<?=base_url('Publication_Front_end/')?>">Publications</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Contact/')?>">Contacts</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('New_Requerant')?>">Créer un compte acheteur</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Rendez_vous/')?>">Demande Rendez-vous</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item">
                            <a class="mr-4" style="text-decoration: none" href="<?=base_url('Login/')?>">
                                <button class="btn mybtn btn-split">Se connecter
                                    <div class="fab"><i class="fa fa-sign-in"></i></div>
                                </button>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <div class="row d-inline-flex p-5">
                                <div class="col-4">
                                    <a class="font-weight-bold" href="">
                                    <span class="mr-2">
                                    <img src="<?php echo base_url() ?>assets/img/FR.png" alt="French"> 
                                    </span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="">
                                    <span class="mr-4">
                                    <img  src="<?php echo base_url() ?>assets/img/EN.png" alt="english">
                                    </span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar end -->
    </header>
    <!-- Header end-->
    <!-- contact section start -->
    <section style="background-image: url(<?php echo base_url()?>/assets/img/bg_image.png); background-repeat: no-repeat; background-size: cover" class="contact p-3" id="contact">
        <div class="container pt-5">
            <div class="row pb-5">
                <div class="col-md-8">
                    <div style="border-bottom: 1px solid #777;" class="mb-3"><h3 style="text-align: left;">Publications</h3></div>

                    <?php   
                    foreach ($article_plus_lus as $key) {
                        ?>

                        <article class="mb-5 p-3" id="">
                            <header>
                                <div class="meta"><span class="author"><b><i class="fa fa-users"></i></b></span> <span class="date"><i class="fa fa-clock-o"></i> Publié le <?=date('d-m-Y',strtotime($key['DATE_PUBLICATION']))?></span> 
                                </div>

                                <h2>
                                 <a href="">
                                    <?= $key['OBJET_PUBLICATION']?></a></h2> </header>
                                    <div class="entry-content">
                                        <div class="row">
                                            <?php

                                            $fileExtension = pathinfo($key['IMAGE_PUBLICATION'], PATHINFO_EXTENSION);
                                            if($fileExtension=='pdf'){
                                            ?>

                                            <div class="col-lg-6">
                                               <embed src="<?=base_url('uploads/publication/'.$key['IMAGE_PUBLICATION']) ?>#toolbar=0"scrolling="auto" height="400px" width="250%" frameborder="0">
                                               </div>
                                            <?php }else{?>
                                            <div class="col-lg-6">
                                                <a href=""> <img src="<?=base_url('uploads/publication/'.$key['IMAGE_PUBLICATION'])?> " alt="" style="height: 400px; width: 250px " class="img-fluid w-100"/> </a></div>
                                            <?php }?>
                                                <?php 
                                                $pubs=$this->Model->getRequeteone('SELECT  SUBSTR(DESCRIPTION_PUBLICATION,1,300) AS PUBLICATION FROM `pms_publication` WHERE PUBLICATION_ID='.$key['PUBLICATION_ID'].'');
                                                ?> 
                                                <div class="col-lg-6" >
                                                   <center style="text-align: center;">  <p class="lead"><?= $pubs['PUBLICATION']?> &hellip;</p> </center><br>
                                                    <a href="<?=base_url('Publication_Front_end/article/'.$key['PUBLICATION_ID'])?>" class="btn mybtn btn-split">Lire article</a> </div>
                                                </div>
                                            </div>
                                                   
                                                 </article>
                                                <?php   
                                            }

                                            ?>



                                            <hr style="border-top: 2px solid rgba(0, 0, 0, 0.1);">

                                            <!-- <nav aria-label="Page navigation example"> -->
                                              <ul class="pagination">
                                                 <?php

                                                 if(!empty($links)){?>



                                                    <li class="page-item ;"><?=$links?></li>


                                                    <?php                                              
                                                } 
                                                ?>
                                            </ul>
                                            <!-- </nav> -->
                                        </div>
                                        <div class="col-md-4">
                                         <div style="border-bottom: 1px solid #777;" class="mb-3"><h3>Articles les plus lus</h3></div>
                                         <div class="list-group rounded mb-3">

                                           <?php   
                                           foreach ($article_plus_lus as $value) { ?>

                                               <a href="<?=base_url('Publication_Front_end/article/'.$value['PUBLICATION_ID'])?>" class="list-group-item">
                                                   <h4 class="list-group-item-heading"> <?= $value['OBJET_PUBLICATION']?></h4>
                                                   <p class="list-group-item-text"> <?= $value['publication']?> &hellip; </p>
                                                   <div class="meta"><span class="date"><i class="fa fa-clock-o"></i> Publié le <?=date('d-m-Y',strtotime($value['DATE_PUBLICATION']))?></span> 
                                                   </div>
                                               </a>

                                               <?php 
                                           }
                                           ?>

                                       </div>
                                       <div class="container">
                                        <h3>Suivez-nous</h3>
                                        <div class="social"> <a href=""><i class="fa fa-3x fa-facebook-square"></i></a> <a href=""><i class="fa fa-3x fa-twitter-square"></i></a> </div>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </section>
                    <!-- Hero section end-->
                    <!-- Chiffres start -->
                    <section class="wavy-section">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 text-center">
                                    <h6 style="color:#fff" class="sub_title dark_sub_title text-uppercase">Chiffres</h6>
                                    <h2 class="sec_title">
                                        <span><span class="text-white">Le système PMS en quelques chiffres</span></span>
                                    </h2> </div>
                                </div>
                                <div class="row pt-4 d-flex justify-content-center">
                                    <div class="col-lg-4">
                                        <h4 class="numbers text-center">12543</h4>
                                        <p class="text-white text-center">Utilisateurs enregistrés</p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4 class="numbers text-center">405 KM</h4>
                                        <p class="text-white text-center">Superficie en KM2 des propriétés enregistrés</p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4 class="numbers text-center">138</h4>
                                        <p class="text-white text-center">Agents</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Chiffres end -->
                        <!-- Docs start -->
                        <section id="docs" class="doc-section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 text-center">
                                        <h6 style="color:#C10305" class="sub_title dark_sub_title text-uppercase">Infos</h6>
                                        <h2 class="sec_title">
                                            <span><span>Informations supplémentaires</span></span>
                                        </h2> </div>
                                    </div>
                                    <div class="row pt-4 d-flex justify-content-center">
                                        <div class="col-lg-4">
                                            <p class="text-center"><img class="big-hover" src="<?php echo base_url()?>/assets/img/house_icon.png"></p>
                                            <a class="doc-link">
                                                <h4 class="text-center">Pièces à fournir</h4> </a>
                                            </div>
                                            <div class="col-lg-4">
                                                <p class="text-center"><img class="big-hover" src="<?php echo base_url()?>/assets/img/cash_icon.png"></p>
                                                <a class="doc-link">
                                                    <h4 class="text-center">Méthodes de paiement</h4> </a>
                                                </div>
                                                <div class="col-lg-4">
                                                    <p class="text-center"><img class="big-hover" src="<?php echo base_url()?>/assets/img/id_icon.png"></p>
                                                    <a class="doc-link">
                                                        <h4 class="text-center">Types d'utilisateur</h4> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- Docs end -->
                                        <!-- footer start -->
                                        <footer class="footer-05">
                                            <div class="container">
                                                <div class="row border-bottom mb-5 pb-4 align-items-center">
                                                    <div class="col-md-6 mb-md-0 mb-4">
                                                        <h2 class="sec_title_footer text-white">Suivez-nous sur les réseaux sociaux</h2> </div>
                                                        <div class="col-md-6 mb-md-0 mb-4 text-md-right"> <a href=""><i style="font-size: 40px" class="fa fa-twitter text-white"></i></a> <a href=""><i style="font-size: 40px" class="fa fa-facebook text-white ml-2"></i></a> </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-4 mb-md-0 mb-4">
                                                            <h2 class="sec_title_footer">Direction des Titres Fonciers et du Cadastre National</h2>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="featured"> <img width="200" src="<?php echo base_url()?>/assets/img/pms_logo.svg"> </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-md-0 mb-4">
                                                            <h2 class="sec_title_footer">Contacts</h2>
                                                            <div class="block-23 mb-3">
                                                                <ul>
                                                                    <li><i class="fa fa-map-marker mr-2"></i><span class="text"> Province Bujumbura, Commune Mukaza, Qaurtier Rohero</span></li>
                                                                    <li><i class="fa fa-map-marker mr-2"></i><span class="text"> Province Gitega, Commune Gitega, Quartier Musinzira</span></li>
                                                                    <li><i class="fa fa-map-marker mr-2"></i><span class="text"> Province Ngozi, Commune Ngozi, Quartier Gabiro</span></li>
                                                                    <li><a href="tel:+25722248153"><i class="fa fa-phone mr-2"></i><span class="text"> +257 22 24 81 53 - Bujumbura</span></a></li>
                                                                    <li><a href="tel:+25722402308"><i class="fa fa-phone mr-2"></i><span class="text"> +257 22 40 23 08 - Gitega</span></a></li>
                                                                    <li><a href="tel:+25722302385"><i class="fa fa-phone mr-2"></i><span class="text"> +257 22 30 23 85 - Ngozi</span></a></li>
                                                                    <li><a href="mailto:contact@pms.gov.bi"><i class="fa fa-envelope mr-2"></i><span class="text"> contact@pms.gov.bi</span></a></li>
                                                                    <li> </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-md-0 mb-4">
                                                            <h2 class="sec_title_footer">Notre adresse</h2>
                                                            <div class="block-24">
                                                                <div class="row no-gutters">
                                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1991.4265026882297!2d29.371370240041554!3d-3.3860600189492094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19c183ad7b15140b%3A0x976476520828363e!2sDirection%20des%20Titres%20Fonciers!5e0!3m2!1sfr!2sbi!4v1646631869356!5m2!1sfr!2sbi" width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5 pt-4 border-top">
                                                        <div class="col-md-6 col-lg-8">
                                                            <p class="copyright">
                                                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->Copyright &copy;
                                                                <script>
                                                                    document.write(new Date().getFullYear());
                                                                </script> All rights reserved. </p>
                                                            </div>
                                                            <div class="col-md-6 col-lg-4 text-md-right">
                                                                <p class="copyright">Développé par <a href="mediabox.bi" target="_blank">Mediabox <img alt="Mediabox Logo" width="30px" src="<?php echo base_url()?>/assets/img/mediabox_logo.png"></a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </footer>
                                                <!-- footer end -->
                                                <script>
                                                    function myMap() {
                                                        var mapProp = {
                                                            center: new google.maps.LatLng(51.508742, -0.120850),
                                                            zoom: 5,
                                                        };
                                                        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                                                        var marker = new google.maps.Marker({
                                                            position: center
                                                        });
                                                        marker.setMap(map);
                                                    }
                                                </script>
                                                <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
                                                <script src="../assets/js/jquery-3.5.1.min.js"></script>
                                                <script src="../assets/js/bootstrap.bundle.min.js"></script>
                                                <script src="../assets/js/google-maps.js"></script>
                                                <script src="../assets/vendor/wow/wow.min.js"></script>
                                                <script src="../assets/js/theme.js"></script>
                                                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIA_zqjFMsJM_sxP9-6Pde5vVCTyJmUHM&callback=initMap"></script>
                                            </body>

                                            </html>
