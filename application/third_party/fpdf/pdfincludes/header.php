<?php
        $url = base_url();
        $elements = explode("/", $url);
      // $nouveau_url = $url ;
       $nouveau_url = null ;
        $indice = sizeof($elements);
        for ($i = 0; $i < ($indice - 2); $i++) {
            $nouveau_url .=$elements[$i] . '/';
        }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="shortcut icon" href="<?php echo $nouveau_url ?>assetsFront/images/content/logo.png" type="image/x-icon"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $nouveau_url ?>assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $nouveau_url ?>assets/bootstrap/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $nouveau_url ?>assets/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $nouveau_url ?>assets/style/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $nouveau_url ?>assets/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $nouveau_url ?>assets/dropzone/dropzone.min.css">

    <link rel="stylesheet" href="<?php echo $nouveau_url ?>assets/datepicker/css/jquery-ui.css.css" type="text/css">        
    <link rel="stylesheet" href="<?php echo $nouveau_url ?>assets/datepicker/css/datepicker.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $nouveau_url ?>assets/leaflet/leaflet.css" type="text/css">

    
    <script type="text/javascript" src="<?php echo $nouveau_url ?>assets/jquery/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $nouveau_url ?>assets/datatable/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $nouveau_url ?>assets/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $nouveau_url ?>assets/jquery/jquery-paginate.min.js"></script>

    <script src="<?php echo $nouveau_url ?>assets/datepicker/js/bootstrap-datepicker.js"></script>
    <!-- <script src="<?php echo base_url()?>assets/datepicker/js/jquery.min.js"></script>  -->
    <!-- <script src="<?php echo base_url()?>assets/datepicker/js/jquery-ui.js"></script> -->
    <script src="<?php echo $nouveau_url ?>assets/dropzone/dropzone.min.js"></script>
    <script src="<?php echo $nouveau_url ?>assets/leaflet/leaflet.js"></script>

        <!-- Hichart -->
    <script src="<?php echo $nouveau_url ?>highcharts/code/highcharts.js"></script>
<script src="<?php echo $nouveau_url ?>highcharts/code/modules/sunburst.js"></script>
<script src="<?php echo $nouveau_url ?>highcharts/code/modules/exporting.js"></script>
<script src="<?php echo $nouveau_url ?>highcharts/code/modules/export-data.js"></script>
<script src="<?php echo $nouveau_url ?>highcharts/code/highcharts-3d.js"></script>

	<title>Expertis</title>
</head>
<body>
	<div class="container">
		