<!DOCTYPE html>
<html lang="en">
<head>
  <?php include VIEWPATH.'includes/header.php'; ?>

  <style type="text/css">
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
      color: #fff;
      background-color: #17a2b8;
    }
    .table-responsive {
      overflow-x: auto;
      max-width: 100%;
    }

    .full-width {
      width: 100% !important;
      margin-right: 0 !important;
      padding-right: 0 !important;
    }

    /* Styles spécifiques pour les accordéons côte à côte */
    .accordion-side-by-side {
      display: flex;
      gap: 20px;
      width: 100%;
    }
    
    .accordion-column {
      flex: 1;
    }
    
    /* Styles pour ressembler à votre image */
    .accordion .card {
      border: 1px solid #dee2e6;
      border-radius: 0.25rem;
      margin-bottom: 15px;
    }
    
    .accordion .card-header {
      background-color: #1b5c6e;
      border-bottom: 1px solid #1b5c6e;
      padding: 0;
    }
    
    .accordion .btn-link {
      display: block;
      width: 100%;
      text-align: left;
      padding: 15px 130px;
      color: #dee2e6;
      text-decoration: none;
      font-weight: 600;
      background: none;
      border: none;
      position: relative;
    }
    
    .accordion .btn-link:after {
      content: '\f107';
      font-family: 'FontAwesome';
      float: right;
      transition: transform 0.3s;
    }
    
    .accordion .btn-link.collapsed:after {
      transform: rotate(-90deg);
    }
    
    .accordion .btn-link:hover {
      background-color: #e9ecef;
      color: #495057;
      text-decoration: none;
    }
    
    .accordion .card-body {
      padding: 15px;
      background-color: #fff;
    }
    
    .accordion .card-body a {
      color: #17a2b8;
      text-decoration: none;
    }
    
    .accordion .card-body a:hover {
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .accordion-side-by-side {
        flex-direction: column;
      }
      .accordion .btn-link {
        padding: 15px 20px;
      }
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
        <div class="midde_cont" >
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <div class="row">
                    <div class="col-md-6">
                      <h2>
                        <i class="fa fa-bars" aria-hidden="true"></i> Détail de <?= $data['NOM'].' '.$data['PRENOM'] ?>
                      </h2>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-2">
                     <button 
                     type="button" 
                     onclick="window.location.href='<?= base_url('utilisateurs/Employe/') ?>'" 
                     class="btn" 
                     style="background-color:#1b5c6e; color:white; border:1px solid #020f12;"
                     >
                     <i class="fa fa-reply"></i> Retour
                   </button>
                   <div class="btn-group">
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
         
         <div class="row">
          <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
              <div class="full graph_head">
                <div class="heading1 margin_0">
                  <div class="row">
                    <div class="col-md-12 text-right">
                    </div>
                  </div>

                  <!-- Conteneur pour les accordéons côte à côte -->
                  <div class="accordion-side-by-side">
                    
                    <!-- Colonne gauche -->
                    <div class="accordion-column">
                      <div class="accordion" id="accordionLeft">
                        
                        <!-- Informations personnelles -->
                        <div class="card">
                          <div class="card-header" id="headingOneLeft">
                            <h2 class="mb-0">
                              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOneLeft" aria-expanded="true" aria-controls="collapseOneLeft">
                                Informations personnelles
                              </button>
                            </h2>
                          </div>
                          <div id="collapseOneLeft" class="collapse show" aria-labelledby="headingOneLeft" data-parent="#accordionLeft">
                            <div class="card-body">
                              <b>Nom</b> : <?= $data['NOM'].' '.$data['PRENOM'] ?><br>
                              <b>Email</b> : <?= $data['email'] ?><br>
                              <b>Téléphone</b> : <?= $data['mobile'] ?><br>
                              <b>Nationalité</b> : <?= $data['name'] ?><br>
                            </div>
                          </div>
                        </div>

                        <!-- Poste et service -->
                        <div class="card">
                          <div class="card-header" id="headingTwoLeft">
                            <h2 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwoLeft" aria-expanded="false" aria-controls="collapseTwoLeft">
                                Poste et service
                              </button>
                            </h2>
                          </div>
                          <div id="collapseTwoLeft" class="collapse" aria-labelledby="headingTwoLeft" data-parent="#accordionLeft">
                            <div class="card-body">
                              <b>Poste</b> : <?= ($data['POSTE_ID'] !=0) ? $data['POSTE'] : $data['AUTRE_POSTE'] ?><br>
                              <b>Chef </b>: "N/A"
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="accordion-column">
                      <div class="accordion" id="accordionRight">
                        
                        <!-- Informations de contrat -->
                        <div class="card">
                          <div class="card-header" id="headingOneRight">
                            <h2 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOneRight" aria-expanded="false" aria-controls="collapseOneRight">
                                Informations de contrat
                              </button>
                            </h2>
                          </div>
                          <div id="collapseOneRight" class="collapse" aria-labelledby="headingOneRight" data-parent="#accordionRight">
                            <div class="card-body">
                              <b>Type :</b> <?= htmlspecialchars($data['CONTRAT'], ENT_QUOTES, 'UTF-8') ?><br>

                              <b>Date d'embauche :</b> 
                              <?= !empty($row->DATE_RECRUTEMENT) ? date('d/m/Y', strtotime($row->DATE_RECRUTEMENT)) : 'Non définie' ?><br>

                              <?php if (isset($data['TYPE_CONTRAT_ID']) && $data['TYPE_CONTRAT_ID'] == 0 && !empty($row->DATE_EXPIRATION)) : ?>
                              <b>Date d'expiration :</b> <?= date('d/m/Y', strtotime($row->DATE_EXPIRATION)) ?><br>
                              <?php endif; ?>

                              <b>Salaire :</b> N/A
                            </div>
                          </div>
                        </div>

                        <!-- Documents et pièces jointes -->
                        <div class="card">
                          <div class="card-header" id="headingTwoRight">
                            <h2 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwoRight" aria-expanded="false" aria-controls="collapseTwoRight">
                                Documents
                              </button>
                            </h2>
                          </div>
                          <div id="collapseTwoRight" class="collapse" aria-labelledby="headingTwoRight" data-parent="#accordionRight">
  <div class="card-body">
 

<!-- <strong>Contrat signé :</strong> <a href="#">Voir PDF</a><br> -->
<strong>Contrat signé :</strong> "N/A"<br>
    


<!-- ======================= CV ======================= -->
<b>CV :</b>
<?php if (!empty($data['PATH_CV'])): ?>
    <?php 
        $fileUrl = base_url('uploads/doc_scanner/'.$data['PATH_CV']);
        $safeFileName = $data['PATH_CV'];
        $fileExt = strtolower(pathinfo($safeFileName, PATHINFO_EXTENSION));
        $modalId = "fichierCV"; 
    ?>

    <!-- Bouton pour ouvrir le modal -->
    <a href="#" data-toggle="modal" data-target="#<?= $modalId ?>" class="btn btn-default btn-sm">
        <i class="fa fa-file" style="font-size:20px"></i> Voir
    </a>

    <!-- Modal SIMPLIFIÉ -->
    <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-file"></i> <?= $safeFileName ?></h4>
                </div>
                <div class="modal-body" style="min-height:60vh;">
                    <?php if (in_array($fileExt, ['png','jpg','jpeg','gif'])): ?>
                        <!-- AFFICHAGE IMAGE SIMPLE -->
                        <div style="text-align:center;">
                            <img src="<?= $fileUrl ?>" 
                                 style="max-width:100%; max-height:60vh;" 
                                 alt="<?= $safeFileName ?>">
                        </div>
                    <?php elseif ($fileExt === 'pdf'): ?>
                        <!-- AFFICHAGE PDF SIMPLE -->
                        <iframe src="<?= $fileUrl ?>" width="100%" height="500px" frameborder="0"></iframe>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            Aucune prévisualisation disponible.<br>
                            <a href="<?= $fileUrl ?>" class="btn btn-primary mt-2" download>
                                <i class="fa fa-download"></i> Télécharger le fichier
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <a href="<?= $fileUrl ?>" class="btn btn-primary text-white" download="<?= $safeFileName ?>">
                        <i class="fa fa-download"></i> Télécharger
                    </a>
                    <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-success text-white">
                        <i class="fa fa-external-link"></i> Ouvrir
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    N/A
<?php endif; ?>
<br>

<!-- ======================= DIPLOME ======================= -->
<b>Diplôme :</b>
<?php if (!empty($data['PATH_DIPLOME'])): ?>
    <?php 
        $fileUrl = base_url('uploads/doc_scanner/'.$data['PATH_DIPLOME']);
        $safeFileName = $data['PATH_DIPLOME'];
        $fileExt = strtolower(pathinfo($safeFileName, PATHINFO_EXTENSION));
        $modalId = "fichierDiplome"; 
    ?>

    <!-- Bouton pour ouvrir le modal -->
    <a href="#" data-toggle="modal" data-target="#<?= $modalId ?>" class="btn btn-default btn-sm">
        <i class="fa fa-file" style="font-size:20px"></i> Voir
    </a>

    <!-- Modal SIMPLIFIÉ -->
    <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-file"></i> <?= $safeFileName ?></h4>
                </div>
                <div class="modal-body" style="min-height:60vh;">
                    <?php if (in_array($fileExt, ['png','jpg','jpeg','gif'])): ?>
                        <!-- AFFICHAGE IMAGE SIMPLE -->
                        <div style="text-align:center;">
                            <img src="<?= $fileUrl ?>" 
                                 style="max-width:100%; max-height:60vh;" 
                                 alt="<?= $safeFileName ?>">
                        </div>
                    <?php elseif ($fileExt === 'pdf'): ?>
                        <!-- AFFICHAGE PDF SIMPLE -->
                        <iframe src="<?= $fileUrl ?>" width="100%" height="500px" frameborder="0"></iframe>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            Aucune prévisualisation disponible.<br>
                            <a href="<?= $fileUrl ?>" class="btn btn-primary mt-2" download>
                                <i class="fa fa-download"></i> Télécharger le fichier
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <a href="<?= $fileUrl ?>" class="btn btn-primary text-white" download="<?= $safeFileName ?>">
                        <i class="fa fa-download"></i> Télécharger
                    </a>
                    <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-success text-white">
                        <i class="fa fa-external-link"></i> Ouvrir
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    N/A
<?php endif; ?>
<br>



  </div>
</div>

</div>
</div></div></div>

<form>
  <div class="col-md-12">
  <style>
.slider-container {
  width: 300px;
  height: 50px;
  background: #ddd;
  border-radius: 50px;
  position: relative;
  overflow: hidden;
  user-select: none;
  margin: 20px 0;
}

.slider-button {
  width: 50px;
  height: 50px;
  background: #6c757d;
  border-radius: 50%;
  position: absolute;
  top: 0;
  left: 0;
  cursor: grab;
  transition: background 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.slider-text {
  position: absolute;
  width: 100%;
  height: 100%;
  line-height: 50px;
  text-align: center;
  font-weight: bold;
  color: #333;
  pointer-events: none;
}
</style>

<!-- <div class="slider-container" id="slider">
  <div class="slider-text" id="sliderText">Glisser pour valider</div>
  <div class="slider-button" id="sliderBtn"><i class="fa fa-arrow-right"></i></div>
</div> -->

<script>
const slider = document.getElementById('slider');
const sliderBtn = document.getElementById('sliderBtn');
const sliderText = document.getElementById('sliderText');
let isDragging = false;
let status = null;
const userId = '<?= md5($row->id) ?>';

sliderBtn.addEventListener('mousedown', (e) => {
  isDragging = true;
  document.body.style.userSelect = 'none'; // empêche la sélection de texte
});

document.addEventListener('mousemove', (e) => {
  if (!isDragging) return;

  const rect = slider.getBoundingClientRect();
  const btnWidth = sliderBtn.offsetWidth;
  let offset = e.clientX - rect.left - btnWidth / 2;

  offset = Math.max(0, Math.min(offset, rect.width - btnWidth));
  sliderBtn.style.left = offset + 'px';
});

document.addEventListener('mouseup', () => {
  if (!isDragging) return;
  isDragging = false;
  document.body.style.userSelect = ''; // réactive la sélection

  const rect = slider.getBoundingClientRect();
  const btnWidth = sliderBtn.offsetWidth;
  const currentLeft = parseInt(sliderBtn.style.left || 0);
  const middle = rect.width / 2;

  if (currentLeft + btnWidth / 2 >= middle) {
    sliderBtn.style.left = (rect.width - btnWidth) + 'px';
    sliderBtn.style.background = '#28a745';
    sliderBtn.innerHTML = '<i class="fa fa-check"></i>';
    sliderText.innerText = 'Validé ✅';
    status = 1;
  } else {
    sliderBtn.style.left = '0px';
    sliderBtn.style.background = '#dc3545';
    sliderBtn.innerHTML = '<i class="fa fa-times"></i>';
    sliderText.innerText = 'Annulé ❌';
    status = 0;
  }

  fetch('<?= base_url("utilisateurs/Employe/activer_desactiver") ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: userId, is_active: status })
  })
  .then(response => response.json())
  .then(data => {
    console.log('Réponse du serveur:', data);
  })
  .catch(error => {
    console.error('Erreur AJAX:', error);
  });
});
</script>




 
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
    </div>
  </div>
  <!-- end dashboard inner -->
</div>

<!-- Script pour corriger le fonctionnement des accordéons -->
<script>
$(document).ready(function() {
  // S'assurer que Bootstrap est chargé correctement
  if (typeof $().collapse === 'function') {
    // Réinitialiser tous les accordéons
    $('.collapse').collapse({toggle: false});
    
    // Ouvrir seulement le premier accordéon de la colonne gauche
    $('#collapseOneLeft').collapse('show');
    
    // Gérer le comportement des accordéons
    $('.accordion .btn-link').on('click', function() {
      var target = $(this).data('target');
      var isCollapsed = $(this).hasClass('collapsed');
      
      // Fermer tous les autres accordéons dans le même groupe
      var parentAccordion = $(this).closest('.accordion').attr('id');
      $('#' + parentAccordion + ' .collapse').not(target).collapse('hide');
      $('#' + parentAccordion + ' .btn-link').not(this).addClass('collapsed');
      
      // Basculer l'accordéon actuel
      if (isCollapsed) {
        $(this).removeClass('collapsed');
        $(target).collapse('show');
      } else {
        $(this).addClass('collapsed');
        $(target).collapse('hide');
      }
    });
  }
});
</script>

</body>
</html>




                      
                      

    <!--                 </div>
                  </div>



                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>
</body> -->


<?php include VIEWPATH.'includes/scripts_js.php'; ?>


</body>
</html>

