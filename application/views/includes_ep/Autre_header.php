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
                            <a class="nav-link" href="<?=base_url('Publication_Front_end/')?>">Publications</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Contact/')?>">Contacts</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('New_Requerant')?>">Créer un compte </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Rendez_vous/')?>">Demande</a>
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
                        
                       <!--- <li class="nav-item">
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
                        </li> --->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar end -->
    </header>
    </body>
    <!-- Header end-->