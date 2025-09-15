<!DOCTYPE html>
<html lang="en">
<head>
 <?php include VIEWPATH.'includes/header.php'; ?>
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
       <!-- topbar -->
       <?php include VIEWPATH.'includes/topbar.php'; ?> 
       <!-- end topbar -->
       <!-- end topbar -->
       <!-- dashboard inner -->
       <div class="midde_cont">
        <div class="container-fluid" style="padding: 0px;">
           <br>
           <br>
          <!-- row -->
          <div class="row column1">
            <div class="col-md-12">
              <div class="white_shd full margin_bottom_30">
               <div class="full graph_head">
               <a href="<?= base_url() ?>administration/Affect_document_transferts/liste" class="btn btn-info" style="float: right;"><font class="fa fa-list"></font> Liste</a>
                                </div> 
                                <div class="full price_table padding_infor_info">
                                  <form class="form-horizontal" method="post" id="myform" action="<?php echo base_url('administration/Gest_Doc_Transfert/save')?>"  enctype="multipart/form-data">                                 
                                    <div class="row mb-4" style="margin-left: 20px;margin-right: 20px">
                                   <div class="form-group col-lg-3">    
                                     <label style="font-weight: 900; color:#454545" id="PROCESS">Process</label>
                               <select class="form-control" id="PROCESS_ID"  name="PROCESS_ID" >
                                <!-- onchange="get_input()" -->
                               <option value="0">Sélectionner</option>
                              <?php
                            foreach ($process as $key => $valu) {
                  

                            if ($valu['PROCESS_ID']==set_value('PROCESS_ID')) 
                            {
                             echo '<option value="'.$valu['PROCESS_ID'].'" selected>'.$valu['DESCRIPTION_PROCESS'].'</option>';
                            }
                            else{
                             
                        
                           echo '<option value="'.$valu['PROCESS_ID'].'">'.$valu['DESCRIPTION_PROCESS'].'</option>';
                           
                            
                                }
                        
                            }
                             ?>
                         </select>
                                     <span class="help-block" style="color: red"></span>
                                   </div>


                                     <div class="form-group col-lg-3">    
                                     <label style="font-weight: 900; color:#454545" id="PROCESS">Type transfert</label>
                               <select class="form-control" id="ID_TYPE_TRANSFERT"   name="ID_TYPE_TRANSFERT" onchange="charge_categ()" >
                                <!-- onchange="get_input()" -->
                               <option value="0">Sélectionner</option>
                              <?php
                            foreach ($types as $key => $valu) {
                  

                            if ($valu['ID_TYPE_TRANSFERT']==set_value('ID_TYPE_TRANSFERT')) 
                            {
                             echo '<option value="'.$valu['ID_TYPE_TRANSFERT'].'" selected>'.$valu['DESCRIPTION_TRANSFERT'].'</option>';
                            }
                            else{
                             
                        
                           echo '<option value="'.$valu['ID_TYPE_TRANSFERT'].'">'.$valu['DESCRIPTION_TRANSFERT'].'</option>';
                           
                            
                                }
                        
                            }
                             ?>
                         </select>
                                     <span class="help-block" style="color: red"></span>
                                   </div>

                                    <div class="form-group col-lg-3">    
                                 <label style="font-weight: 900; color:#454545">Catégorie de transfert<span style="color:red;">*</span></label>
    <select class="form-control"  id="ID_CATEGORIE_TRANSFERT" name="ID_CATEGORIE_TRANSFERT">

       <option value="">Sélectionner</option>

   </select>
                                     <span class="help-block" style="color: red"></span>

                                   </div>
                                      
                                   

                                   </div>

                            
                                   <hr>
                                  <h5 style="margin-left: 20px;margin-right: 20px">Affectation des documents</h5>
                                   <hr>

                                   <div class="row mb-4" id="stages" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;overflow: scroll;height: 240px;width: 98%">
                                
                                
                                    <?=$html?>
                               

                                   </div>

                                    <div class="row mb-4" id="btnn" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;">
                                   <div class="form-group col-lg-12">
                                    <button type="submit" class="btn btn-info form-control" id="btnSave" style="margin-top: 20px" class="main_bt">Affecter les documents</button>
                                  </div>
                                </div>
                              </form>
                            </div>

                          </div>       

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- footer -->

          </div>
          <!-- end dashboard inner -->
        </div>
      </div>
    </div>
  </div>



  <script>
    $(document).ready(function () {
      $('#dtBasicExample').DataTable();
      $('.dataTables_length').addClass('bs-select');
    });
  </script>

  <?php include VIEWPATH.'includes/scripts_js.php'; ?>


</body>
</html>


<script type="text/javascript">
  function affiche_categ(argument) {
    var type=$('#TYPE_ACHETEUR').val();

    if (type==1) {
      get_catego();
      document.getElementById('CATEGG').style.display='block';
     

    }else{
      document.getElementById('CATEGG').style.display='none';
       
    }
  }
</script>



