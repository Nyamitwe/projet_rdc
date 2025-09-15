      <!DOCTYPE html>
      <html lang="en">
      <head>
        <?php include VIEWPATH.'includes/header.php'; ?>


        <style>
          fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
          }

          legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
          }
          .table td {
            vertical-align: middle;
            border: 1px solid #DFE0E0;
            text-align: center;
            padding: 10px;
          }
        </style>




      </head>
      <body class="dashboard dashboard_1">
        <div class="full_container">
          <div class="inner_container">

            <!-- Sidebar  -->
            <?php include VIEWPATH.'includes/navybar.php'; ?> 
            <!-- end sidebar -->




            <!-- right content -->
            <div id="content">
              <!-- topbar -->
              <?php include VIEWPATH.'includes/topbar.php'; ?> 
              <!-- end topbar -->




              <!-- dashboard inner -->
              <div class="midde_cont">
                <div class="container-fluid">
                 <br>
                 <div class="row column1" style="padding:10px;">
                  <div class="col-md-12">
                   <div class="white_shd full margin_bottom_30">
                    <div class="row full graph_head">
                     <div class="dropdown col-md-3">
                      <button class="btn btn-dark" onclick="history.go(-1)" type="button">
                       <span class="fa fa-reply-all" aria-hidden="true" style="color: white;text-decoration: none;"><?=lang('retour_a_la_correction')?></span>
                     </button>
                   </div>
                   <br>
                   <br>


                   <div class="full price_table padding_infor_info">

                    <!-- <hr> -->

                    <div class="row">
                      <ul class="nav nav-tabs" style="margin-left:20px">
                        <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="#"><?=lang('title_infos_prop')?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#"><?=lang('title_infos_parcel')?></a>
                        </li>
                      </ul>
                    </div>

                    <form name="myform" method="post" class="form-horizontal" action="<?= base_url('administration/Numerisation/add_info_requerant'); ?>"  enctype="multipart/form-data">
                    <!-- <form name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Numeriser/add_info_requerant'); ?>"  enctype="multipart/form-data"> -->
                      <div class="tab" id="requerant_info">
                       <div class="row">
                      
                        <div class="col-md-6" style="margin-top:10px">
                          <label><?=lang('type_requerant')?><font class="text-danger">*</font></label>
                          <select class="form-control"  name="type_requerant_id"  id="type_requerant_id">
                            <option value="">Sélectionner</option>
                            <?php foreach($types_requerants as $types_requerant) { 
                              if ($types_requerant['id']==set_value('type_requerant_id')) { 
                                echo "<option value='".$types_requerant['id']."' selected>".$types_requerant['name']."</option>";
                              }  else{
                                echo "<option value='".$types_requerant['id']."' >".$types_requerant['name']."</option>"; 
                              } }?>                                                              
                            </select> 
                            <?php echo form_error('type_requerant_id', '<div class="text-danger">', '</div>'); ?>
                            <span id="errtype_requerant_id" class="text-danger"></span>
                          </div>

                          <div class="col-md-6" style="margin-top:10px">
                            <label><?=lang('nationalite')?><font class="text-danger">*</font></label>
                            <select class="form-control info_perso_nationalite"  name="nationalite_id"  id="nationalite_id">
                              <option value=""><?=lang('selectionner')?></option>
                              <?php foreach($nationalites as $nationalite) { 
                                if ($nationalite['id']==set_value('type_requerant_id')) { 
                                  echo "<option value='".$nationalite['id']."' selected>".$nationalite['name']."</option>";
                                }  else{
                                  echo "<option value='".$nationalite['id']."' >".$nationalite['name']."</option>"; 
                                } }?>                                                              
                              </select> 
                              <?php echo form_error('nationalite_id', '<div class="text-danger">', '</div>'); ?>
                              <span id="errnationalite_id" class="text-danger"></span>                                
                            </div>

                          </div>

                          <div class="col-md-12"></div><br>

                          <div class="row col-md-12 info_perso_physique" <?=$info_physique?>>
                            <div class="row">

                              <div class="col-md-4">
                                <label><?=lang('label_nom_users')?><font class="text-danger">*</font></label>
                                <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_PROP" name="NOM_PRENOM_PROP" value="<?=set_value('NOM_PRENOM_PROP')?>">
                                <?php echo form_error('NOM_PRENOM_PROP', '<div class="text-danger">', '</div>'); ?>
                                <span id="errNOM_PRENOM_PROP" class="text-danger"></span> 
                              </div>

                              <div class="col-md-4">
                                <label>Genre<font class="text-danger">*</font></label>
                                <select class="form-control"  name="SEXE_ID"  id="SEXE_ID">
                                  <option value="">Sélectionner</option>
                                  <?php foreach($sexes as $sexe) { 
                                    if ($sexe['SEXE_ID']==set_value('SEXE_ID')) { 
                                      echo "<option value='".$sexe['SEXE_ID']."' selected>".$sexe['DESCRIPTION_SEXE']."</option>";
                                    }  else{
                                      echo "<option value='".$sexe['SEXE_ID']."' >".$sexe['DESCRIPTION_SEXE']."</option>"; 
                                    } }?>                                                              
                                  </select> 
                                  <?php echo form_error('SEXE_ID', '<div class="text-danger">', '</div>'); ?>
                                  <span id="errsexe_id" class="text-danger"></span> 
                              </div>

                              <div class="col-md-4">
                                <label><?=lang('date_naissance')?><font class="text-danger">*</font></label>
                                <input type="date" class="form-control" name="DATE_NAISSANCE" id="DATE_NAISSANCE" max="<?=date('Y-m-d')?>" value="<?=set_value('DATE_NAISSANCE')?>" onchange="validateAge(this)">
                                <?php echo form_error('DATE_NAISSANCE', '<div class="text-danger">', '</div>'); ?> 
                                <span id="errDATE_NAISSANCE" class="text-danger"></span>  
                                <div id="error_alert" style="color: red;"></div>
                              </div>

                            </div>


                            <div class="col-md-12"></div><br>

                            <div class="row">

                              <div class="col-md-6">
                                <label><?=lang('labelle_photo_num')?><font class="text-danger"></font></label>
                                <input type="file" class="form-control" name="PHOTO_PASSEPORT_PROP" id="PHOTO_PASSEPORT_PROP" accept=".png, .jpg, .jpeg">
                                <?php echo form_error('PHOTO_PASSEPORT_PROP', '<div class="text-danger">', '</div>'); ?>
                                <div><font color="red" id="error_profile"></font></div> 
                                <span id="errPHOTO_PASSEPORT_PROP" class="text-danger"></span>  
                                <div id="error_alert" style="color: red;"></div>
                                <div id="errorMessage" style="color: red;"></div>
                              </div>

                              <div class="col-md-6">
                                <label><?=lang('signature_requerant')?><font class="text-danger">*</font></label>
                                <input type="file" class="form-control" name="SIGNATURE_PROP" id="SIGNATURE_PROP" accept=".png, .jpg, .jpeg">
                                <?php echo form_error('SIGNATURE_PROP', '<div class="text-danger">', '</div>'); ?> 
                                <div><font color="red" id="error_signature"></font></div> 
                                <span id="errSIGNATURE_PROP" class="text-danger"></span> 
                                <div id="errorMessage" style="color: red;"></div>


                              </div>
                              
                            </div>

                            <div class="col-md-12"></div><br>

                            <div class="row">
                              <div class="col-md-3">
                                <label><?=lang('num_cni_passport')?><font class="text-danger">*</font></label>
                                <input type="text" class="form-control" id="NUM_CNI_PROP" name="NUM_CNI_PROP" value="<?=set_value('NUM_CNI_PROP')?>">

                                <?php echo form_error('NUM_CNI_PROP', '<div class="text-danger">', '</div>'); ?>
                                <span id="errNUM_CNI_PROP" class="text-danger"></span>  
                                
                              </div>


                              <div class="col-md-3">
                                <label><?=lang('image_cni_passport')?><font class="text-danger">*</font></label>
                                <input type="file" class="form-control" name="CNI_IMAGE_PROP" accept=".pdf">
                                <input type="hidden" class="form-control" name="CNI_IMAGE_PROP_NEW" value="<?=set_value('CNI_IMAGE_PROP')?>">
                                <?php echo form_error('CNI_IMAGE_PROP', '<div class="text-danger">', '</div>'); ?>
                                <span id="errCNI_IMAGE_PROP" class="text-danger"></span>  
                                
                              </div>

                              <div class="col-md-3">
                                <label><?=lang('date_delivrance')?><font class="text-danger">*</font></label>
                                <input type="date" class="form-control" id="DATE_DELIVRANCE" name="DATE_DELIVRANCE" max="<?=date('Y-m-d')?>"  value="<?=set_value('DATE_DELIVRANCE')?>">
                                <?php echo form_error('DATE_DELIVRANCE', '<div class="text-danger">', '</div>'); ?>
                                <span id="errDATE_DELIVRANCE" class="text-danger"></span>                                  
                              </div>



                              <div class="col-md-3">
                                <label><?=lang('lieu_delivrance')?><font class="text-danger">*</font></label>
                                <input type="text" class="form-control" oninput="validateInput(this)" id="LIEU_DELIVRANCE"  name="LIEU_DELIVRANCE" maxlength="100"  value="<?=set_value('LIEU_DELIVRANCE')?>">
                                <?php echo form_error('LIEU_DELIVRANCE', '<div class="text-danger">', '</div>'); ?>
                                <span id="errLIEU_DELIVRANCE" class="text-danger"></span>                                  
                                
                              </div>

                            </div>

                            <div class="col-md-12"></div><br>

                            <div class="row">

                              <div class="col-md-6">
                                <label><?=lang('email')?><font class="text-danger">*</font></label>
                                <input type="email" autocomplete="off" class="form-control" name="EMAIL_PROP" id="EMAIL_PROP" value="<?=set_value('EMAIL_PROP')?>">
                                <?php echo form_error('EMAIL_PROP', '<div class="text-danger">', '</div>'); ?>
                                <span id="errEMAIL_PROP" class="text-danger"></span>                                  
                              </div>

                              <div class="col-md-6">
                                <label><?=lang('numero_telephone')?><font class="text-danger">*</font></label>
                                <input type="text" class="form-control" oninput="validatePhoneNumber(this)" minlength="8" maxlength="12" id="NUM_TEL_PROP" name="NUM_TEL_PROP"  value="<?=set_value('NUM_TEL_PROP')?>" autocomplete="off">
                                <?php echo form_error('NUM_TEL_PROP', '<div class="text-danger">', '</div>'); ?> 
                                <div id="error-message" style="color: red;"></div>
                                <span id="errNUM_TEL_PROP" class="text-danger"></span> 
                              </div>

                            </div>
                            <div class="col-md-12"></div><br>
                            <div class="row">
                              <div class="col-md-6">
                                <label><?=lang('nom_prenom_pere')?><font class="text-danger">*</font></label>
                                <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_PERE" name="NOM_PRENOM_PERE" value="<?=set_value('NOM_PRENOM_PERE')?>">
                                <?php echo form_error('NOM_PRENOM_PERE', '<div class="text-danger">', '</div>'); ?>
                                <span id="errNOM_PRENOM_PERE" class="text-danger"></span>                                 
                              </div>

                              <div class="col-md-6">
                                <label><?=lang('nom_prenom_mere')?><font class="text-danger">*</font></label>
                                <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_MERE" name="NOM_PRENOM_MERE" value="<?=set_value('NOM_PRENOM_MERE')?>">
                                <?php echo form_error('NOM_PRENOM_MERE', '<div class="text-danger">', '</div>'); ?>
                                <span id="errNOM_PRENOM_MERE" class="text-danger"></span>                                   
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12"></div>

                            <div  class="row info_localite_naissance">

                              <div class="col-md-3" <?=$info_prov_naissance?>>
                                <label><?=lang('label_province_naissance')?><font class="text-danger">*</font></label>
                                <select class="form-control" onchange="get_communes_naissance(this.value)"  name="PROVINCE_ID" id="PROVINCE_ID">
                                  <option value=""><?=lang('selectionner')?></option>
                                  <?php foreach($provinces_naissance as $province) { 
                                    if ($province['PROVINCE_ID']==set_value('PROVINCE_ID')) { 
                                      echo "<option value='".$province['PROVINCE_ID']."' selected>".$province['PROVINCE_NAME']."</option>";
                                    }  else{
                                      echo "<option value='".$province['PROVINCE_ID']."' >".$province['PROVINCE_NAME']."</option>"; 
                                    } }?>                                                              
                                  </select>
                                  <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?>
                                  <span id="errPROVINCE_ID" class="text-danger"></span>                                  
                                </div>


                                <div class="col-md-3" <?=$info_com_naissance?>>
                                  <label><?=lang('label_commune_naissance')?><font class="text-danger">*</font></label>
                                  <select class="form-control" onchange="get_zones_naissance(this.value)" name="COMMUNE_ID" id="COMMUNE_ID">
                                    <option value=""><?=lang('selectionner')?></option>
                                    <?php if(!empty($communes)){
                                      foreach($communes as $commune){?>

                                        <option value="<?=$commune['COMMUNE_ID']?>" <?php if ($commune['COMMUNE_ID']==set_value('COMMUNE_ID')) echo "selected";?> ><?=$commune['COMMUNE_NAME']?></option>
                                      <?php } }?>
                                    </select>
                                    <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?>
                                    <span id="errCOMMUNE_ID" class="text-danger"></span>                                
                                  </div>


                                  <div class="col-md-3" <?=$info_zon_naissance?>>
                                    <label><?=lang('label_zone')?><font class="text-danger">*</font></label>
                                    <select class="form-control" onchange="get_collines_naissance(this.value)"  name="ZONE_ID" id="ZONE_ID">
                                      <option value=""><?=lang('selectionner')?></option>
                                      <?php if(!empty($zones)){

                                        foreach($zones as $zone){?>

                                          <option value="<?=$zone['ZONE_ID']?>" <?php if ($zone['ZONE_ID']==set_value('ZONE_ID')) echo "selected";?> ><?=$zone['ZONE_NAME']?></option>
                                        <?php } }?>
                                      </select>
                                      <?php echo form_error('ZONE_ID', '<div class="text-danger">', '</div>'); ?> 
                                      <span id="errZONE_ID" class="text-danger"></span>                                                                               
                                    </div>

                                    <div class="col-md-3" <?=$info_col_naissance?>>
                                      <label><?=lang('label_colline')?><font class="text-danger">*</font></label>
                                      <select class="form-control" name="COLLINE_ID" id="COLLINE_ID">
                                        <option value=""><?=lang('selectionner')?></option>
                                        <?php if(!empty($collines_parcelles)){

                                          foreach($collines_parcelles as $colline){?>

                                            <option value="<?=$colline['COLLINE_ID']?>" <?php if ($colline['COLLINE_ID']==set_value('COLLINE_ID')) echo "selected";?> ><?=$colline['COLLINE_NAME']?></option>
                                          <?php } }?>
                                        </select>
                                        <?php echo form_error('COLLINE_ID', '<div class="text-danger">', '</div>'); ?>  
                                        <span id="errCOLLINE_ID" class="text-danger"></span>                                                                               
                                      </div>

                                </div>
                                <div class="col-md-12"></div>
                              <div class="row col-md-12 info_perso_morale" <?=$info_morale?>>

       

                                  <div class="col-md-4">
                                    <label>Nom Entreprise<font class="text-danger">*</font></label>
                                    <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_ENTREPRISE" name="NOM_ENTREPRISE">
                                    <?php echo form_error('NOM_ENTREPRISE', '<div class="text-danger">', '</div>'); ?>   

                                    <span id="errNOM_ENTREPRISE" class="text-danger"></span>                           

                                  </div>

                                  <div class="col-md-4">
                                    <label><?=lang('label_nom_representant')?><font class="text-danger">*</font></label>
                                    <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_REPRESENTANT" name="NOM_REPRESENTANT">
                                    <?php echo form_error('NOM_REPRESENTANT', '<div class="text-danger">', '</div>'); ?>   

                                    <span id="errNOM_REPRESENTANT" class="text-danger"></span>                           

                                  </div>

                                  <div class="col-md-4">
                                    <label>Mail du Representant<font class="text-danger">*</font></label>
                                    <input type="email" class="form-control" id="EMAIL_REPRESENTANT" name="EMAIL_REPRESENTANT">
                                    <?php echo form_error('EMAIL_REPRESENTANT', '<div class="text-danger">', '</div>'); ?> 
                                    <span id="errEMAIL_REPRESENTANT" class="text-danger"></span>                           
                                  </div>


                                <div class="col-md-12"></div>

                                  <div class="col-md-6">
                                    <label>Numero de Téléphone du Representant<font class="text-danger">*</font></label>
                                    <input type="text" class="form-control" oninput="validatePhoneNumber(this)" id="TELEPHONE_REPRESENTANT" name="TELEPHONE_REPRESENTANT" minlength="8" maxlength="12"0>
                                    <?php echo form_error('TELEPHONE_REPRESENTANT', '<div class="text-danger">', '</div>'); ?>   
                                    <span id="errTELEPHONE_REPRESENTANT" class="text-danger"></span>                       
                                  </div>

                                  <div class="col-md-6">
                                    <label><?=lang('nif_rc')?><font class="text-danger">*</font></label>
                                    <input type="text" class="form-control" id="NIF_RC" name="NIF_RC">
                                    <?php echo form_error('NIF_RC', '<div class="text-danger">', '</div>'); ?>   

                                    <span id="errNIF_RC" class="text-danger"></span>                       

                                  </div>
                              

                                <div class="col-md-12"></div>

                                <div class="col-md-6">
                                  <label>Signature du Representant<font class="text-danger">*</font></label>
                                  <input type="file" class="form-control" name="SIGNATURE_REPRESENTANT" id="SIGNATURE_REPRESENTANT" accept=".png, .jpg, .jpeg">
                                  <?php echo form_error('SIGNATURE_REPRESENTANT', '<div class="text-danger">', '</div>'); 
                                  ?> 
                                  <div><font color="red" id="error_signatureRepresentant"></font></div> 
                                  <span id="errSIGNATURE_REPRESENTANT" class="text-danger"></span>
                                  <div id="errorMessage" style="color: red;"></div>                            
                                </div>

                              </div>

                              <button id="btn_step1" type="button" style="margin-top: 20px; float: right;" class="my-4 btn btn-primary" onclick="toggleTabs()">Suivant&nbsp;&nbsp; <i class="fa fa-arrow-circle-right"></i> <span id="loading_step1"></span></button>
                            </div> 
                            <div class="tab" id="parcelle_info" style="display: none;">
                              <div class="row">
                                <div class="col-md-12 py-2"> 
                                 <!-- <h5 style="color: #1d2653" class="text-left ml-0"><b>INFORMATIONS DU REPRESANTANT</b></h5> -->
                               </div>
                               <div class="col-md-4">
                                <label><?=lang('label_parcelle_number')?><font class="text-danger">*</font></label>
                                <input type="text" oninput="validateValueParcelle(this)"  class="form-control" name="NUM_PARCEL" id="NUM_PARCEL">
                                <?php echo form_error('NUM_PARCEL', '<div class="text-danger">', '</div>'); ?>    
                                <span id="errNUM_PARCEL" class="text-danger"></span>                              
                              </div>
                              <div class="col-md-4">
                                <label><?=lang('nature_dossier')?><font class="text-danger">*</font></label>
                                <select class="form-control"  name="NATURE_DOC" id="NATURE_DOC">
                                  <option value=""><?=lang('selectionner')?></option>
                                  <?php foreach($type_nature_docs as $type_nature_doc) { 
                                    if ($type_nature_doc['ID_DOSSIER']==set_value('ID_DOSSIER')) { 
                                      echo "<option value='".$type_nature_doc['ID_DOSSIER']."' selected>".$type_nature_doc['DOSSIER']."</option>";
                                    }  else{
                                      echo "<option value='".$type_nature_doc['ID_DOSSIER']."' >".$type_nature_doc['DOSSIER']."</option>"; 
                                    } }?>                                                              
                                  </select>
                                  <?php echo form_error('NATURE_DOC', '<div class="text-danger">', '</div>'); ?>  
                                  <span id="errNATURE_DOC" class="text-danger"></span>                                   
                                </div>

                                <div class="col-md-4">
                                  <label><?=lang('num_ordre_special')?><font class="text-danger">*</font></label>
                                  <input type="text" class="form-control" oninput="validateInfo(this)" name="NUMERO_SPECIAL" id="NUMERO_SPECIAL" value="<?=set_Value('NUMERO_SPECIAL')?>">
                                  <?php echo form_error('NUMERO_SPECIAL', '<div class="text-danger">', '</div>'); ?>   
                                  <span id="errNUMERO_SPECIAL" class="text-danger"></span>                                   
                                </div>

                                <div class="col-md-12"></div>

                                <div class="col-md-6">
                                  <label>Volume<font class="text-danger">*</font></label>
                                  <input type="text" oninput="validateInfoVolume(this)" class="form-control" name="VOLUME" id="VOLUME" value="<?=set_Value('VOLUME')?>">
                                  <?php echo form_error('VOLUME', '<div class="text-danger">', '</div>'); ?>  
                                  <span id="errVOLUME" class="text-danger"></span>                                                                                  
                                </div>


                                <div class="col-md-6">
                                  <label>Folio<font class="text-danger">*</font></label>
                                  <input type="text" oninput="validateInfoFolio(this)" class="form-control" name="FOLIO" id="FOLIO" value="<?=set_Value('FOLIO')?>">
                                  <?php echo form_error('FOLIO', '<div class="text-danger">', '</div>'); ?>  
                                  <span id="errFOLIO" class="text-danger"></span>                                                                                 
                                </div>


                                <div class="col-md-12"></div><br>

                                <div class="col-md-4">
                                  <label><?=lang('superficie_ha')?><font class="text-danger">*</font></label>
                                  <input type="text"  oninput="validateInfoFolio(this)" class="form-control" name="SUPER_HA" id="SUPER_HA" value="<?=set_Value('SUPER_HA')?>">
                                  <?php echo form_error('SUPER_HA', '<div class="text-danger">', '</div>'); ?>   
                                  <span id="errSUPER_HA" class="text-danger"></span>                                                                                
                                </div>                         


                                <div class="col-md-4">
                                  <label><?=lang('superficie_a')?><font class="text-danger">*</font></label>
                                  <input type="text"  oninput="validateInfoFolio(this)" class="form-control" name="SUPER_ARE" id="SUPER_ARE" value="<?=set_Value('SUPER_ARE')?>">
                                  <?php echo form_error('SUPER_ARE', '<div class="text-danger">', '</div>'); ?>  
                                  <span id="errSUPER_ARE" class="text-danger"></span>                                                                                
                                </div> 

                                <div class="col-md-4">
                                  <label><?=lang('superficie_ca')?><font class="text-danger">*</font></label>
                                  <input type="text"   oninput="validateInfoFolio(this)"  class="form-control" name="SUPER_CA" id="SUPER_CA"  value="<?=set_Value('SUPER_CA')?>">
                                  <?php echo form_error('SUPER_CA', '<div class="text-danger">', '</div>'); ?> 
                                  <span id="errSUPER_CA" class="text-danger"></span>                                                                                
                                </div> 


                                <div class="col-md-12"></div><br>

                                <div class="col-md-3">
                                  <label><?=lang('label_province')?><font class="text-danger">*</font></label>
                                  <select class="form-control" onchange="get_communes(this.value)"  name="PROVINCE_ID1" id="PROVINCE_ID1">
                                    <option value=""><?=lang('selectionner')?></option>
                                    <?php foreach($provinces as $province) { 
                                      if ($province['PROVINCE_ID']==set_value('PROVINCE_ID1')) { 
                                        echo "<option value='".$province['PROVINCE_ID']."' selected>".$province['PROVINCE_NAME']."</option>";
                                      }  else{
                                        echo "<option value='".$province['PROVINCE_ID']."' >".$province['PROVINCE_NAME']."</option>"; 
                                      } }?>                                                              
                                    </select>
                                    <?php echo form_error('PROVINCE_ID1', '<div class="text-danger">', '</div>'); ?>
                                    <span id="errPROVINCE_ID1" class="text-danger"></span>                                                                                
                                  </div>


                                  <div class="col-md-3">
                                    <label><?=lang('label_commune')?><font class="text-danger">*</font></label>
                                    <select class="form-control" onchange="get_zones(this.value)"  name="COMMUNE_ID1" id="COMMUNE_ID1">
                                      <option value=""><?=lang('selectionner')?></option>
                                      <?php if(!empty($communes_parcelles)){

                                        foreach($communes_parcelles as $commune){?>

                                          <option value="<?=$commune['COMMUNE_ID']?>" <?php if ($commune['COMMUNE_ID']==set_value('COMMUNE_ID1')) echo "selected";?> ><?=$commune['COMMUNE_NAME']?></option>
                                        <?php } }?>
                                      </select>
                                      <?php echo form_error('COMMUNE_ID1', '<div class="text-danger">', '</div>'); ?> 
                                      <span id="errCOMMUNE_ID1" class="text-danger"></span>                                                                               
                                    </div>

                                    <div class="col-md-3">
                                      <label><?=lang('label_zone')?><font class="text-danger">*</font></label>
                                      <select class="form-control" onchange="get_collines(this.value)"  name="ZONE_ID1" id="ZONE_ID1">
                                        <option value=""><?=lang('selectionner')?></option>
                                        <?php if(!empty($zones_parcelles)){

                                          foreach($zones_parcelles as $zone){?>

                                            <option value="<?=$zone['ZONE_ID']?>" <?php if ($zone['ZONE_ID']==set_value('ZONE_ID1')) echo "selected";?> ><?=$zone['ZONE_NAME']?></option>
                                          <?php } }?>
                                        </select>
                                        <?php echo form_error('ZONE_ID1', '<div class="text-danger">', '</div>'); ?> 
                                        <span id="errZONE_ID1" class="text-danger"></span>                                                                               
                                      </div>

                                      <div class="col-md-3">
                                        <label><?=lang('label_colline')?><font class="text-danger">*</font></label>
                                        <select class="form-control" name="COLLINE_ID1" id="COLLINE_ID1">
                                          <option value=""><?=lang('selectionner')?></option>
                                          <?php if(!empty($collines_parcelles)){

                                            foreach($collines_parcelles as $colline){?>

                                              <option value="<?=$colline['COLLINE_ID']?>" <?php if ($colline['COLLINE_ID']==set_value('COLLINE_ID1')) echo "selected";?> ><?=$colline['COLLINE_NAME']?></option>
                                            <?php } }?>
                                          </select>
                                          <?php echo form_error('COLLINE_ID1', '<div class="text-danger">', '</div>'); ?>  
                                          <span id="errCOLLINE_ID1" class="text-danger"></span>                                                                               
                                        </div>

                                        <div class="col-md-12"></div><br>

                                        <div class="col-md-6">
                                          <label>Usage<font class="text-danger">*</font></label>
                                          <select class="form-control"  name="USAGE" id="USAGE">
                                            <option value=""><?=lang('selectionner')?></option>
                                            <?php foreach($usagers_proprietes as $usager_propriete) { 
                                              if ($usager_propriete['ID_USAGER_PROPRIETE']==set_value('USAGE')) { 
                                                echo "<option value='".$usager_propriete['ID_USAGER_PROPRIETE']."' selected>".$usager_propriete['DESCRIPTION_USAGER_PROPRIETE']."</option>";
                                              }  else{
                                                echo "<option value='".$usager_propriete['ID_USAGER_PROPRIETE']."' >".$usager_propriete['DESCRIPTION_USAGER_PROPRIETE']."</option>"; 
                                              } }?>                                                              
                                            </select>
                                            <?php echo form_error('USAGE', '<div class="text-danger">', '</div>'); ?>   
                                            <span id="errUSAGE" class="text-danger"></span>                                                                               
                                          </div>


                                          <div class="col-md-6">
                                            <label><?=lang('numero_cadastral')?><font class="text-danger">*</font></label>
                                            <input type="text" oninput="validateValueParcelle(this)" class="form-control" name="NUM_CADASTRE" id="NUM_CADASTRE" value="<?=set_Value('NUM_CADASTRE')?>">
                                            <?php echo form_error('NUM_CADASTRE', '<div class="text-danger">', '</div>'); ?>  
                                            <span id="errNUM_CADASTRE" class="text-danger"></span>                                                                               
                                          </div>  
                                        </div>

                                        <div class="row">

                                          <div style="margin-top: 20px; overflow: auto;">
                                            <div style="float: left;">
                                              <button id="btn_retour" type="button" style="margin-right: 10px; display: none;" class="my-4 btn btn-primary" onclick="toggleTabs()">
                                                Retour&nbsp;&nbsp; <i class="fa fa-arrow-circle-left"></i> <span id="loading_retour"></span>
                                              </button>
                                            </div>
                                          </div>

                                          <div style="margin-top: 20px; overflow: auto;">
                                            <div style="float: right;">
                                              <button id="btn_enregistrer" type="button" style="margin-left: 10px;" class="my-4 btn btn-success" onclick="buttonSave()">
                                                Enregistrer
                                              </button>
                                            </div>
                                          </div>

                                        </div>


                                      </div> 

                                    </form>


                                  </div>
                                </div>
                              </div>
                              <!-- end row -->
                            </div>
                          </div></div></div>

                          <?php include VIEWPATH.'includes/scripts_oposition_js.php'; ?>

                          <link rel="stylesheet" href="/resources/demos/style.css">
                          <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
                          <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
                          <script src="<?php echo base_url() ?>template/js/bootstrap.min.js"></script>



                        </body>
                        </html> 

                        <!-- controle age >= à 18 -->
                        <script>
                          function validateAgeold(input) {
                            const submitButton = document.getElementById('submitButton');
                            var selectedDate = new Date(input.value);
                            var currentDate = new Date();
                            var minDate = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());
                            submitButton.disabled = false;
                            $('#error_alert').html('');
                            if(selectedDate > minDate)
                            {
                              $('#error_alert').html('Le requerant doit avoir au minimum 18 ans');
      // Disable the submit button
                              submitButton.disabled = true;
    input.value = ""; // Clear the selected date
  }
}
</script>
  <!-- controle age >= à 18 -->
  <script>
