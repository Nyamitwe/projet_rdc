<!DOCTYPE html>
<html lang="en">
<head>
 <?php include VIEWPATH.'includes/header.php'; ?>

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
               <a href="<?= base_url() ?>administration/Droits/liste" class="btn btn-info" style="float: right;"><font class="fa fa-list"></font> Liste des profils et droits</a>
                                </div> 
                                <div class="full price_table padding_infor_info">
                                 <form class="form-horizontal" method="post" id="myform" action="<?php echo base_url('administration/Droits/save')?>"  enctype="multipart/form-data">                                 
                                    <div class="row mb-4" style="margin-left: 20px;margin-right: 20px">
                                   <div class="form-group col-lg-6">    
                                     <label style="font-weight: 900; color:#454545" id="PROCESS">Process</label>
                               <select class="form-control" id="PROCESS_ID"  name="PROCESS_ID" onchange="get_input()">
                               <option value="0">Sélectionner</option>
                              <?php
                            foreach ($process as $key => $valu) {
                  

                            if ($valu['PROCESS_ID']==$PROCESS_ID) 
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
                              
                                   <div class="form-group col-lg-6">    
                                     <label style="font-weight: 900; color:#454545" id="lettre_demande">Service<font color="red">*</font></label>
                      <select class="form-control" id="SERVICE_ID"  name="SERVICE_ID" onchange="action_func()">
                               <option value="">Sélectionner</option>
                              <?php 

                              foreach ($service as $key => $val) {
                          

                             if ($val['SERVICE_ID']==$SERVICE_ID) 
                             {
                             echo '<option value="'.$val['SERVICE_ID'].'" selected>'.$val['DESCRIPTION'].'</option>';
                             }
                            else{
                             

                            echo '<option value="'.$val['SERVICE_ID'].'">'.$val['DESCRIPTION'].'</option>';
                           
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

                                   <div class="row mb-4" id="stages" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;overflow: scroll;height: 240px;width: 98%">
                                
                                  <?=$html?>

                                   </div>
                                    <div class="row mb-4" id="btnn" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;">
                                   <div class="form-group col-lg-12">
                                    <button type="submit" class="btn btn-info form-control" id="btnSave" style="margin-top: 20px" class="main_bt" >Modifier</button>
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
   var SERVICE_ID=$('#SERVICE_ID').val();

   if (SERVICE_ID!='') 
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


