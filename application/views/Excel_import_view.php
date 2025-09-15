<!DOCTYPE html>
<html lang="en">
<head>
  <?php include VIEWPATH.'includes/header.php'; ?>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
  <link href="path/to/multiselect.css" media="screen" rel="stylesheet" type="text/css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
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
      <div id="content">
        <!--topbar -->
        <?php include VIEWPATH.'includes/topbar.php'; ?>
        <div class="midde_cont">
          <div class="container-fluid" style="padding: 0px;">
            <br>
            <br>
            <!-- row -->
            <div class="row column1">
              <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                  <!-- <div class="full graph_head">
                    <a style="" class="btn btn-info" id="newpage" href="<?=base_url('ihm/Backend_Users/liste')?>"><font class="fa fa-list"></font> Liste des utilisateurs</a>
                  </div> --> 
                  <div class="full price_table padding_infor_info">
                    <form method="post" action="<?=base_url()?>Excel_import/import" enctype="multipart/form-data">
                      <div class="row mb-4">
                        <div class="form-group col-lg-6">
                          <label style="font-weight: 900; color:#454545">Upload file</label>
                          <input type="file" class="form-control" id="file" name="file" placeholder="Upload file">
                        </div>
                        <hr>
                        <div class="form-group col-lg-9">
                        </div>
                        <div class="form-group col-lg-3">
                          <button class="btn btn-info btn-block">Enregister</button>
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