function validateAge(input) {
  const btn_step1 = document.getElementById('btn_step1');
  var selectedDate = new Date(input.value);
  var currentDate = new Date();
  var minDate = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());
  btn_step1.disabled = false;
  $('#error_alert').html('');

  if(selectedDate > minDate)
  {
    $('#error_alert').html('Le requerant doit avoir au minimum 18 ans');
      // Disable the submit button
      btn_step1.disabled = true;
    input.value = ""; // Clear the selected date
  }
}
</script>
<!-- verification de la signature -->
<script>
  // Function to handle file input change
  function handleFileInput(fileInput, errorMessage) {
    // Get the file input element and submit button
    const file = fileInput.files[0];
    const btn_step1 = document.getElementById('btn_step1');
    $('#errorMessage').html('');

    // Check if the file is an image
    if (file && file.type.includes('image')) {
      // Enable the submit button
      btn_step1.disabled = false;
      errorMessage.textContent = '';
    } else {
      // Disable the submit button
      btn_step1.disabled = true;
      errorMessage.textContent = 'Veuillez uploader un fichier de type image';
      $('#errorMessage').html('Veuillez uploader un fichier de type image');
    }
  }

  // Get the file input elements and error messages
  const fileSignature = document.getElementById('SIGNATURE_PROP');
  const fileSignatureRepresentant = document.getElementById('SIGNATURE_REPRESENTANT');
  const filePhoto = document.getElementById('PHOTO_PASSEPORT_PROP');
  const errorSignature = document.getElementById('error_signature');
  const errorSignatureRepresentant = document.getElementById('error_signatureRepresentant');
  const errorPhoto = document.getElementById('error_photo');

  // Add event listeners to the file input elements
  fileSignature.addEventListener('change', function () {
    handleFileInput(fileSignature, errorSignature);
  });


    // Add event listeners to the file input elements
  fileSignatureRepresentant.addEventListener('change', function () {
    handleFileInput(fileSignatureRepresentant, errorSignatureRepresentant);
  });


  filePhoto.addEventListener('change', function () {
    handleFileInput(filePhoto, errorPhoto);
  });
