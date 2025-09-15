<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>

<body>
  <div class="container-fluid" style="background-color: white">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
      <?php include VIEWPATH. 'includes/menu_principal.php' ?>
    </nav> 
  </div>
    <?php
      $menu1='active';
      $menu2='';
    ?>
    <div class="container-fluid">    
      <div class="container"> 
        <div class="col-lg-12">
          <div class="row">
            <legend style="padding-bottom: 10px">
              <?=lang('lieu_naissance')?>
              <div class="pull-right" style="padding-bottom: 3px">
                  <?php include 'includes/menu_ihm_incident.php'; ?> 
              </div>
            </legend>
          </div>
          <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
                        <li role="presentation" id="identif"><a href="<?=base_url()?>ihm/Requerant/etape_1/<?=$REQUERANT_ID?>" aria-controls="home" role="tab" data-toggle="tab" >Identification</a></li>
                        <li role="presentation" class="active" id="lieu_naiss"><a href="<?=base_url()?>ihm/Requerant/etape_1_1/<?=$REQUERANT_ID?>" aria-controls="profile" role="tab" data-toggle="tab"><?=lang('lieu_naissance')?></a></li>
                        <li role="presentation" id="resid"><a href="<?=base_url()?>ihm/Requerant/etape_1_2/<?=$REQUERANT_ID?>" aria-controls="fert" role="tab" data-toggle="tab"><?=lang('residence')?></a></li>
                        <li role="presentation" id="persone_cont"><a href="<?=base_url()?>ihm/Requerant/etape_2/<?=$REQUERANT_ID?>" aria-controls="fert" role="tab" data-toggle="tab"><?=lang('persone_contact')?></a></li>
                        <li role="presentation" id="symptone"><a href="<?=base_url()?>ihm/Requerant/etape_3/<?=$REQUERANT_ID?>" aria-controls="fert" role="tab" data-toggle="tab"><?=lang('symptome')?></a></li>
                        <li role="presentation" id="membre_f"><a href="<?=base_url()?>ihm/Requerant/etape_3_1/<?=$REQUERANT_ID?>" aria-controls="fert" role="tab" data-toggle="tab"><?=lang('membre_familliale')?></a></li>
                        <li role="presentation" id="tracking"><a href="<?=base_url()?>ihm/Requerant/etape_4/<?=$REQUERANT_ID?>" aria-controls="fert" role="tab" data-toggle="tab"><?=lang('tracking')?></a></li>
                        <li role="presentation" id="persononne_touch"><a href="<?=base_url()?>ihm/Requerant/etape_5/<?=$REQUERANT_ID?>" aria-controls="fert" role="tab" data-toggle="tab"><?=lang('personne_renter_contact')?></a></li>
                        <li role="presentation" id="observation"><a href="<?=base_url()?>ihm/Requerant/etape_6/<?=$REQUERANT_ID?>" aria-controls="fert" role="tab" data-toggle="tab">Observations</a></li>

                      </ul>

          <form method="POST" id="myform"action="<?=base_url().'ihm/Requerant/save_etape_1_1'?>">
            
            <?php // echo validation_errors(); ?>

            <!--  -->


            <div class="row form-group">
                <div class="col-lg-6">
                  <input type="hidden" name="REQUERANT_ID" value="<?=$requerant['REQUERANT_ID']?>">
                  <label><?=lang('requerant_province')?><span class="text-danger">*</span></label>
                 <select class="form-control" id="province" name="PROVINCE_ID" onchange="par_ville();vide_colline()">
                   <option value=""><?=lang('requerant_select')?></option>
                   <?php foreach ($liste_province as $value) { ?>
                    <option 
                      <?php if($requerant['PROVINCE_ID'] == $value['PROVINCE_ID']) echo 'selected';?> 
                      value="<?=$value['PROVINCE_ID']?>">
                        <?=$value['PROVINCE_NAME']?>                          
                    </option>
                   <?php } ?>
                 </select>
                 <div style="color: red"><?php echo form_error('PROVINCE_ID'); ?></div>
                </div>

                <div class="col-lg-6">
                  <label><?=lang('requerant_commune')?><span class="text-danger">*</span></label>
                  <input type="hidden" id="REMOTE_COMMUNE_ID" value="<?=$requerant['COMMUNE_ID']?>">
                  <select class="form-control" id="commune" name="COMMUNE_ID" onchange="par_commune()">
                   <!-- <option value=""><?=lang('requerant_select')?></option> -->
                 </select>
                 <div style="color: red"><?php echo form_error('COMMUNE_ID'); ?></div>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-6">
                  <label><?=lang('requerant_zone')?><span class="text-danger">*</span></label>
                  <input type="hidden" id="REMOTE_ZONE_ID" value="<?=$requerant['ZONE_ID']?>">
                  <select class="form-control" id="zone" name="ZONE_ID" onchange="par_zone()">
                   <!-- <option value=""><?=lang('requerant_select')?></option> -->
                 </select>
                 <div style="color: red"><?php echo form_error('ZONE_ID'); ?></div>
                </div>

                <div class="col-lg-6">
                  <label><?=lang('requerant_collines')?><span class="text-danger">*</span></label>
                  <input type="hidden" id="REMOTE_COLLINE_ID" value="<?=$requerant['COLLINE_ID']?>">
                  <select class="form-control" id="colline" name="COLLINE_ID">
                   <!-- <option value=""><?=lang('requerant_select')?></option> -->
                 </select>
                 <div style="color: red"><?php echo form_error('COLLINE_ID'); ?></div>
                </div>
            </div>           

            <div class="row form-group">
                <div class="col-md-6">
                 
                <!-- <a href="<?=base_url('ihm/Requerant/etape_1/'.$requerant['REQUERANT_ID'])?>" class="btn btn-primary btn-sm">
                   <span class="glyphicon glyphicon-arrow-left"></span> 
                   Précédent
                 </a> --> 
                 <a href="<?=base_url('ihm/Requerant/etape_1/'.$requerant['REQUERANT_ID'])?>" class="">
                   <button type="button" 
                          id="btn_tab1" 
                          class="btn btn-primary btn-sm pull-left">
                           <span class="glyphicon glyphicon-arrow-left"></span>
                          Précédent
                            
                  </button>
                </a>
                </div>  

                <div class="col-md-6"> 
                  
                  <button type="submit" 
                          id="btn_tab1" 
                          class="btn btn-primary btn-sm pull-right">
                          Suivant
                          <span class="glyphicon glyphicon-arrow-right"></span>  
                  </button> 

                </div>
            </div>

          </form>
        </div>
      </div>
      </div>
    </div>
