<!DOCTYPE html>
<html lang="en">
<head>
   <?php include VIEWPATH.'includes/header.php'; ?>

   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>template/datepicker/css/daterangepicker.css">
    <link href="<?php echo base_url() ?>template/datepicker/css/master.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>template/datepicker/css/datepicker.css" rel="stylesheet">

    <link href="<?php echo base_url() ?>template/datepicker/css/jquery.datetimepicker.min.css" rel="stylesheet">
      
   </head>
   <body class="inner_page login">
      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
                        <img width="100" src="<?php echo base_url() ?>template/images/DTF_light_logo.png" alt="#" />
                     </div>
                  </div>
                  <div class="login_form">
                     
                      <h4 class="text-center">Property Management System</h4><br>
                      <?= $this->session->flashdata('message') ?>
                     

                      <form method="POST" id="myformcompt"  enctype="multipart/form-data" action="<?=base_url().'Compte/save'?>">

                        <fieldset style="display: block;" id="div_comp">
                                 <div class="row mb-4">

                        <div class="form-group col-lg-6">
                           <label style="font-weight: 900; color:#454545">S'inscrire comme:<span style="color:red;">*</span></label>
                                                <select class="form-control" id="PROFIL1" name="PROFIL1">
                                                  <option value="">Sélectionner</option>
                                                    <option value="1">Requérant</option>
                                                <option value="2">Notaire</option>
                                                </select>
                                                <font color="red" id="erPROFIL" class="help"><?php echo form_error('PROFIL1'); ?></font>
                                            </div>
                                  <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">Nom<span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" placeholder="Nom" name="NOM" id="NOM">

                                                <font color="red" id="erNOM"><?php echo form_error('NOM'); ?></font>
                                            </div>
                                      <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">Prénom<span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" placeholder="Prénom" name="PRENOM" id="PRENOM">
                                                <font color="red" id="erPRENOM" class="help"><?php echo form_error('PRENOM'); ?></font>
                                            </div>
                                        <div class="form-group col-lg-6">
                           <label style="font-weight: 900; color:#454545">Sexe<span style="color:red;">*</span></label>
                                                <select class="form-control" id="SEXE_ID" name="SEXE_ID">
                                                  <option value="">Sélectionner</option>
                                                    <option value="1">Homme</option>
                                                <option value="2">Femme</option>
                                                </select>
                                                <font color="red" id="erSEXE_ID" class="help"><?php echo form_error('SEXE_ID'); ?></font>
                                            </div>
                                      <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">Tél 1<span style="color:red;">*</span></label>
                                                <input type="number" class="form-control" placeholder="Tél" name="TEL1" id="TEL1">
                                                <font color="red" id="erTEL1"  class="help"><?php echo form_error('TEL1'); ?></font>
                                            </div>
                                       <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">Tél 2</label>
                                                <input type="number" class="form-control" placeholder="Tél" name="TEL2" id="TEL2">

                                                <font color="red" id="erTELe"  class="help"></font>
                                            </div>
                                             <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">E-mail</label>
                                                <input type="email" id="EMAIL" name="EMAIL" class="form-control" placeholder="E-mail">
                                                <font color="red" id="erEMAIL" class="help"></font>
                                            </div>
                                         
                                          <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">CNI<span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" placeholder="CNI" name="CNI" id="CNI">
                                                <font color="red" id="erCNI" class="help"><?php echo form_error('CNI'); ?></font>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">NIF</label>
                                                <input type="emai" class="form-control" name="NIF" id="NIF" placeholder="NIF">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">RC</label>
                                                <input type="text" class="form-control" id="RC" name="RC" placeholder="RC">
                                            </div>
                                     
                                          
                                             <div class="form-group col-lg-6">
                                               
                                            </div>
                                            <div class="form-group col-lg-6">
                                               <button type="button" style="margin-top: 20px;float: right;" class="main_bt" onclick="verify1()">Suivant >></button>
                                            </div>
                                             </div>
                                      
                                        </fieldset>
                                         <fieldset style="display: none;" id="div_comp2">
                                         <div class="row mb-4">
                                          <div class="form-group col-lg-6">
                                            <label style="font-weight: 900; color:#454545">Province<span style="color:red;">*</span></label>
                                            <select required class="form-control" name="PROVINCE_ID" id="PROVINCE_ID">
                                                <option value="">Sélectionner</option>
                                                <?php foreach ($provinces as $value) { ?>
                                                  <option value="<?=$value['PROVINCE_ID']?>"  <?= $i = $value['PROVINCE_ID'] == $PROVINCE_ID ? 'selected' : '' ?> ><?=$value['PROVINCE_NAME']?></option>
                                              <?php } ?>

                                          </select>
                                          <font color="red" id="erPROVINCE_ID" class="help"><?php echo form_error('PROVINCE_ID'); ?></font>
                                      </div>
                                        <div class="form-group col-lg-6">
                                            <label style="font-weight: 900; color:#454545">Commune<span style="color:red;">*</span></label>
                                            <select required class="form-control" name="COMMUNE_ID" id="COMMUNE_ID">
                                    <option value="">Sélectionner</option>
                                    
                                  </select>
                                  <font color="red" id="erCOMMUNE_ID" class="help"><?php echo form_error('COMMUNE_ID'); ?></font>

                                </div>
                                      
                                <div class="form-group col-lg-6">
                                    <label style="font-weight: 900; color:#454545">Zone<span style="color:red;">*</span></label>
                                    <select required class="form-control" name="ZONE_ID" id="ZONE_ID" >
                                        <option value="">Sélectionner</option>

                                    </select>
                                    <font color="red" id="erZONE_ID" class="help"><?php echo form_error('ZONE_ID'); ?></font>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label style="font-weight: 900; color:#454545">Colline<span style="color:red;">*</span></label>
                                    <select required class="form-control" name="COLLINE_ID" id="COLLINE_ID">
                                        <option value="">Sélectionner</option>

                                    </select>

                                    <font color="red" id="erCOLLINE_ID" class="help"><?php echo form_error('COLLINE_ID'); ?></font>
                                </div>

                     
                            <div class="form-group col-lg-6">
                           <label style="font-weight: 900; color:#454545">Date de naissance<span style="color:red;">*</span></label>
                                                <input type="date" name="DATE_NAISSANCE" id='DATE_NAISSANCE'  class="form-control">
                                                <font color="red" id="erDATE_NAISSANCE" class="help" ><?php echo form_error('DATE_NAISSANCE'); ?></font>
                                            </div>


                                                <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">Nom d'utilisateur<span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" name="USERNAME1" id="USERNAME1" placeholder="Nom d'utilisateur">
                                                <font color="red" id="erUSERNAME" class="help"><?php echo form_error('USERNAME1'); ?></font>
                                            </div>
                                                    <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">Mot de passe <span style="color:red;">*</span></label>
                                                <input type="password" class="form-control" name="PASSWORD1" id="PASSWORD1">
                                                <font color="red" id="erPWD" class="help"><?php echo form_error('PASSWORD1'); ?></font>
                                            </div>
                                                 <div class="form-group col-lg-6">
                                                <label style="font-weight: 900; color:#454545">Confirmer votre mot de passe <span style="color:red;">*</span></label>
                                                <input type="password" class="form-control" id="PASSWORD2" name="PASSWORD2">
                                                <font color="red" id="erPWD2" class="help"><?php echo form_error('PASSWORD2'); ?></font>
                                            </div>
                                         <div class="form-group col-lg-6">
                                               <button type="button" style="margin-top: 20px;float: left" class="main_bt" onclick="preced()"><< Précedent</button>
                                            </div>
                                      <div class="form-group col-lg-6">
                                               <button type="button" style="margin-top: 20px;float: right;" class="main_bt" onclick="verify2()">Enregistrer</button>
                                            </div>
                                      
                                  
                                  </div>
                        </fieldset>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="js/animate.js"></script>
      <!-- select country -->
      <script src="js/bootstrap-select.js"></script>
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
   </body>
   <script type="text/javascript">
     $(document).ready(function() {

  //     $(function() {
  // $('input[name="DATE_NAISSANCE"]').daterangepicker({
  //   singleDatePicker: true,
  //   "autoApply":true,
  //   autoUpdateInput: false,
  //   showDropdowns: true,
  //   minYear: 1901,
 
  // });
  //    });
      });

   </script>

   <script type="text/javascript">
       $('#inscr').on('click', function(ev) {
         //document.getElementById('div_conn').style.display="none";
         document.getElementById('div_comp').style.display="block";
        });


       // $('#choice').on('change', function(ev) {
       //    var selectVal=$(this).val();

       //  if (selectVal==1) 
       //  {
       //    alert(selectVal);
       //   document.getElementById('div_comp').style.display="block";
       //  }

       //  // if (selectVal==2) {
       //  //  document.getElementById('div_select').style.display="block"
       //  // }
       
       // });
   </script>

   <script type="text/javascript">
     
      $('#PROVINCE_ID').on('change',function() {
       var PROVINCE_ID= $(this).val();
       $.post('<?php echo base_url('Compte/get_commune')?>',
       {
       PROVINCE_ID:PROVINCE_ID
       },
      function(data)
      {
      $('#COMMUNE_ID').html(data);
      });
      });

      $('#COMMUNE_ID').on('change',function() {
        var COMMUNE_ID= $(this).val();
       $.post('<?php echo base_url('Compte/get_zone')?>',
       {
       COMMUNE_ID:COMMUNE_ID
       },
      function(data)
      {
      $('#ZONE_ID').html(data);
      });

      });
      $('#ZONE_ID').on('change',function() {
        var ZONE_ID= $(this).val();
       $.post('<?php echo base_url('Compte/get_colline')?>',
       {
       ZONE_ID:ZONE_ID
       },
      function(data)
      {
      $('#COLLINE_ID').html(data);
      });
      });
   </script>

   <script type="text/javascript">
     function verify1()
     {

   var input_tel=document.getElementById('TEL1');
   var input_tel2=document.getElementById('TEL2');

   var numberReg =  /^[+0-9 ]+$/;
   var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
   var Email = $('#EMAIL').val();
   var tell1 = $('#TEL1').val();
   var tell2 = $('#TEL2').val();

   var pwd1 = $('#PASSWORD1').val();
   var pwd2 = $('#PASSWORD2').val();
   
    
    var statut = true;

    if(($("#PROFIL1").val())=='')
    {  
      $('#erPROFIL').html('Nom obligatoire');
      $("#PROFIL1").focus();
      statut = false;
      console.log(statut)
    }

    if(($("#NOM").val())=='')
    {
      $('#erNOM').text('Nom obligatoire');
      $("#NOM").focus();
      statut = false;
      console.log(statut)
    }
    if(($("#PRENOM").val())=='')
    {
      $('#erPRENOM').text('Prénom obligatoire');
      $("#PRENOM").focus();
      statut = false;
      console.log(statut)
    }

    if(($("#TEL1").val())=='')
    {
      $('#erTEL1').text('Téléphone obligatoire');
      $("#TEL1").focus();
      statut = false;
      console.log(statut)
    }
  //   else
  // if (input_tel.tell1.length<=6 || !numberReg.test(input_tel.tell1)) { 
  //   alert('ok');
  //   $('#erTEL1').text('Numéro invalide');
  //   statut = false;
  //   console.log(statut)
  // }

  
    if(($("#CNI").val())=='')
    {
      $('#erCNI').text('CNI obligatoire');
      $("#CNI").focus();
      statut = false;
      console.log(statut)
    }



    if ($('#SEXE_ID').val() == "") {
        
          $('#erSEXE_ID').text('Le genre est obligatoire');
        
          $("#SEXE_ID").focus();
          statut = false;
          console.log(statut)
   } 

    if (Email != '') {
    if(!emailReg.test(Email))
   {
          $('#erEMAIL').text('Email invalide');
         
          $("#EMAIL").focus();
          statut = false;
          console.log(statut)
    }
   }


  
   if (statut==true)
   {

  document.getElementById('div_comp').style.display="none";
  document.getElementById('div_comp2').style.display="block";
   
   }


     }

  function verify2() {

  var input_tel=document.getElementById('TEL1');
   var input_tel2=document.getElementById('TEL2');

   var numberReg =  /^[+0-9 ]+$/;
   var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
   var Email = $('#EMAIL').val();
   var tell1 = $('#TEL1').val();
   var tell2 = $('#TEL2').val();

   var pwd1 = $('#PASSWORD1').val();
   var pwd2 = $('#PASSWORD2').val();
    
    var statut = true;

    

    if ($("#PROVINCE_ID").val()=='') {
     
        $('#erPROVINCE_ID').text('Province obligatoire');
       
        $("#PROVINCE_ID").focus();
        statut = false;
        console.log(statut)

    }

    if($("#COMMUNE_ID").val()=='')
    {
      $('#erCOMMUNE_ID').text('Commune obligatoire');
      $("#COMMUNE_ID").focus();
      statut = false;
      console.log(statut)

    }
    if($("#ZONE_ID").val()=='')
    {
      $('#erZONE_ID').text('Zone obligatoire');
      $("#ZONE_ID").focus();
      statut = false;
      console.log(statut)
    }

   if ($('#COLLINE_ID').val() == "") {
        
          $('#erCOLLINE_ID').text('Colline obligatoire');
        
          $("#COLLINE_ID").focus();
          statut = false;
          console.log(statut)
   }
    
   if ($('#USERNAME1').val() == "") {
        
          $('#erUSERNAME').text('Nom d\'utilisateur obligatoire');
          $("#USERNAME1").focus();
          statut = false;
          console.log(statut)
   } 

   if ($('#PASSWORD1').val() == "") {
        
          $('#erPWD').text('Mot de passe obligatoire');
        
          $("#PASSWORD1").focus();
          statut = false;
          console.log(statut)
   }

   if ($('#PASSWORD2').val() == "") {
        
          $('#erPWD2').text('Veuillez confirmer le mot de passe');
        
          $("#PASSWORD2").focus();
          statut = false;
          console.log(statut)
   } 
   else
   if(String(pwd1) !== String(pwd2))
   {     
          $('#erPWD2').text('Mot de passe incohérant');
         
          $("#PASSWORD2").focus();
          statut = false;
          console.log(statut)
  }
  

  


   var datt = $('#DATE_NAISSANCE').val();
   if (datt == "") {
        
          $('#erDATE_NAISSANCE').text('La date est obligatoire');
        
          $("#DATE_NAISSANCE").focus();
          statut = false;
          console.log(statut)
   } 

  
   if (statut==true)
   {

   myformcompt.submit();
   }


  
  }

  function preced() {
  document.getElementById('div_comp').style.display="block";
  document.getElementById('div_comp2').style.display="none";
  }
  

   </script>

  <script>
  // $(function ()
  // {
  //   $("#DATE_NAISSANCE").datepicker({
  //     format: 'yyyy-mm-dd'
  //   });
  // });
</script>

</html>