</script>








<!-- verification de l UPLOAD DE LA CNI
<script>
// Get the file input element and submit button
const filePDF = document.getElementById('CNI_IMAGE_PROP');
const submitButton = document.getElementById('submitButton');

// Add an event listener to the file input element
filePDF.addEventListener('change', function() {
  // Get the selected file
  const file = filePDF.files[0];

  // Check if the file is a PDF
  if (file && file.type === 'application/pdf') {
    // Enable the submit button
    submitButton.disabled = false;
  } else {
    // Disable the submit button
    submitButton.disabled = true;
  }
});
</script> -->

<script>
  $(document).ready(function() {
  //gestion info à saisir par rapport au type de requerant
    $('#type_requerant_id').on('change', function() {
      let val_sel2 = $('#type_requerant_id').val();
    // alert(val_sel2);

      if (val_sel2 == 5) {
        $('.info_perso_morale').show();
        $('.info_localite_naissance').show();        
        $('.info_perso_physique').hide();
      } else if (val_sel2 == 1) {
        $('.info_perso_physique').show();
        $('.info_localite_naissance').show();      
        $('.info_perso_morale').hide();
      }
    });
  });
</script>   


<script>
    // gestion d'affichage de la localite de naissance
  $('#nationalite_id').on('change', function() {
    let val_sel1 = $('#nationalite_id').val();
    // alert(val_sel2);
    if (val_sel1 == 28) {
      $('.info_localite_naissance').show();
    } else {
      $('.info_localite_naissance').hide();
    }
  })
