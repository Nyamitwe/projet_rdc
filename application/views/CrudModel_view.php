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
     <?php include VIEWPATH.'includes/topbar.php'; ?> 
     <!-- end topbar -->
     
     <!-- dashboard inner -->
     <div class="midde_cont">
      <div class="container-fluid">
       <div class="row column_title">
        <div class="col-md-12">
         <div class="page_title">
          <h2>Titre de la page</h2>
        </div>
      </div>
    </div>
    <!-- row -->
    <div class="row column1">
      <div class="col-md-12">
       <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
         <div class="heading1 margin_0">
          <h2>Titre de la table</h2>
        </div>
      </div>
      <div class="full price_table padding_infor_info">
       
        <div class="row mb-4">
          <div class="form-group col-lg-3">
            <label style="font-weight: 900; color:#454545">Code de suivi</label>
            <input type="text" class="form-control" placeholder="code de suivi">
          </div>
          <div class="form-group col-lg-3">
            <label style="font-weight: 900; color:#454545">Nom</label>
            <input type="text" class="form-control" placeholder="Nom">
          </div>
          <div class="form-group col-lg-3">
            <label style="font-weight: 900; color:#454545">Prénom</label>
            <input type="text" class="form-control" placeholder="Prénom">
          </div>
          <div class="form-group col-lg-3">
            <label style="font-weight: 900; color:#454545">E-mail</label>
            <input type="emai" class="form-control" placeholder="E-mail">
          </div>
          <div class="form-group col-lg-3">
            <label style="font-weight: 900; color:#454545">Téléphone</label>
            <input type="text" class="form-control" placeholder="Téléphone">
          </div>
          <div class="form-group col-lg-3">
            <label style="font-weight: 900; color:#454545">Numéro du document</label>
            <input type="text" class="form-control" placeholder="Numéro du document">
          </div>
          
          <div class="form-group col-lg-3">
            <label style="font-weight: 900; color:#454545">Avis</label>
            <select class="form-control">
              <option>Non traité</option>
              <option>Favorable</option>
            </select>
          </div>
          <div class="form-group col-lg-3">
           <button style="margin-top: 20px" class="main_bt">Chercher</button>
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
</div></div></div>

<script>
 
  $(document).ready(function() {
    $('#example').DataTable();
  } );
  

</script>


<?php include VIEWPATH.'includes/scripts_js.php'; ?>


<!--  -->



</body>
</html>