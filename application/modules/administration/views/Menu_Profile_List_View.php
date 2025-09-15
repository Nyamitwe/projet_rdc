 <!DOCTYPE html>
<html lang="en">
<head>
<?php include VIEWPATH.'includes/header.php'; ?>

 <style type="text/css">
      .my-card
      {
        position:absolute;
        left:40%;
        top:-20px;
        border-radius:50%;
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
             <div class="container-fluid" style="padding: 0px;">
                <br>
              
              

                <?php

                $menu1="nav-link active";
                $menu2="nav-link";
                $menu3="nav-link";
                $menu4="nav-link";
                $menu5="nav-link";
                $menu6="nav-link";



                ?>

                <br>
 

                <div class="row column1">
                  <div class="col-md-12">
                     <div class="white_shd full margin_bottom_30">

                          <div class="full graph_head">
                          	<h4>Liste des menus et postes</h4>
                         

                            <div class="row">
                              <div class="col-md-12">
                              	   <a href="<?=base_url('administration/Menus_Profile')?>" class="btn btn-primary" style="float: right;">Nouveau</a>
                              <br><br>
                                 <label style="font-weight: 900; color:#454545" id="PROCESS">Poste</label>
                                  <select class="form-control" id="ID_POSTE"  name="ID_POSTE" onchange="get_liste()">
                               <option value=""><?=lang('select')?></option>
                              <?php
                            foreach ($poste as $key => $valu) {
                  

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
                              </div>


                          
                            </div>
                            <br><br>
                             

                           <div class="row">
                           <div class="col-lg-12">
                             <?=$this->session->flashdata('message')?> 
    
                             
                             <div class="table-responsive">
                             <table id="mytable" class="table table-sm table-bordered table-striped" data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
                              <thead class="">
                               <tr>
                                 <!--   <th style="width:5px">#</th> -->
                                   <!-- <th style='width:100px'><font color="black"><label>POSTE</label></font></center></th> -->
                                   <th style='width:100px'><center><font color="black" size="3"><label>Poste</label></font></center></th>
                                  
                                 
                                   <th style='width:70px'><center><font color="black" size="3"><label>Type menu</label></font></center></th>

                                    <th style='width:70px'><center><font color="black" size="3"><label>Menu</label></font></center></th>

                                        <th style='width:70px'><center><font color="black" size="3"><label>Option</label></font></center></th>

                                </tr>
                             </thead>

                            <tbody>
                            </tbody>
                          </table>   
                          </div>
 
                       </div>
                    </div>
               
                                </div> 

                       


                 </div>
              </div>
           </div>
           <!-- end row -->
        </div>
        <!-- footer -->
     
     </div>
     <!-- end dashboard inner -->
  </div>
</div>
</div>

<!-- </div></div></div> -->

<?php include VIEWPATH.'includes/scripts_js.php'; ?>


</body>
</html>


<script>
   $(document).ready(function(){


   $('#message').delay('slow').fadeOut(3000);

      get_liste();

   }); 
</script>
<script type="text/javascript">
 

  function relais_()
  {  
    get_poste();
  
    get_liste();
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
  function get_liste() 
  {  



    var ID_POSTE=$('#ID_POSTE').val();

   
   // alert(STAGE_ID);

   $("#mytable").DataTable({
    "destroy" : true,
    "processing":true,
    "serverSide":true,
    "oreder":[[ 1, 'asc' ]],
    "ajax":{
      url: "<?php echo base_url('administration/Menus_Profile/get_liste/');?>", 
      type:"POST",
      data : {
                ID_POSTE:ID_POSTE,
                          },
      beforeSend : function() {
      }
  },
  lengthMenu: [[5,10,50, 100, -1], [5,10,50, 100, "All"]],
  pageLength: 5,
  "columnDefs":[{
      "targets":[],
      "orderable":false
  }],
  dom: 'Bfrtlip',
  buttons: ['csv', 'excel', 'pdf' ],
  language: {
        "sProcessing":     "<?=lang('datatable_traitement') ?>",
        "sSearch":         " <?=lang('datatable_rechercher') ?>",
        "sLengthMenu":     "<?=lang('datatable_afficher') ?> _MENU_ <?=lang('datatable_elements') ?>",
        "sInfo":           "<?=lang('datatable_affichage_elements') ?> _START_ <?=lang('datatable_a') ?> _END_ <?=lang('datatable_sur') ?> _TOTAL_ <?=lang('datatable_elements') ?>",
        "sInfoEmpty":      "<?=lang('datatable_affichage_elements') ?> 0 <?=lang('datatable_a') ?> 0 <?=lang('datatable_sur') ?> 0 <?=lang('datatable_elements') ?>",
        "sInfoFiltered":   "(<?=lang('datatable_filtre') ?> _MAX_ <?=lang('datatable_elements_total') ?>)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "<?=lang('datatable_loading') ?>",
        "sZeroRecords":    "<?=lang('datatable_elements_afficher') ?>",
        "sEmptyTable":     "<?=lang('datatable_donne_disponible') ?>",
        "oPaginate": {
          "sFirst":      "<?=lang('datatable_premier') ?>",
          "sPrevious":   "<?=lang('datatable_precedent') ?>",
          "sNext":       "<?=lang('datatable_suivant') ?>",
          "sLast":       "<?=lang('datatable_dernier') ?>"
       },
       "oAria": {
          "sSortAscending":  ": <?=lang('datatable_ordre_croissant') ?>",
          "sSortDescending": ": <?=lang('datatable_ordre_decroissant') ?>"
       }
    }
});
}
</script>