</script>


<script>//info localite naissance

  function get_communes_naissance($id)
  {
    var PROVINCE_ID=$('#PROVINCE_ID').val();

    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_commune_naissance/"+PROVINCE_ID,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#COMMUNE_ID').html(data);
      }
    });
  }

  function get_zones_naissance($id)
  {
    var COMMUNE_ID=$('#COMMUNE_ID').val();
    $('#ZONE_ID').html('<option value=""><?=lang('selectionner')?></option>');
    $('#COLLINE_ID').html('<option value=""><?=lang('selectionner')?></option>');

    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_zone_parcelle/"+COMMUNE_ID,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#ZONE_ID').html(data);
      }
    });
  }

  function get_collines_naissance($id)
  {
    var ZONE_ID=$('#ZONE_ID').val();
    $('#COLLINE_ID').html('<option value=""><?=lang('selectionner')?></option>');

    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_colline_parcelle/"+ZONE_ID,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#COLLINE_ID').html(data);
      }
    });
  }

</script>

<!-- approuver que les alphabets -->
<script>
  function validateAlphabets(input) {
    var regex = /^[a-zA-Z\s]+$/;
    return regex.test(input);
  }

  function validateInput(input) {
    var isValid = validateAlphabets(input.value);
    if (!isValid) {
      input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }
  }
