<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Property Management System</title>
  <!-- site icon -->
  <link rel="icon" href="<?php echo base_url() ?>template/images/favicon-16x16.png" type="image/png" />
  <!-- bootstrap css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/bootstrap.min.css" />

  <!-- site css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/style.css" />
  <!-- responsive css --> 

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- font awesome --> 
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/responsive.css" />
  <!-- color css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/colors.css" />
  <!-- select bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/bootstrap-select.css" />
  <!-- scrollbar css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/perfect-scrollbar.css" />
  <!-- custom css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/custom.css" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->





    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>


    <link rel="stylesheet" href="<?= base_url() ?>template/vendor/select2/css/select2.min.css">

    <link href="<?= base_url() ?>template/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url() ?>template/css/buttons.dataTables.min.css" />

    <script src="<?php echo base_url() ?>Design/vendor/bootstrap/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="<?php echo base_url() ?>template/onlinescripts/dataTables.bootstrap4.min.css" />
    <link href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet">


    <script src="<?php echo base_url() ?>template/onlinescripts/jquery.min.js" type="text/javascript"></script>

    <script src="http://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>


    <script src="<?php echo base_url() ?>template/onlinescripts/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

      <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<!--   <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
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
      <div class="container-fluid" style="padding: 0px;">

       <br>
       <br>

       <?php

       $menu1="nav-link active";
       $menu2="nav-link";
       $menu3="nav-link";
       $menu4="nav-link";
       $menu5="nav-link";
       $menu6="nav-link";



       ?>


       <div class="row column1">
         <div class="col-md-12">
          <div class="white_shd full margin_bottom_30" style="padding: 0px;">

           <div class="full price_table padding_infor_info">

            <div class="row">
              <div class="col-md-12">
                <br>
                <center><h2>Recherche d'une parcelle dans Edrms</h2></center>
              </div>
            </div>

            <hr>

            <div class="dropdown col-md-3">

              <button class="btn btn-dark" onclick="history.go(-1)"><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?= lang('button_retour')?> </button>
            </div>
            <?=$this->session->flashdata('message')?>
            <br>

            <form  action="<?php echo base_url('administration/Recherche/save')?>"  method="post" name="myform" id="myform" >


              <div class="row">

                <div class="col-md-6">
                  <label><?=lang('label_province')?><font class="text-danger">*</font></label>
                  <select class="form-control" name="PROVINCE_ID1" id="PROVINCE_ID1">
                    <option value=""><?=lang('selectionner')?></option>
                    <?php foreach($provinces_localite as $province) { 
                      if ($province['PROVINCE_ID']==set_value('PROVINCE_ID1')) { 
                        echo "<option value='".$province['PROVINCE_ID']."' selected>".$province['PROVINCE_NAME']."</option>";
                      }  else{
                        echo "<option value='".$province['PROVINCE_ID']."' >".$province['PROVINCE_NAME']."</option>"; 
                      } }?>                                                              
                    </select>
                    <?php echo form_error('PROVINCE_ID1', '<div class="text-danger">', '</div>'); ?>
                    <span id="errPROVINCE_ID1" class="text-danger"></span>                                                                                
                  </div>


                <div class="col-md-6">
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


                  <div class="form-group col-lg-12"> 
                    <label>Numero de parcelle<font class="text-danger">*</font></label> 
                    <input name="PARCELLE_SEARCH" autocomplete="off" id="PARCELLE_SEARCH" placeholder="Entrez le numero de la parcelle" type="text" class="form-control" value=""> 
                    <font color="red" id="erPARCELLE_SEARCH" class="help"></font>
                  </div>


                  <div class="form-group col-lg-12">   
                    <input type="button" onclick="getSearchResults1('<?=$num_parc?>');" class="btn btn-info form-control"  value="Recherche">
                  </div>

        </div>

        <div class="col-md-12"></div>

        <div class="col-lg-12">
          <font color="red" id="message1" class="help"></font>
        </div>

        <div class="col-md-12"></div>


        <div class="row div-search-resultat1" hidden>

         <div class="col-md-3">
          <label>Nom de la parcelle</label>
          <input type="text" id="parcelle" class="form-control" readonly>
         </div>

         <div class="col-md-3">
          <label>Token de la parcelle</label>
          <input type="text" id="token_de_parcelle" class="form-control" readonly>


        </div>

        <div class="col-md-3">
          <label>Nom du sous repertoire</label>
          <input type="text" id="nom_sous_repertoire" class="form-control" readonly>
        </div>

        <div class="col-md-3">
          <label>Token du sous repertoire</label>
          <input type="text" id="token_de_sous_repertoire" class="form-control" readonly>

        </div>
        <div class="col-md-12">
          <input type="text" name="dossier" onclick="getDocInitial();" value="Voir dossier initial">          
        </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end row -->
