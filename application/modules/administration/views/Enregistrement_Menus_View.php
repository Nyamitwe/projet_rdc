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
  										<a href="#" class="btn btn-dark" style="float: lefet;">Enregistrement des menus</a>
  										<br><br>
  										    <a href="<?=base_url('administration/Enregistrement_Menus/liste')?>" class="btn btn-primary" style="float: right;">Liste</a>
                              <br><br>
  									 <?=$this->session->flashdata('message')?> 
  									</div> 

  									<div class="full price_table padding_infor_info">
  										<form class="form-horizontal" method="post" id="myform" action="<?php echo base_url('administration/Enregistrement_Menus/save')?>"  enctype="multipart/form-data">                                 
  											<div class="row mb-4" style="margin-left: 20px;margin-right: 20px">
  												<div class="form-group col-lg-12">    
  													<label style="font-weight: 900; color:#454545">Nom du menu</label>

  													<input type="TEXT" name="ID_PMS_MENU" id="ID_PMS_MENU" class="form-control">

  													<span class="help-block" style="color: red" id="error1" ></span>
  												</div>

  													<div class="form-group col-lg-12">

  													<label style="font-weight: 900; color:#454545" >Type menu</label>

  													<select class="form-control" name="TYPE_MENU" id="TYPE_MENU">
  														<option value="" selected>Selectionner</option>

  														<?php foreach ($type_menu as $key => $value) 
  														{
  															
  														?>
  															<option value="<?=$value['ID_TYPE_MENU'];?>"><?=$value['DESC_TYPE_MENU'];?></option>
  												
  													

  														<?php
  													   }
  													   ?>

  													

  													</select>
                                       <span class="help-block" id="error3" style="color: red"></span>
  													



  												</div>

  												<div class="form-group col-lg-12">    
  													<label style="font-weight: 900; color:#454545" id="ID_PMS_MENU">Lien du menu</label>

  													<input type="TEXT" name="LINK" id="LINK" class="form-control">

  													<span class="help-block" id="error2" style="color: red"></span>
  												</div>


  											






  											</div>





  											<div class="row mb-4" id="btnn" style="margin-left: 20px;margin-right: 20px;border-size: 3px;border-color:black;">
  												<div class="form-group col-lg-12">
  													<button type="button" class="btn btn-info form-control" id="btnSave" style="margin-top: 20px" class="main_bt" onclick="send_form()">Enregistrer</button>
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
	function send_form()
	{


		var form=document.getElementById('myform');

		var ID_PMS_MENU=$('#ID_PMS_MENU').val();
		var LINK=$('#LINK').val();
		var TYPE_MENU=$('#TYPE_MENU').val();


		$sms='';

		$statut=1;

		if (ID_PMS_MENU=='') {

			$('#error1').html("Champ obligatoire !!");
			
			$statut=0;


		}



     if (TYPE_MENU=='') {

			$('#error3').html("Champ obligatoire !!");

			$statut=0;


		}



		if (LINK=='') {

		

         if (TYPE_MENU!=1) {
			$('#error2').html("Champ obligatoire !!");

			$statut=0;
			}


		}


		


		if ($statut==1) {

			form.submit();
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
    	$.post('<?php echo base_url('administration/Affect_Documents/get_poste')?>',
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
    	$.post('<?php echo base_url('administration/Affect_Documents/get_stage')?>',
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