</script>
<!-- fin approbation que les alphabets -->

  <!-- approuver les alphabets ,les chiffres,tiret and anti slash pour parcelle et num cadastre-->
  <script>
function validateAlphbatesNumbersandDashSlashesParcelle(input) {
  var regex = /^[A-Za-z0-9\-\/\s]+$/;
  return regex.test(input);
}

function validateValueParcelle(input) {
  var isValid = validateAlphbatesNumbersandDashSlashesParcelle(input.value);
  if (!isValid) {
    input.value = input.value.replace(/[^A-Za-z0-9\-\/\s]/g, '');
  }
}
</script>

<!-- fin du script d'approbation -->


<!-- approuver que les chiffres et points ou anti-slash -->
<script>
  function validateNumbersandDotsSlashes(input) {
    var regex = /^[0-9./]+$/;
    return regex.test(input);
  }

  function validateValue(input) {
    var isValid = validateNumbersandDotsSlashes(input.value);
    if (!isValid) {
      input.value = input.value.replace(/[^0-9./]/g, '');
    }
  }

</script>
<!-- fin approbation que les chiffres et  point ou slash -->

<!-- approuver les alphabets ,les chiffres,tiret and anti slash -->
<script>
  function validateAlphbatesNumbersandDashSlashes(input) {
    var regex = /^[A-Z0-9\-\/\s]+$/;
    return regex.test(input);
  }

  function validateValues(input) {
    var isValid = validateAlphbatesNumbersandDashSlashes(input.value);
    if (!isValid) {
      input.value = input.value.replace(/[^A-Z0-9\-\/\s]/g, '');
    }
  }
