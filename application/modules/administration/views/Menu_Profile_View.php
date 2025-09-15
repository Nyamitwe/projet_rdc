<!DOCTYPE html>
<html lang="en">
<head>
 <?php include VIEWPATH.'includes/header.php'; ?>

 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>



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
                <h3>Affectation des droits aux postes</h3>
               <a href="<?= base_url() ?>administration/Menus_Profile/liste" class="btn btn-info" style="float: right;"><font class="fa fa-list"></font> Liste des profils et droits</a>
                                </div> 
                                <div class="full price_table padding_infor_info">
                                  <form class="form-horizontal" method="post" id="myform" action="<?php echo base_url('administration/Menus_Profile/save')?>"  enctype="multipart/form-data">                                 
                                    <div class="row mb-4" style="margin-left: 20px;margin-right: 20px">
                                   <div class="form-group col-lg-12">    
                                     <label style="font-weight: 900; color:#454545" id="PROCESS">Poste</label>
              <select class="form-control" id="ID_POSTE"  name="ID_POSTE" onchange="get_input()" class="selectpicker">
                               <option value="0">Sélectionner</option>
                              <?php
                            foreach ($postes as $key => $valu) {
                  
 
                            if ($valu['ID_POSTE']==set_value('ID_POSTE')) 
                            {
                             echo '<option value="'.$valu['ID_POSTE'].'" selected>'.$valu['POSTE_DESCR'].'</option>';
                            }
                            else{
                             
                        
                           echo '<option value="'.$valu['ID_POSTE'].'">'.$valu['POSTE_DESCR'].'</option>';
                           
                            
                                }
                        
                            }
                             ?>
                             
                         </select>
                                     <span class="help-block" style="color: red"></span>
                                   </div>


                                  
                               



                                   </div>

                            
                                   <hr>
                                  <h5 style="margin-left: 20px;margin-right: 20px">Attribution des droits</h5>
                                   <hr>

                                   <div class="row mb-4" id="menus" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;overflow: scroll;height: 240px;width: 98%">
                                
                                
                                 
                               

                                   </div>

                                    <div class="row mb-4" id="btnn" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;">
                                   <div class="form-group col-lg-12">
                                    <button type="submit" class="btn btn-info form-control" id="btnSave" style="margin-top: 20px" class="main_bt" disabled="true">Attribuer les droits sur les éléments sélectionnés</button>
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

   function get_input() 
 {
    var ID_POSTE=$('#ID_POSTE').val();


    
   if (ID_POSTE!='') 
   {

   document.getElementById('btnSave').removeAttribute("disabled");

  // get_input();

   }
   else
   {
  
    document.getElementById('btnSave').setAttribute("disabled","disabled");

   }
  
    // if (trans !='') 
    // {   
     $.post('<?php echo base_url('index.php/administration/Menus_Profile/get_input')?>',
    {
    ID_POSTE:ID_POSTE,
   
    },
   function(data)
    {
   $('#menus').html(data);
    });

   // }

} 
  

</script>
<script type="text/javascript">
   function action_func()
   {
   var SERVICE_ID=$('#SERVICE_ID').val();

   

   if (SERVICE_ID!='') 
   {

   document.getElementById('btnSave').removeAttribute("disabled");

   get_input();

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

   
  
    // if (trans !='') 
    // {   
     $.post('<?php echo base_url('index.php/administration/Droits/get_poste')?>',
    {
    SERVICE_ID:SERVICE_ID,
   
    },
   function(data)  
    {
   $('#ID_POSTE').html(data);
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

