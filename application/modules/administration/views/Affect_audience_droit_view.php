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
<br><br>
<a href="<?=base_url('administration/Affect_audience_droit/listing')?>" class="btn btn-primary" style="float:left;">Liste</a>
<br><br>
<?=$this->session->flashdata('message')?> 
</div> 

<div class="full price_table padding_infor_info">
<form class="form-horizontal" method="post" id="myform" action="<?php echo base_url('administration/Affect_audience_droit/save')?>"  enctype="multipart/form-data">                                 
<?php if (!empty($message)) : ?>
   <div class="alert alert-success text-center" id="message"><?php echo $message; ?></div>
<?php endif; ?>

<div class="row mb-4" style="margin-left: 20px;margin-right: 20px">


<div class="form-group col-lg-12">
<label style="font-weight: 900; color:#454545" >Service</label>

<select class="form-control" name="SERVICE_ID" id="SERVICE_ID" onchange="get_poste();">
<option value="" selected>Séléctionner</option>



<?php foreach($services as $key => $value) { 
                        if ($value['SERVICE_ID']==set_value('SERVICE_ID')) { 
                          echo "<option value='".$value['SERVICE_ID']."' selected>".$value['DESCRIPTION']."</option>";
                        }  else{
                          echo "<option value='".$value['SERVICE_ID']."' >".$value['DESCRIPTION']."</option>"; 
} }?>  

</select>
<span class="help-block" id="error3" style="color: red"></span>
<?php echo form_error('SERVICE_ID', '<div class="text-danger">', '</div>'); ?>
</div>

<div class="col-lg-12">
<label style="font-weight: 900; color:#454545">Poste<font color="red">*</font></label>
<select class="form-control" name="ID_POSTE" id="ID_POSTE" >
<option value="" selected>Séléctionner</option>
<?php if(!empty($postes)){
    foreach($postes as $key => $value) { 
                        if ($value['ID_POSTE']==set_value('ID_POSTE')) { 
                          echo "<option value='".$value['ID_POSTE']."' selected>".$value['POSTE_DESCR']."</option>";
                        }  else{
                          echo "<option value='".$value['ID_POSTE']."' >".$value['POSTE_DESCR']."</option>"; 
} }}?>
</select>
<?php echo form_error('ID_POSTE', '<div class="text-danger">', '</div>'); ?>

</div>

<div class="form-group col-lg-12">

<label style="font-weight: 900; color:#454545" >Processus</label>

<select class="form-control" name="PROCESS_ID" id="PROCESS_ID" >
<option value="" selected>Séléctionner</option>


<?php foreach($process as $key => $value) { 
                        if ($value['PROCESS_ID']==set_value('PROCESS_ID')) { 
                          echo "<option value='".$value['PROCESS_ID']."' selected>".$value['DESCRIPTION_PROCESS']."</option>";
                        }  else{
                          echo "<option value='".$value['PROCESS_ID']."' >".$value['DESCRIPTION_PROCESS']."</option>"; 
} }?>  


</select>
<span class="help-block" id="error3" style="color: red"></span>
<?php echo form_error('PROCESS_ID', '<div class="text-danger">', '</div>'); ?>

</div>









</div>





<div class="row mb-4" id="btnn" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;">
<div class="form-group col-lg-12">
<button type="submit" class="btn btn-info form-control" id="btnSave" style="margin-top: 20px" class="main_bt" onclick="send_form()">Enregistrer</button>
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




<?php include VIEWPATH.'includes/scripts_js.php'; ?>


</body>
</html>
<script>    
    $('#message').delay('slow').fadeOut(3000);
</script>
<script>
function get_poste()
{
    var SERVICE_ID=$('#SERVICE_ID').val();
    if(SERVICE_ID=='')
    {
        $('#ID_POSTE').html('<option value="">Séléctionner</option>');
    }
    else
    {
        $.ajax(
            {
                url:"<?=base_url()?>administration/Affect_audience_droit/get_poste/"+SERVICE_ID,
                type:"GET",
                dataType:"JSON",
                success: function(data)
                {
                    $('#ID_POSTE').html(data);
                }
            });
            
        }
}
</script>
    
    
    
    
    
    