</script>

<!-- fin du script d'approbation -->



<!-- approuver que les chiffres -->
<script>
  function validateNumbers(input) {
    var regex = /^[0-9+]+$/;
    return regex.test(input);
  }

  function validatePhoneNumber(input) {
    var isValid = validateNumbers(input.value);
    if (!isValid) {
      input.value = input.value.replace(/[^0-9+]/g, '');
    }
  }

  function validateInfoFolio(input) {
    var isValid = validateNumbers(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^0-9.]/g, '');
    }
}
</script>

<script>//info localite parcelle

  function get_communes($id)
  {
    var PROVINCE_ID=$('#PROVINCE_ID1').val();

    $('#COMMUNE_ID1').html('<option value=""><?=lang('selectionner')?></option>');
    $('#ZONE_ID1').html('<option value=""><?=lang('selectionner')?></option>');
    $('#COLLINE_ID1').html('<option value=""><?=lang('selectionner')?></option>');
    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_commune_parcelle/"+PROVINCE_ID,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#COMMUNE_ID1').html(data);
      }
    });
  }

  function get_zones($id)
  {
    var COMMUNE_ID=$('#COMMUNE_ID1').val();
    $('#ZONE_ID1').html('<option value=""><?=lang('selectionner')?></option>');
    $('#COLLINE_ID1').html('<option value=""><?=lang('selectionner')?></option>');

    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_zone_parcelle/"+COMMUNE_ID,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#ZONE_ID1').html(data);
      }
    });
  }

  function get_collines($id)
  {
    var ZONE_ID=$('#ZONE_ID1').val();
    $('#COLLINE_ID1').html('<option value=""><?=lang('selectionner')?></option>');

    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_colline_parcelle/"+ZONE_ID,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#COLLINE_ID1').html(data);
      }
    });
  }