</body>
</html>
<script type="text/javascript">
  
  $('#DATE_NAISSANCE').datepicker({format: 'yyyy/mm/d',startDate:'2000/01/01'});

  function par_ville()
  {
    var id_province=$('#province').val();
    var REMOTE_COMMUNE_ID=$('#REMOTE_COMMUNE_ID').val();
    $.post('<?=base_url()?>ihm/Requerant/get_Info_commune/',
    {
      id_province:id_province,REMOTE_COMMUNE_ID:REMOTE_COMMUNE_ID
    },
    function(data){
      commune.innerHTML=data;
      $('commune').html(data);
      // $('commune').selectpicker(refresh);
    });
  }
  function vide_colline()
  {
    // var id_province=$('#province').val();
    // $.post('<?=base_url()?>ihm/Acteur/set_vide_colline/',
    // {
    //   id_province:id_province
    // },
    // function(data){
    //   colline.innerHTML=data;
    //   $('colline').html(data);
    //   $('colline').selectpicker(refresh);
    // });
  }
  function par_commune()
  {
    var id_commune=$('#commune').val();

    $.post('<?=base_url()?>ihm/Requerant/get_Info_zone/',
    {
      id_commune:id_commune
    },
    function(data){
      
      // colline.innerHTML=data;
      $('#zone').html(data);
      // $('zone').selectpicker(refresh);
    });
  }
   function par_zone()
  {
    var id_zone=$('#zone').val();
    $.post('<?=base_url()?>ihm/Requerant/get_Info_colline/',
    {
      id_zone:id_zone
    },
    function(data){
       // alert(data);
      // colline.innerHTML=data;
      $('#colline').html(data);
      // $('zone').selectpicker(refresh);
    });
  }
</script>
<script type="text/javascript">
  $(document).ready(function(){
    var id_province=$('#province').val();
    var REMOTE_COMMUNE_ID=$('#REMOTE_COMMUNE_ID').val();
    //console.log(REMOTE_COMMUNE_ID);

    $.post('<?=base_url()?>ihm/Requerant/get_Info_commune/',
    {
      id_province:id_province,REMOTE_COMMUNE_ID:REMOTE_COMMUNE_ID
    },
    function(data){
      commune.innerHTML=data;
      $('commune').html(data);
    });

    var id_commune=$('#commune').val();
    var REMOTE_ZONE_ID=$('#REMOTE_ZONE_ID').val();
    console.log(id_commune);
    $.post('<?=base_url()?>ihm/Requerant/get_Info_zone/',
    {
      id_commune:id_commune,REMOTE_ZONE_ID:REMOTE_ZONE_ID
    },
    function(data){
      // colline.innerHTML=data;
      $('#zone').html(data);
    });
     var id_zone=$('#zone').val();
    var REMOTE_COLLINE_ID=$('#REMOTE_COLLINE_ID').val();
    console.log(id_commune);
    $.post('<?=base_url()?>ihm/Requerant/get_Info_colline/',
    {
      id_zone:id_zone,REMOTE_COLLINE_ID:REMOTE_COLLINE_ID
    },
    function(data){
      // colline.innerHTML=data;
      $('#colline').html(data);
    });


  })
</script>