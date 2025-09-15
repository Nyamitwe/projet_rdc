<?php
//Page affichage d'erreur
//eriel@mediabox.bi
//02-12-2024
//Affichage des erreurs dynamiquement
class Erreur extends CI_Controller
{
    public function show_404() 
	{
        $this->output->set_status_header('404'); // Set HTTP Status code to 404
        $this->load->view('Erreur_view'); // Load your custom 404 view
    }
}

?>