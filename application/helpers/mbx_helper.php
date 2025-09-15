<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//Helper pour la gestion des uploads
if (!function_exists('file_upload')) {

    function file_upload($file, $config = array()) {
        //recuperation de l'instance de codeigniter
        $ci = & get_instance();
        //chargement de la librairie Upload + initialisations des configurations
        $ci->load->library("upload");
        $ci->upload->initialize($config);
        //test des erreurs lors du upload, s'il y en a on retourne les details de l'erreur
        if (!$ci->upload->do_upload($file)) {
            $error = array('error' => $ci->upload->display_errors());
            return $error;
        }
        //s'il n'y a pas d'erreurs, on fait le upload du fichier
        $data = array('upload_data' => $ci->upload->data());
        $path = $data["upload_data"]["file_name"];
        return $path;
    }

}