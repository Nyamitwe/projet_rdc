

<!-- BLOC RESERVE AU REQUERANT DE TYPE PERSONNE PHYSIQUE -->
<?php if($this->session->userdata('PMS_PROFIL_ID')!=4){?>

 <div style="height:100%; width:100%" class="col-lg-2 card bg-white shadow mb-4">
    <div class="text-center m-4">
        <?php
        $users = $this->session->userdata('PMS_USER_ID');
        $getImg = $this->Model->getOne('sf_guard_user_profile',array('id'=>$users));
        // print_r($this->session->userdata('PMS_PROFIL_ID'));die();
        $getdemande= $this->Model->getRequete('SELECT `ID_TRAITEMENT_DEMANDE` FROM `pms_traitement_demande` WHERE 1 and `ID_REQUERANT`='.$users.' and `STAGE_ID` > 1');
          // print_r($getImg);die();
        if (!empty($getImg['profile_pic'])) {
        ?>

    <?php if($this->session->userdata('PMS_PROFIL_ID')==3 || $this->session->userdata('PMS_PROFIL_ID')>7){
      ?>

    <!-- <img width="100px" src="<?= base_url() ?>uploads/requerant/<?=$getImg['profile_pic']?>">  -->
    <img width="100px" src="<?= base_url() ?>uploads/doc_scanner/<?=$getImg['profile_pic'] ?>">

        <?php }else{?>

 <img width="100px" src="<?= base_url() ?>template_ep/images/avatar_male.png">
       <?php
        }
        ?>
        

<!-- 
         <img width="100px" src="<?= base_url() ?>assets_frontend/images/<?=$getImg['profile_pic']?>">  -->
        <?php
        }else{
        ?>
        <img width="100px" src="<?= base_url() ?>template_ep/images/avatar_male.png">
       


        <?php
        }
        ?>

        
    </div>   
    <div class="col-lg-12 profile-info">
        <h4><?php 
        // print_r($getImg['fullname']);die();
        if (!empty($getImg['nom_entreprise'])) { 
          echo $getImg['nom_entreprise'];
        }else if (!empty($this->session->userdata('PMS_NOM'))) {
         echo $this->session->userdata('PMS_NOM');
        }
         else{ 
          echo $getImg['fullname'];
        } ?>
          </h4>
        <div class="gradient_line"></div> <br>
      <!--   <p><font class="fa fa-user"></font> </p> -->
             <?php
        $TYPE_USERS=$this->Model->getOne('sf_guard_user_categories',array('id'=>$this->session->userdata('TYPE_USER')));
          ?>
        <p><font class="fa fa-phone"></font> <?= $this->session->userdata('PMS_TELEPHONE') ?></p>
        <p><font class="fa fa-envelope"></font> <?= $this->session->userdata('PMS_EMAIL')." (".$TYPE_USERS['description'].")" ?></p>
 
         <?php 
         if (!empty($getImg))  
         {
                if ($getImg['registeras']==2) 
                { 
                    $banque=$this->Model->getRequeteone('SELECT * from pms_requerant_banque join pms_banque on pms_requerant_banque.id_banque=pms_banque.ID_BANQUE  where representant_id='.$getImg['id'].' and statut_representant=1');

                   if (!empty($banque)){ 
                    ?>
                   <h5>Représentant de la banque <?=$banque['BANQUE_DESCR'];?></h5>

                    <?php
                    } 
                }
         }
        ?>
         <?php    if (empty($getdemande)) { 
        ?>
        <a href="<?=base_url('ihm/Users_Front/get_one_user/'.md5($users).'')?>" class='btn btn-sm btn-dark'><i class="fa fa-edit"></i> Modifier le profil</a>

        <?php
         }
        ?>
        <hr>
    </div>
</div>
<?php }elseif($this->session->userdata('PMS_PROFIL_ID')==4){ ?>

 <div style="height:100%; width:100%" class="col-lg-2 card bg-white shadow mb-4">
    <div class="text-center m-4">
        <?php
        $users = $this->session->userdata('PMS_USER_ID');
        $getImg = $this->Model->getOne('sf_guard_user_profile',array('id'=>$users));
        // print_r($getImg);die();

        $getdemande= $this->Model->getRequete('SELECT `ID_TRAITEMENT_DEMANDE` FROM `pms_traitement_demande` WHERE 1 and `ID_REQUERANT`='.$users.' and `STAGE_ID` > 1');

        if (!empty($getImg['profile_pic'])) {
        ?>
        <img width="100px" src="<?=base_url('uploads/notaires/'.$getImg['profile_pic'])?>">
        <?php
        }else{
        ?>
        <img width="100px" src="<?= base_url() ?>template_ep/images/avatar_male.png">
        <?php
        }
        ?>
    </div>   
    <div class="col-lg-12 profile-info">
        <h4><?= $this->session->userdata('PMS_NOM');?></h4>
        <div class="gradient_line"></div> <br>
      <!--   <p><font class="fa fa-user"></font> </p> -->
        <p><font class="fa fa-phone"></font> <?= $this->session->userdata('PMS_TELEPHONE') ?></p>
        <p><font class="fa fa-envelope"></font> <?= $this->session->userdata('PMS_EMAIL') ?></p>
         <?php    if (empty($getdemande)) { 
        ?>
        <a href="<?=base_url('ihm/Users_Front/get_one_user/'.md5($users).'')?>" class='btn btn-sm btn-dark'><i class="fa fa-edit"></i> Modifier le profil</a>

        <?php
         }
        ?>
        <hr>
    </div>
</div>

<?php }   ?>
