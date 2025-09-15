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
               <a href="<?= base_url() ?>administration/Droits/liste" class="btn btn-dark " style="float: right;"><font class="fa fa-list"></font>&nbsp;Upload des documents</a>
                                </div> 
                                <div class="full price_table padding_infor_info">
                                  <form class="form-horizontal" method="post" id="myform" action="<?php echo base_url('administration/Upload_Fichier_Manquant/update_doc')?>"  enctype="multipart/form-data">                                 
                                    <!-- s -->
                                   <div class="row">    
                               
                              
                                   <div class="form-group col-lg-9"> 
                                   <label style="font-weight: 900; color:#454545" id="PROCESS">Code demande</label>   
                                   <input type="text" name="CODE_DEMANDE" id="CODE_DEMANDE" class="form-control">
                                   </div>


                                   <div class="form-group col-lg-3">
                                   <br>    
                                     <button class="btn btn-info form-control" id="btn_id" type="button" onclick="get_doc()">Rechercher</button>

                                   </div>


                                   </div>

                            
                                   <hr>
                                  <h5 style="margin-left: 20px;margin-right: 20px">Ajout des documents manquant</h5>
                                   <hr>

                                   <div class="row mb-4" id="stages" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;overflow: scroll;height: 240px;width: 98%">
                                
                                
                                    <?=$html?>
                               

                                   </div>

                                    <div class="row mb-4" id="btnn" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;">
                                   <div class="form-group col-lg-12">
                                    <button type="submit" class="btn btn-info form-control" id="btnSave" style="margin-top: 20px" class="main_bt">Enregistrer</button>
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

   function get_doc() 
 {
    var CODE_DEMANDE=$('#CODE_DEMANDE').val();
  
    // if (trans !='') 
    // {   
     $.post('<?php echo base_url('index.php/administration/Upload_Fichier_Manquant/get_doc')?>',
    {
    CODE_DEMANDE:CODE_DEMANDE,
   
    },
   function(data)
    {
   $('#stages').html(data);
    document.getElementById('btnSave').removeAttribute("disabled");
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

<script type="text/javascript">

   function get_input() 
 {
    var PROCESS_ID=$('#PROCESS_ID').val();
    var ID_POSTE=$('#ID_POSTE').val();
  
    // if (trans !='') 
    // {   
     $.post('<?php echo base_url('index.php/administration/Droits/get_input')?>',
    {
    PROCESS_ID:PROCESS_ID,
    ID_POSTE:ID_POSTE
   
    },
   function(data)
    {
   $('#stages').html(data);
    });

   // }

} 
  

</script>


