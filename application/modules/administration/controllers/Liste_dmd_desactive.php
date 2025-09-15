<?php

/**
* @	Edmond pro
* DATE  :12/04/2025
* contact: 71407706
* 
* 
*/


class Liste_dmd_desactive extends CI_Controller
{
	
	public function __construct(){
		parent::__construct();
		require('fpdf184/fpdf.php');
		
	}
	
	function index()
	{		
		$PMS_USER_ID = $this->session->userdata('PMS_USER_ID');
		$PMS_POSTE = $this->session->userdata('PMS_POSTE_ID');
		$PMS_SERVICE_ID = $this->session->userdata('PMS_SERVICE_ID');

		
		$data['selecttoo']=$this->Model->getRequete("SELECT distinct `USER_BACKEND_ID`, CONCAT(NOM,' ',PRENOM) nom FROM `pms_user_backend` JOIN pms_designation_expert ON pms_designation_expert.ID_EXPERT=pms_user_backend.USER_BACKEND_ID WHERE 1");
		$data['userdef']=0;

       if (in_array($PMS_POSTE, [1,15, 12, 25, 7])) {
       $data['userdef']=2;
       }
		
		$this->load->view('Liste_dmd_desactive_View',$data);
	}


	function liste()
	{
		

        $USER_BACKEND_ID=$this->input->post('USER_BACKEND_ID');
		$PMS_USER_ID = $this->session->userdata('PMS_USER_ID');
		$PMS_POSTE = $this->session->userdata('PMS_POSTE_ID');
		$PMS_SERVICE_ID = $this->session->userdata('PMS_SERVICE_ID');
		$cond = '';
       if (in_array($PMS_POSTE, [15, 12, 25, 7])) {
       $cond .= ' AND pms_poste_service.`ID_SERVICE`=' . $PMS_SERVICE_ID;
       }


       if ($USER_BACKEND_ID) {
       $cond .= ' AND USER_BACKEND_ID=' . $USER_BACKEND_ID;
       }

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		
		$limit='LIMIT 0,10';
		
		if($_POST['length'] != -1) {
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		
		
		$query_principal="SELECT
		trait_demande.DATE_DECLARATION,
		trait_demande.ID_TRAITEMENT_DEMANDE,
		trait_demande.PROCESS_ID,
		trait_demande.CODE_DEMANDE,
		trait_demande.NUMERO_PARCELLE,
		trait_demande.ID_TRAITEMENT_DEMANDE,
		CONCAT( '<b>', trait_demande.CODE_DEMANDE, '</b><br>', UPPER(pp.DESCRIPTION_PROCESS) ) code_req,
		(
		SELECT
		st.DESCRIPTION_STAGE
		FROM
		pms_stage st
		WHERE
		st.STAGE_ID = trait_demande.STAGE_ID
		)
		STAGES,
		DATE_FORMAT(
		trait_demande.DATE_DECLARATION,
		'%D %M %Y')SUBMITTED_ON_DATE
		FROM
		pms_traitement_demande trait_demande
		LEFT JOIN pms_process pp ON
		pp.PROCESS_ID = trait_demande.PROCESS_ID
		WHERE (EST_CLOTURE = 0 AND trait_demande.IS_ACTIVE = 0)";

		
		$order_column=array("trait_demande.ID_TRAITEMENT_DEMANDE");
		
		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY trait_demande.ID_TRAITEMENT_DEMANDE  ASC';
		
		$search = !empty($_POST['search']['value']) ? (" AND (CONCAT( '<b>', trait_demande.CODE_DEMANDE, '</b><br>', UPPER(pp.DESCRIPTION_PROCESS) ) LIKE '%$var_search%' OR trait_demande.CODE_DEMANDE LIKE '%$var_search%' OR trait_demande.NUMERO_PARCELLE LIKE '%$var_search%')") : '';
		
		
		$critaire="";
		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;
		 
		$fetch_data= $this->Model->datatable($query_secondaire);
		 // print_r($fetch_data);die();
		$data = array();
		$u=0;
		
		foreach ($fetch_data as $row) {
	 $User=$this->Model->getRequeteOne("SELECT `MOTIF`,CONCAT(pms_user_backend.NOM,' ',pms_user_backend.PRENOM) nom FROM `demande_historique_activation` JOIN pms_user_backend ON pms_user_backend.USER_BACKEND_ID=demande_historique_activation.USER_ID WHERE 	ID_TRAITEMENT_DEMANDE=".$row->ID_TRAITEMENT_DEMANDE." AND IS_ACTIVE=1");
		 $User_v = ($User && $User['nom']) ? $User['nom'] : 'N/A' ;
		 $Motif_v = ($User && $User['MOTIF']) ? $User['MOTIF'] : 'N/A' ;
		
			$u++;
			$sub_array = array();
			$sub_array[]=$u;
			$sub_array[]= '<b>'.$row->code_req.'</b>';
			$sub_array[]=$row->STAGES;
			$sub_array[]=$row->SUBMITTED_ON_DATE;
			$sub_array[]=$User_v;
		    $sub_array[]=$Motif_v; 
			$sub_array[] = '
<div class="comment-wrapper">
    <button class="btn-comment" onclick="showCommentModal('.$row->ID_TRAITEMENT_DEMANDE.')">
        <i class="fas fa-edit"></i>&nbspActiver
    </button>

    <div class="comment-modal" id="commentModal'.$row->ID_TRAITEMENT_DEMANDE.'">
        <div class="modal-box">
            <h4>Ajouter un commentaire <span class="required">*</span></h4>
            <form id="commentForm'.$row->ID_TRAITEMENT_DEMANDE.'" onsubmit="return validateComment('.$row->ID_TRAITEMENT_DEMANDE.')">
                <textarea id="commentInput'.$row->ID_TRAITEMENT_DEMANDE.'" 
                         class="comment-textarea" 
                         placeholder="Votre commentaire..." 
                         required></textarea>
                <div class="error-message" id="error'.$row->ID_TRAITEMENT_DEMANDE.'"></div>
                
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeCommentModal('.$row->ID_TRAITEMENT_DEMANDE.')">
                        Annuler
                    </button>
                    <button type="submit" class="btn-submit">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.comment-wrapper {
    position: relative;
    display: inline-block;
}

.btn-comment {
    background: #4e73df;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-comment:hover {
    background: #2e59d9;
}

.comment-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal-box {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    max-width: 90%;
}

.comment-textarea {
    width: 100%;
    height: 120px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    resize: vertical;
    margin: 10px 0;
}

.comment-textarea.error {
    border-color: #e74a3b;
}

.required {
    color: #e74a3b;
}

.error-message {
    color: #e74a3b;
    font-size: 13px;
    min-height: 18px;
    margin-bottom: 10px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-cancel {
    background: #858796;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-submit {
    background: #1cc88a;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}
</style>

';
			
			
			$data[] = $sub_array;
		// }
		}
		
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Model->all_data($query_principal),
			"recordsFiltered" => $this->Model->filtrer($query_filter),
			"data" => $data
		);
		
		echo json_encode($output);
	}
	

  function save_comment() {
    

    $id = $this->input->post('id');
    $comment = $this->input->post('comment');


    if (empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Le commentaire est obligatoire']);
        return;
    }
    $ID_ACTIVE=$this->Model->getRequeteOne("SELECT `CODE_DEMANDE`,`PROCESS_ID`,`STAGE_ID`,ID_REQUERANT,`IS_ACTIVE` FROM `pms_traitement_demande` WHERE `ID_TRAITEMENT_DEMANDE`=".$id."");
    if ($ID_ACTIVE && $ID_ACTIVE['IS_ACTIVE']==1) {
    $ID_ACTIVE_V=0;	
    $obj='Déactivation';
    $act='déactivée';
    $EST_CLOTURE=1;
    }else{
    $ID_ACTIVE_V=1;	
    $obj='Réactivation';
    $act='réactivée';
    $EST_CLOTURE=0;
    }

    $data_act=array(
        'ID_TRAITEMENT_DEMANDE'=>$id,
        'MOTIF'=>$comment,   
        'IS_ACTIVE'=>$ID_ACTIVE_V,
        'USER_ID'=>$this->session->userdata('PMS_USER_ID')
        
    );
    $this->Model->create('demande_historique_activation',$data_act);
    $data_save=array('IS_ACTIVE'=>$ID_ACTIVE_V,'EST_CLOTURE'=>$EST_CLOTURE);

       $result= $this->Model->update('pms_traitement_demande',
              array(
                'ID_TRAITEMENT_DEMANDE'=>$id
              ),
              $data_save);

       $result1 = $this->pms_api->info_requerant($ID_ACTIVE['ID_REQUERANT']);
         $fullname='';
       if (is_object($result1) && isset($result1->data[0]->fullname)) {
              $fullname = $result1->data[0]->fullname;
            }
            $mailTo='';
        if (is_object($result1) && isset($result1->data[0]->email)) {
             $mailTo = $result1->data[0]->email;
            }
            $mobile='';
         if (is_object($result1) && isset($result1->data[0]->mobile)) {
              $mobile = $result1->data[0]->mobile;
            }
      
         $subject=$obj;

       $message="Bonjour ".$fullname.", <br>Votre demande n° ".$ID_ACTIVE['CODE_DEMANDE']." a été traitée et est désormais ".$act." pour le motif suivant :<br>".$comment." <br>Cardialement .";


       $data_notification=array('MESSAGE'=>$message,
        'EMAIL'=>$mailTo,
        'TELEPHONE'=>$mobile,
        'CIBLE'=>2,
        'USER_NOTIFIE'=>$this->session->userdata('PMS_USER_ID'),
        'PROCESS_ID'=>$ID_ACTIVE['PROCESS_ID'],
        'STAGE_ID'=>$ID_ACTIVE['STAGE_ID']
        
      );
       $this->Model->create('pms_notifications',$data_notification);

       $this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$message,$attach=array());



    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur de base de données']);
    }
}
	
	
}
