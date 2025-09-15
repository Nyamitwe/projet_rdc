<nav style="background-image: url(<?= base_url() ?>template_ep/images/bg_pms_header.png); background-repeat: no-repeat;background-size: cover" class="navbar navbar-expand-lg navbar-light">
        <div class="full">
            <div class="logo_section mr-4  mb-2">
                <a href="requerant.html"><img class="img-responsive" src="<?= base_url() ?>template_ep/images/DTF_light_logo.png" alt="#" /></a>
            </div>
            <!-- sortie en indivision -->

              <!--   <?php 
                    $sortie=$this->Model->getRequeteOne('SELECT COUNT(*) as non_valid FROM `pms_titre_proprietaire` pro JOIN pms_titre ON pro.`TITRE_ID`=pms_titre.TITRE_ID WHERE pro.`STATUT_ACCORD`=0 AND pro.EST_MORCELLE=0 AND pms_titre.IS_DISPACH=1');


                    $accord=$this->Model->getRequeteOne('SELECT `PROPRIETAIRE_ID`,`STATUT_ACCORD` FROM `pms_titre_proprietaire` WHERE EST_MORCELLE=0 and `PROPRIETAIRE_ID`='.$this->session->userdata('PMS_USER_ID'));

                    $exist=$this->Model->getRequete('SELECT pro.TITRE_PROPRIETAIRE_ID FROM `pms_titre` JOIN pms_titre_proprietaire pro ON pro.TITRE_ID=pms_titre.TITRE_ID JOIN pms_maj_mdrp mdr ON pms_titre.NUMERO_PARCELLE=mdr.NUMERO_PARCELLE WHERE pms_titre.IS_DISPACH=1 AND mdr.EST_CLOTURE=0 AND pro.PROPRIETAIRE_ID='.$this->session->userdata('PMS_USER_ID'));
                ?>

            <div class="dropdown right_topbar mt-4 mr-4">

                <?php 
                    if (!empty($exist)) {?>
                        
                        

                        <?php if ($accord['STATUT_ACCORD']>0) {?>

                            <div class="alert alert-danger" role="alert" style="font-size: 20px;">
                              Indivision <a href="#" class="alert-link"><span style="font-size: 20px;" class="badge badge-danger"><?=$sortie['non_valid'] ?></span></a>
                            </div> 

                        <?php }else{ ?>

                        <div class="alert alert-danger" role="alert" style="font-size: 20px;">
                          Indivision <a href="<?=base_url('perso/Sortir_Indivision/') ?>" class="alert-link"><span style="font-size: 20px;" class="badge badge-danger"><?=$sortie['non_valid'] ?></span></a>
                        </div>

                        <?php } ?>
                        

                    <?php }else{?>
                        <div></div>
                    <?php }
                   ?> -->

                   <!-- fin sortie en indivision -->
                <div class="dropdown right_topbar mt-4 mr-4">
                  
                <a class="text-white dropdown-toggle" role="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text-white font-weight-bold"><i class="fa fa-user-circle"></i> Bienvenu, <?=$this->session->userdata('PMS_NOM')?></span></a>
                <div class="dropdown-menu shadow" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="<?=base_url('index.php/Login/do_logout')?>"><span>Déconnexion</span> <i class="fa fa-sign-out"></i></a>
                </div>
            </div>

        </div>
    </nav>


   <!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->