</script>



<script>

  var isFirstClick = true;

  function toggleTabs() {
    let statut = 1;
    if ($("#type_requerant_id").val() == "") {
      statut = 2;
      $("#errtype_requerant_id").html("Champ obligatoire");

    }
    else
    {
      $("#errtype_requerant_id").html("");
    }

    if ($("#type_requerant_id").val() ==1)
    {
      if ($("#nationalite_id").val() == "")
      {
        statut = 2;
        $("#errnationalite_id").html("Champ obligatoire");
      }
      else
      {
        $("#errnationalite_id").html("");
      }


      if ($("#NOM_PRENOM_PROP").val() == "")
      {
        statut = 2;
        $("#errNOM_PRENOM_PROP").html("Champ obligatoire");
      }
      else
      {
        $("#errNOM_PRENOM_PROP").html("");
      }

      if($("#SEXE_ID").val() == "")
      {
        statut = 2;
        $("#errsexe_id").html("Champ obligatoire");
      }
      else
      {
        $("#errsexe_id").html("");
      }


      if ($("#nationalite_id").val()!= "" && $("#nationalite_id").val()==28)
      {
        if ($("#PROVINCE_ID").val() == "")
        {
          statut = 2;
          $("#errPROVINCE_ID").html("Champ obligatoire");
        }
        else
        {
          $("#errPROVINCE_ID").html("");
        }

        if ($("#COMMUNE_ID").val() == "")
        {
          statut = 2;
          $("#errCOMMUNE_ID").html("Champ obligatoire");
        }
        else
        {
          $("#errCOMMUNE_ID").html("");
        }

        if ($("#ZONE_ID").val() == "")
        {
          statut = 2;
          $("#errZONE_ID").html("Champ obligatoire");
        }
        else
        {
          $("#errZONE_ID").html("");
        }

        if ($("#COLLINE_ID").val() == "")
        {
          statut = 2;
          $("#errCOLLINE_ID").html("Champ obligatoire");
        }
        else
        {
          $("#errCOLLINE_ID").html("");
        }
      }

  
      if ($("#NUM_CNI_PROP").val() == "")
      {
        statut = 2;
        $("#errNUM_CNI_PROP").html("Champ obligatoire");
      }
      else
      {
        $("#errNUM_CNI_PROP").html("");
      }

      if ($("#LIEU_DELIVRANCE").val() == "")
      {
        statut = 2;
        $("#errLIEU_DELIVRANCE").html("Champ obligatoire");
      }
      else
      {
        $("#errNUM_CNI_PROP").html("");
      }

      if ($("#EMAIL_PROP").val() == "")
      {
        statut = 2;
        $("#errEMAIL_PROP").html("Champ obligatoire");
      }
      else
      {
        $("#errEMAIL_PROP").html("");
      }

      if ($("#NUM_TEL_PROP").val() == "")
      {
        statut = 2;
        $("#errNUM_TEL_PROP").html("Champ obligatoire");
      }
      else
      {
        $("#errNUM_TEL_PROP").html("");
      }

      if ($("#NOM_PRENOM_PERE").val() == "")
      {
        statut = 2;
        $("#errNOM_PRENOM_PERE").html("Champ obligatoire");
      }
      else
      {
        $("#errNOM_PRENOM_PERE").html("");
      }

      if ($("#NOM_PRENOM_MERE").val() == "")
      {
        statut = 2;
        $("#errNOM_PRENOM_MERE").html("Champ obligatoire");
      }
      else
      {
        $("#errNOM_PRENOM_MERE").html("");
      }
    } 

    if ($("#type_requerant_id").val() ==5)
    {
      if($("#NOM_ENTREPRISE").val() == "")
      {
        statut = 2;
        $("#errNOM_ENTREPRISE").html("Champ obligatoire");
      }
      else
      {
        $("#errNOM_ENTREPRISE").html("");
      }

      if($("#NOM_REPRESENTANT").val() == "")
      {
        statut = 2;
        $("#errNOM_REPRESENTANT").html("Champ obligatoire");
      }
      else
      {
        $("#errNOM_REPRESENTANT").html("");
      }

      if($("#EMAIL_REPRESENTANT").val() == "")
      {
        statut = 2;
        $("#errEMAIL_REPRESENTANT").html("Champ obligatoire");
      }
      else
      {
        $("#errEMAIL_REPRESENTANT").html("");
      }

      if($("#TELEPHONE_REPRESENTANT").val() == "")
      {
        statut = 2;
        $("#errTELEPHONE_REPRESENTANT").html("Champ obligatoire");
      }
      else
      {
        $("#errTELEPHONE_REPRESENTANT").html("");
      }

      if($("#NIF_RC").val() == "")
      {
        statut = 2;
        $("#errNIF_RC").html("Champ obligatoire");
      }
      else
      {
        $("#errNIF_RC").html("");
      }
    }

    var requerantTab = document.getElementById("requerant_info");
    var parcelleTab = document.getElementById("parcelle_info");
    var nextButton = document.getElementById("btn_step1");
    var backButton = document.getElementById("btn_retour");
    // Champ non vide, activer le bouton

    if (statut==2) {
      //alert('Veuillez compléter tous les champs!');
      requerantTab.style.display = "block";
      parcelleTab.style.display = "none";
      nextButton.textContent = "Suivant   \u2192";
      backButton.style.display = "none";
      isFirstClick = true;
    } else {

      if (parcelleTab.style.display === "none") {
        requerantTab.style.display = "none";
        parcelleTab.style.display = "block";
        nextButton.textContent = "Précédent   \u2190";
        backButton.style.display = "inline-block";
      } else {
        requerantTab.style.display = "block";
        parcelleTab.style.display = "none";
        nextButton.textContent = "Suivant   \u2192";
        backButton.style.display = "none";
      }
    }
  }
  