</div>


</div>
<!-- end dashboard inner -->
</div>
</div></div></div>


<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>template/js/bootstrap.min.js"></script>


</body>
</html>
<script>

     $(document).ready(function(){
     var PARCELLE_SEARCH = $("#PARCELLE_SEARCH").val();

      if(PARCELLE_SEARCH!='')
      {
       getSearchResults1('<?=$num_parc?>');        
      }

   }); 
</script>
<script>
  function getSearchResults1(id)
  {

    var PARCELLE_SEARCH = $("#PARCELLE_SEARCH").val();
    var PROVINCE = $("#PROVINCE_ID1").val();
    var NATURE_DOC = $("#NATURE_DOC").val();
    
    // alert(PROVINCE);
    let statut = 1;


    if(PARCELLE_SEARCH == "")
    {
      statut = 2;      
      $('#erPARCELLE_SEARCH').text('Veuillez saisir un numero de parcelle');
      $("#PARCELLE_SEARCH").focus();
      console.log(statut)
    }
    else
    {
     $('#erPARCELLE_SEARCH').attr('hidden',true);
    }

    if(PROVINCE == "")
    {
      statut = 2;      
      $('#errPROVINCE_ID1').text('Veuillez séléctionner la province de cette parcelle');
      $("#PROVINCE_ID1").focus();
    }
    else
    {
     $('#errPROVINCE_ID1').attr('hidden',true);
    }


    if(NATURE_DOC == "")
    {
      statut = 2;      
      $('#errNATURE_DOC').text('Veuillez selectionner la nature du dossier');
      $("#NATURE_DOC").focus();
    }
    else
    {
     $('#errNATURE_DOC').attr('hidden',true);
    }

    if(statut==1)
    {

     $.ajax({
        url : "<?=base_url()?>administration/Recherche/recherche1/"+PROVINCE+"/"+PARCELLE_SEARCH+"/"+NATURE_DOC,
        type: "POST",
        dataType: "JSON",
        data: {PARCELLE_SEARCH:PARCELLE_SEARCH,
               PROVINCE:PROVINCE,
               NATURE_DOC:NATURE_DOC
      },
        success: function(data)
        {
          if (data.status==1) {
            $('.div-search-resultat1').attr('hidden',false);
            // $('#message1').attr('hidden',true);
            // console.log('NO')


            document.getElementById('parcelle').setAttribute('value', data.nom_parcelle);
            document.getElementById('token_de_parcelle').setAttribute('value', data.token_parcelle);
            document.getElementById('nom_sous_repertoire').setAttribute('value', data.nom_sous_rep);
            document.getElementById('token_de_sous_repertoire').setAttribute('value', data.token_sous_rep);
             $('#message1').attr('hidden',false);
             $('#message1').html(data.message);
            
          }
          else if (data.status==2) 
          {
            $('.div-search-resultat1').attr('hidden',true);
            $('#message1').attr('hidden',false);
            $('#message1').html(data.message);          
          }
        }
    });
   }
  }

  function getDocInitial()
  {
     var token_de_sous_repertoire = $("#token_de_sous_repertoire").val();
     var parcelle_numero = $("#parcelle").val();

     window.location.href="<?= base_url('administration/Recherche/afficher_dossier_initial/'); ?>"+token_de_sous_repertoire+"/"+parcelle_numero;
  }
</script>