<script type="text/javascript">
  
 function do_things(argument) {


 var ID_TYPE_TRANSFERT=$('#ID_TYPE_TRANSFERT').val();
 var TYPE_ACHETEUR=$('#TYPE_ACHETEUR').val();

 get_doc(ID_TYPE_TRANSFERT,TYPE_ACHETEUR);



 affiche_categ();
 }



</script>



<script type="text/javascript">
  
 function do_things2(argument) {


 var ID_TYPE_TRANSFERT=$('#ID_TYPE_TRANSFERT').val();
 var CATEGORIE=$('#CATEGORIE').val();
 var TYPE_ACHETEUR=$('#TYPE_ACHETEUR').val();

 get_doc(ID_TYPE_TRANSFERT,TYPE_ACHETEUR,CATEGORIE);

 }



</script>


<script type="text/javascript">

   function get_doc(ID_TYPE_TRANSFERT,TYPE_ACHETEUR,CATEGO=0) 
 {
    
     $.post('<?php echo base_url('index.php/administration/Affect_document_transferts/get_doc')?>',
    {
    ID_TYPE_TRANSFERT:ID_TYPE_TRANSFERT,
    TYPE_ACHETEUR:TYPE_ACHETEUR,
    CATEGO:CATEGO
   
    },
   function(data)
    {
   $('#stages').html(data);
    });
 } 
  

</script>


<script type="text/javascript">


function charge_categ() {
  
   var ID_TYPE_TRANSFERT= $('#ID_TYPE_TRANSFERT').val();
        $.post('<?php echo base_url('administration/Gest_Doc_Transfert/get_categ')?>',
        {
           ID_TYPE_TRANSFERT:ID_TYPE_TRANSFERT
   },
   function(data)
   {
           $('#ID_CATEGORIE_TRANSFERT').html(data);
   });
   }   


</script>


<script type="text/javascript">

   function get_input() 
 {
    var PROCESS_ID=$('#PROCESS_ID').val();
  
    // if (trans !='') 
    // {   
     $.post('<?php echo base_url('index.php/administration/Droits/get_input')?>',
    {
    PROCESS_ID:PROCESS_ID,
   
    },
   function(data)
    {
   $('#stages').html(data);
    });

   // }

} 
  

</script>
<script type="text/javascript">
   function action_func()
   {
   var STAGE_ID=$('#STAGE_ID').val();

  

   if (STAGE_ID!='') 
   {

   document.getElementById('btnSave').removeAttribute("disabled");

   }
   else
   {
  
    document.getElementById('btnSave').setAttribute("disabled","disabled");

   }
 }
</script>



<script type="text/javascript">

   function get_poste() 
 {
    var SERVICE_ID=$('#SERVICE_ID').val();
   // var PROCESS_ID=$('#PROCESS_ID').val();
    // if (trans !='') 
    // {   
   $.post('<?php echo base_url('administration/Affect_document_transferts/get_poste')?>',
    {
    SERVICE_ID:SERVICE_ID,
  //  PROCESS_ID:PROCESS_ID
   
    },
   function(data)
    {
   $('#ID_POSTE').html(data);
    });

   // }

} 
  
</script>

<script type="text/javascript">

   function get_stage() 
 {
    var ID_POSTE=$('#ID_POSTE').val();
    var PROCESS_ID=$('#PROCESS_ID').val();
    // if (trans !='') 
    // {   
   $.post('<?php echo base_url('administration/Affect_document_transferts/get_stage')?>',
    {
    ID_POSTE:ID_POSTE,
    PROCESS_ID:PROCESS_ID
   
    },
   function(data)
    {
   $('#STAGE_ID').html(data);
    });

   // }

} 
  
</script>

<script type="text/javascript">

   function get_input() 
 {
    var PROCESS_ID=$('#PROCESS_ID').val();
  
    // if (trans !='') 
    // {   
     $.post('<?php echo base_url('index.php/administration/Droits/get_input')?>',
    {
    PROCESS_ID:PROCESS_ID,
   
    },
   function(data)
    {
   $('#stages').html(data);
    });

   // }

} 
  

</script>
<script>
  function valider()
  {
    $('#btnSave').text('Enregistrement..............');
    $('#btnSave').attr("disabled",true);

    var url;   
    url="<?php echo base_url('process/Incorporation/enregistrer')?>";
    var formData = new FormData($('#myform')[0]);
    $.ajax({
      url:url,
      type:"POST",
      data:formData,
      contentType:false,
      processData:false,
      dataType:"JSON",
      success: function(data)
      {
        if(data.status) 
        {
          $('#myform')[0].reset();

          window.location="<?=base_url('process/Incorporation/index')?>";
        }
        else
        {
          for (var i = 0; i < data.inputerror.length; i++) 
          {
            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
          }
        }
        $('#btnSave').text('Envoyer');
        $('#btnSave').attr('disabled',false); 
      },
      error: function (jqXHR, textStatus,photo, errorThrown)
      {
        alert('Erreur s\'est produite');
        $('#btnSave').text('Enregistrer');
        $('#btnSave').attr('disabled',false);
      }
    });
  }
</script>

