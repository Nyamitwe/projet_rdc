<!DOCTYPE html>
<html lang="en">
<head>
      <?php include VIEWPATH.'includes/header.php'; ?>

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
                     
                    <h4 class="text-center">Envoyer l'attestation de non-redevabilité</h4><br>
              
                      <br>
                  <?= $this->session->flashdata('message') ?>  

                      
                <form enctype="multipart/form-data" action="<?= base_url('Rapport/upload1') ?>" method="POST" id="Myform">
               

                  <input type="hidden" name="id" value="<?=$id?>">
                 
                        <fieldset>
                          <div class="form-group">
      <label class="form-label">Attestation <span style="color: red;">*</span></label>
       <input type="file" name="PATH_FILE" id="PATH_FILE" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" required="true" class="form-control">

         
                     <span class="help-block"></span>
                   </div>



              <div class="col-md-12">
                <button type="submit" class="btn btn-info form-control">Envoyer</button>
              </div>

                         
                        </fieldset>
                    </form>  


                  </div>

               </div>
            </div>
         </div>
      </div>
      
 <?php include VIEWPATH.'includes/scripts_js.php'; ?>
   </body>


<script type="text/javascript">
    
  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');
    });
</script>





</html>