</script>
<script>
function buttonSave()
{
  let statut = 1;
  if($("#NUM_PARCEL").val() == "")
  {
    statut = 2;
    $("#errNUM_PARCEL").html("Champ obligatoire");  
  }
  else
  {
    $("#errNUM_PARCEL").html("");
  }

  if($("#NATURE_DOC").val() == "")
  {
    statut = 2;
    $("#errNATURE_DOC").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errNATURE_DOC").html("");
  }

  if($("#NUMERO_SPECIAL").val() == "")
  {
    statut = 2;
    $("#errNUMERO_SPECIAL").html("Champ obligatoire");  
  }
  else
  {
    $("#errNUMERO_SPECIAL").html("");
  }

  if($("#VOLUME").val() == "")
  {
    statut = 2;
    $("#errVOLUME").html("Champ obligatoire");  
  }
  else
  {
    $("#errVOLUME").html("");
  }
 
  if($("#FOLIO").val() == "")
  {
    statut = 2;
    $("#errFOLIO").html("Champ obligatoire");  
  }
  else
  {
    $("#errFOLIO").html("");
  }
  
  if($("#SUPER_HA").val() == "")
  {
    statut = 2;
    $("#errSUPER_HA").html("Champ obligatoire");  
  }
  else
  {
    $("#errSUPER_HA").html("");
  }

  if($("#SUPER_ARE").val() == "")
  {
    statut = 2;
    $("#errSUPER_ARE").html("Champ obligatoire");  
  }
  else
  {
    $("#errSUPER_ARE").html("");
  }

  if($("#SUPER_CA").val() == "")
  {
    statut = 2;
    $("#errSUPER_CA").html("Champ obligatoire");  
  }
  else
  {
    $("#errSUPER_CA").html("");
  }

  if($("#PROVINCE_ID1").val() == "")
  {
    statut = 2;
    $("#errPROVINCE_ID1").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errPROVINCE_ID1").html("");
  }

  if($("#COMMUNE_ID1").val() == "")
  {
    statut = 2;
    $("#errCOMMUNE_ID1").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errCOMMUNE_ID1").html("");
  }
  
  if($("#ZONE_ID1").val() == "")
  {
    statut = 2;
    $("#errZONE_ID1").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errZONE_ID1").html("");
  }

  if($("#COLLINE_ID1").val() == "")
  {
    statut = 2;
    $("#errCOLLINE_ID1").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errCOLLINE_ID1").html("");
  }

  if($("#USAGE").val() == "")
  {
    statut = 2;
    $("#errUSAGE").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errUSAGE").html("");
  }

  if($("#NUM_CADASTRE").val() == "")
  {
    statut = 2;
    $("#errNUM_CADASTRE").html("champ est obligatoire");  
  }
  else
  {
    $("#errNUM_CADASTRE").html("");
  }
  

  if(statut==1)
  {
    myform.submit();
  }
}
</script>