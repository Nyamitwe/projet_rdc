<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Property Management System</title>
  <!-- site icon -->
  <link rel="icon" href="<?php echo base_url() ?>template/images/favicon-16x16.png" type="image/png" />
  <!-- bootstrap css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/bootstrap.min.css" />

  <!-- site css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/style.css" />
  <!-- responsive css --> 

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- font awesome --> 
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/responsive.css" />
  <!-- color css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/colors.css" />
  <!-- select bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/bootstrap-select.css" />
  <!-- scrollbar css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/perfect-scrollbar.css" />
  <!-- custom css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/custom.css" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->





    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>


    <link rel="stylesheet" href="<?= base_url() ?>template/vendor/select2/css/select2.min.css">

    <link href="<?= base_url() ?>template/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url() ?>template/css/buttons.dataTables.min.css" />

    <script src="<?php echo base_url() ?>Design/vendor/bootstrap/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="<?php echo base_url() ?>template/onlinescripts/dataTables.bootstrap4.min.css" />
    <link href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet">


    <script src="<?php echo base_url() ?>template/onlinescripts/jquery.min.js" type="text/javascript"></script>

    <script src="http://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>


    <script src="<?php echo base_url() ?>template/onlinescripts/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

      <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

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
       <br>

       <?php

       $menu1="nav-link active";
       $menu2="nav-link";
       $menu3="nav-link";
       $menu4="nav-link";
       $menu5="nav-link";
       $menu6="nav-link";



       ?>


       <div class="row column1">
         <div class="col-md-12">
          <div class="white_shd full margin_bottom_30" style="padding: 0px;">

           <div class="full price_table padding_infor_info">

            <div class="row">
              <div class="col-md-12">
                <br>
                <center><h2>Recherche d'une parcelle dans Edrms</h2></center>
              </div>
            </div>

            <hr>

            <div class="dropdown col-md-3">

              <button class="btn btn-dark" onclick="history.go(-1)"><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?= lang('button_retour')?> </button>
            </div>
            <?=$this->session->flashdata('message')?>
            <br>

            <!-- <form  action="<?php echo base_url('administration/Recherche/save')?>"  method="post" name="myform" id="myform" > -->


              <div class="row">
              
              <input type="hidden" name="TICKET" id="TICKET" value="<?=$ticket?>">                        


              <?php echo $result;?>




        </div>

      <!-- </form> -->
    </div>
  </div>
</div>
<!-- end row -->
</div>


</div>
<!-- end dashboard inner -->
</div>
</div></div></div>

<!--- modal pour Afficher les fichiers de type Tiff d'Alfresco---->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fichier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="status-input" value="">
      <div id="canvas"></div>          
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('btn_ferme')?></button>
    </div>
  </div>
</div>
</div>

<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>template/js/bootstrap.min.js"></script>


</body>
</html>

<script>
  function geturl(url,filename)
  {
    var ticket=$('#TICKET').val();

    // href="http://141.95.148.19:1620/alfresco/s/api/node/content/'.$get_data_json_items_node_ref_explode_token.'?a=false&alf_ticket='.$ticket.' "

    const w = 600;
    const h = 700;

    const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
    const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var url = 'http://154.117.208.115:1620/alfresco/s/api/node/content/workspace/SpacesStore/'+url+'?a=false&alf_ticket='+ticket+'#toolbar=0';

    var title = 'Document EDRMS';

    const systemZoom = width / window.screen.availWidth;
    const left = (width - w) / 2 / systemZoom + dualScreenLeft;
    const top = (height - h) / 2 / systemZoom + dualScreenTop;

    const newWindow = window.open(url, title, 
      `
      scrollbars=yes,
      width=${w / systemZoom}, 
      height=${h / systemZoom}, 
      top=${top}, 
      left=${left}
      
      `
      )

    if (window.focus) newWindow.focus();
  }
</script>
      <script type="text/javascript" src="<?php echo base_url() ?>js/tiff.min.js"></script>





      <script>//premiere version
        function afficheTiff (get_data_json_items_node_ref_explode_token,i) {

        var nodeRef = get_data_json_items_node_ref_explode_token;
        var ticket=$('#TICKET').val();       

        let formData = new FormData();
        var xhr = new XMLHttpRequest();
        var ticket=$('#TICKET').val();        
        var url ='<?= base_url('administration/Recherche/saveTiff') ?>';
        formData.append("token",nodeRef);
        xhr.open('POST', url);
        xhr.onload = () => {
          // alert(xhr.status)
          var status;
          if (xhr.status === 200)
          {
            status = 1;
            // Update the value of the input element
            document.getElementById('status-input').value = status;
            // Call the function to display the file
            displayTiffFile(nodeRef);
          } 
          else 
          {
            status = 2;
            // Update the value of the input element
            document.getElementById('status-input').value = status;
            $('#canvas').html('<div class="alert alert-info">Fichier Indisponible.</div>');
          }

        };
        xhr.send(formData);

          // Get the modal
          var modal = document.getElementById("myModal");
              modal.style.display = "block";



          // Get the button that opens the modal
          var btn = document.getElementById("myBtn"+i);

          // Get the <span> element that closes the modal
          var span = document.getElementsByClassName("close")[0];

          // When the user clicks the button, open the modal 
          btn.onclick = function() {
            modal.style.display = "block";
          }

          // When the user clicks on <span> (x), close the modal
          span.onclick = function() {
            modal.style.display = "none";
          }

          // When the user clicks anywhere outside of the modal, close it
          window.onclick = function(event) {
            if (event.target == modal) {
              modal.style.display = "none";
            }
          } 
            }

            function displayTiffFile(nodeRef)
            {
              var url = '<?= base_url() . 'uploads/tiff/' ?>' + nodeRef + '.tiff';
              var xhr = new XMLHttpRequest();
              xhr.responseType = 'arraybuffer';
              xhr.open('GET', url);
              xhr.onload = function (e) {
                            var tiff = new Tiff({ buffer: xhr.response });
                            var canvas = tiff.toCanvas();
                $('#canvas').html(''); // Clear any previous content
                $('#canvas').append(canvas);
              };
              xhr.send(null);
            }
       </script>
       <style>
              canvas {
                     width: 100%;
                     height: 500px;
                      }
       </style>


