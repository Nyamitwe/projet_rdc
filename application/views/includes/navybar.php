<?php 
if (empty($this->session->userdata('PMS_USER_ID'))) {
    redirect(base_url());
}

$get_url1 = $this->uri->segment(1);
$get_url2 = $this->uri->segment(2);
$get_url3 = $this->uri->segment(3);

// Détection des sections actives
$dashboard_active     = ($get_url1 == 'Traitement_Transfert_Titre_Foncier');
$activites_active     = ($get_url1 == 'Traitement_Transfert_Titre_Foncier2');
$utilisateurs_subpages = ['Utilisateurs', 'New_requerant'];
$utilisateurs_active  = ($get_url1 == 'Utilisateurs' || in_array($get_url2, $utilisateurs_subpages));
$domaines_active      = ($get_url1 == 'Traitement_Transfert_Titre_Foncier4');
$produits_active      = ($get_url1 == 'Traitement_Transfert_Titre_Foncier5');
$factures_active      = ($get_url1 == 'Traitement_Transfert_Titre_Foncier6');
$requetes_active      = ($get_url1 == 'Traitement_Transfert_Titre_Foncier7');
?>

<nav id="sidebar" style="background-image: url('<?= base_url('template/images/bg_sidebar.png') ?>'); background-size: cover; background-repeat: no-repeat;">
    <div class="sidebar_blog_1">
        <div class="sidebar-header">
            <div class="logo_section">
                <a href="#">
                    <img class="logo_icon img-responsive" src="<?= base_url('template/images/logo/Blason_du_Burundi.png') ?>" alt="Logo" />
                </a>
            </div>
        </div>
        <div class="sidebar_user_info text-center">
            <a href="#">
                <img width="150" class="img-responsive" src="<?= base_url('template/images/pms_logo.svg') ?>" alt="Logo PMS" />
            </a>
            <h5 class="text-white">STARAFRICA GROUP</h5>
        </div>
    </div>

    <div class="sidebar_blog_2">
        <ul class="list-unstyled components">

            <!-- PARAMÈTRE -->
            <li class="<?= ($get_url2 == 'Applications') ? 'active' : '' ?>">
                <a href="<?= base_url('applications/Applications/applications') ?>">
                    <i class="fa fa-cogs lightgreen_color"></i> <span>PARAMÈTRE</span>
                </a>
            </li>
            <hr>

            <!-- DASHBOARD -->
            <li class="<?= $dashboard_active ? 'active' : '' ?>">
                <a href="#dashboard1" data-toggle="collapse" aria-expanded="<?= $dashboard_active ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fa fa-tachometer-alt lightgreen_color"></i> <span>DASHBOARD</span>
                </a>
                <ul class="collapse list-unstyled <?= $dashboard_active ? 'show' : '' ?>" id="dashboard1">
                    <li class="<?= ($get_url2 == 'Dashboad_Global_New') ? 'active' : '' ?>">
                        <a href="<?= base_url('dashboard/Dashboad_Global_New') ?>">
                            <span><?= lang('menu_tableau_de_bord_requete') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <hr>

            <!-- ACTIVITÉS -->
            <li class="<?= $activites_active ? 'active' : '' ?>">
                <a href="#dashboard2" data-toggle="collapse" aria-expanded="<?= $activites_active ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fa fa-calendar-check lightgreen_color"></i> <span>ACTIVITÉS</span>
                </a>
                <ul class="collapse list-unstyled <?= $activites_active ? 'show' : '' ?>" id="dashboard2">
                    <li class="<?= ($get_url2 == 'Dashboad_Global_New') ? 'active' : '' ?>">
                        <a href="<?= base_url('dashboard/Dashboad_Global_New') ?>">
                            <span><?= lang('menu_tableau_de_bord_requete') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <hr>

            <!-- UTILISATEURS -->
            <li class="<?= $utilisateurs_active ? 'active' : '' ?>">
                <a href="#dashboard3" data-toggle="collapse" aria-expanded="<?= $utilisateurs_active ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fa fa-user lightgreen_color"></i> <span>UTILISATEURS</span>
                </a>
                <ul class="collapse list-unstyled <?= $utilisateurs_active ? 'show' : '' ?>" id="dashboard3">
                    <li class="<?= ($get_url2 == 'Utilisateurs') ? 'active' : '' ?>">
                        <a href="<?= base_url('utilisateurs/Utilisateurs/') ?>">
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    <li class="<?= ($get_url3 == 'Nouveau') ? 'active' : '' ?>">
                        <a href="<?= base_url('utilisateurs/Utilisateurs/Nouveau') ?>">
                            <span>Nouveau</span>
                        </a>
                    </li>
                </ul>
            </li>
            <hr>

            <!-- DOMAINES -->
            <li class="<?= $domaines_active ? 'active' : '' ?>">
                <a href="#dashboard4" data-toggle="collapse" aria-expanded="<?= $domaines_active ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fa fa-layer-group lightgreen_color"></i> <span>DOMAINES</span>
                </a>
                <ul class="collapse list-unstyled <?= $domaines_active ? 'show' : '' ?>" id="dashboard4">
                    <li class="<?= ($get_url2 == 'Dashboad_Global_New') ? 'active' : '' ?>">
                        <a href="<?= base_url('dashboard/Dashboad_Global_New') ?>">
                            <span><?= lang('menu_tableau_de_bord_requete') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <hr>

            <!-- PRODUITS -->
            <li class="<?= $produits_active ? 'active' : '' ?>">
                <a href="#dashboard5" data-toggle="collapse" aria-expanded="<?= $produits_active ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fa fa-shopping-cart lightgreen_color"></i> <span>PRODUITS</span>
                </a>
                <ul class="collapse list-unstyled <?= $produits_active ? 'show' : '' ?>" id="dashboard5">
                    <li class="<?= ($get_url2 == 'Dashboad_Global_New') ? 'active' : '' ?>">
                        <a href="<?= base_url('dashboard/Dashboad_Global_New') ?>">
                            <span><?= lang('menu_tableau_de_bord_requete') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <hr>

            <!-- FACTURES -->
            <li class="<?= $factures_active ? 'active' : '' ?>">
                <a href="#dashboard6" data-toggle="collapse" aria-expanded="<?= $factures_active ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fa fa-file-invoice-dollar lightgreen_color"></i> <span>FACTURES</span>
                </a>
                <ul class="collapse list-unstyled <?= $factures_active ? 'show' : '' ?>" id="dashboard6">
                    <li class="<?= ($get_url2 == 'Dashboad_Global_New') ? 'active' : '' ?>">
                        <a href="<?= base_url('dashboard/Dashboad_Global_New') ?>">
                            <span><?= lang('menu_tableau_de_bord_requete') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <hr>

            <!-- REQUÊTES -->
            <li class="<?= $requetes_active ? 'active' : '' ?>">
                <a href="#dashboard7" data-toggle="collapse" aria-expanded="<?= $requetes_active ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fa fa-envelope-open-text lightgreen_color"></i> <span>REQUÊTES</span>
                </a>
                <ul class="collapse list-unstyled <?= $requetes_active ? 'show' : '' ?>" id="dashboard7">
                    <li class="<?= ($get_url2 == 'Dashboad_Global_New') ? 'active' : '' ?>">
                        <a href="<?= base_url('dashboard/Dashboad_Global_New') ?>">
                            <span><?= lang('menu_tableau_de_bord_requete') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<style>
    .padding_infor_info {
        padding: 5px;
    }
</style>

