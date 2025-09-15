<!DOCTYPE html>
<html lang="en">
<head>
     <?php include VIEWPATH.'includes/header.php' ?>
</head>

<script type="module" src="https://dev.widgets.leapa.co/customer.js"></script>

<!-- <script type="module" src="<?=base_url('assets/leapa/leapa.js')?>"></script> -->

<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

 
<style type="text/css">
  #messerr{
    color: red;
    font-size: 10px;
    text-align: center;
  }

  .ui-coordinates {
      background:transparent;
      position:fixed;
      top:5px;right:5px;
      z-index:1;
      bottom:10px;
      left:2px;
      padding:5px 10px;
      color:transparent;
      font-size:12px;
      border-radius:3px;
      max-height:10px;
     
      width:60px;
      }

  
</style>


<style type="text/css">
	#err_msg{
		font-size: 12px;
	}
</style>

<div class="ui-coordinates">

<!-- <button  class="btn btn-dark " id="kt_quick_user_toggle" onclick="back_scan()"><table><tr><td><font><i class="fa fa-arrow-left"></i></font></td><td>&nbsp;<span id="times"></span></td></tr></table> &nbsp;&nbsp;</button> -->

</div>


 <br>
<section class="" style="margin-top:0px;margin-bottom: 0px">
<div class="container">




                    <div  id="donne_leap">



                            <?php 

                              $serv = 5;
                              $somm = $MONTANT + $serv;

                              $somm = str_replace(",", " ", number_format($somm)); ?>
                            
                            <h2>&nbsp;&nbsp;Montant : <?=$somm?> <?=$UNITET?></h2>
                                  <!-- 
                                <div style="font-size: 15px; background: rgba(27, 27, 27, 0.1);border: 1px solid rgba(27, 27, 27, 0.1);padding: 5px;border-radius: 25%;margin-left: 8px;margin-right: 5px;">
                                 Votre commande  <span style="float:right; color: green"><?=str_replace(",", " ", number_format($MONTANT))?> <?=$UNITET?></span><br>
                                  Frais de service   <span style="float:right; color: green"><?=$serv?> <?=$UNITET?></span><br><b>
                                  Total à payer   <span style="float:right; color: green"><?=$somm?> <?=$UNITET?></span><br></b>
                                </div> -->

                        
                                <input  type="hidden" name="MONTANTS" id="MONTANTS" value="<?=$MONTANT?>">
                                <?=$customerId?>
                                


                
                           </div>





</div>

<!-- <hr>

<span style="font-size: 9px;text-align: center;"> <?=date('d-m-Y')?> MEDIABOX</span>
 -->

</div>
</section>





 <script>
      document.getElementById('leapa').addEventListener('onSuccess', (e) => {
        // event listener for when action is successful
          console.log(JSON.stringify(e.detail));   
          save_leapa(JSON.stringify(e.detail));     
      });



      document.getElementById('leapa').addEventListener('onFailure', (e) => {
        // event listener for when action fails
        console.log(e);
        alerteData3();
      
      });
    </script>


    <script type="text/javascript">
  
  function save_leapa(doone){

    var AMOUNT = $('#MONTANTS').val();

    var formm = new FormData();

    formm.append("doone",doone);
    formm.append("AMOUNT",AMOUNT);
    formm.append("MODE_ID",'2');
    formm.append("ID_COMMANDE",'<?=$this->uri->segment(3)?>');

     $.ajax({
        url : "<?=base_url()?>Historiques/save_leapa/",
        type : "POST",
        dataType: "JSON",
        data: formm,
        processData: false,  
        contentType: false,

          beforeSend:function () { 
               //      let timerInterval
             alerteData1();
          },


          success:function(data) {

            alerteData2(data);
           
        }

   });


  }







  function alerteData1(id=0){
  
              Swal.fire({
                 title: 'Paiement encours !',
                 html: 'Veillez patienter <b></b>  sécondes prés ...',
                 timer: 15000,
                 timerProgressBar: true,
                 didOpen: () => {
                   Swal.showLoading()
                   const b = Swal.getHtmlContainer().querySelector('b')
                   timerInterval = setInterval(() => {
                     b.textContent = Swal.getTimerLeft()
                   }, 100)
                 },
                 willClose: () => {
                   clearInterval(timerInterval)
                 }
               }).then((result) => {
               /* Read more about handling dismissals below */
                 if (result.dismiss === Swal.DismissReason.timer) {
                  console.log('I was closed by the timer')
                 }
               })

} 
  /*Send succss*/
function alerteData2(id=0){

         Swal.fire("Paiement effectué avec succès !", 'Initialiser les formulaire de paiement!', "success");
         back_scan()
} 


function alerteData5(donne = ""){

         Swal.fire("Paiement pris en charge !", donne, "success");

} 
  
  /*Send error*/
function alerteData3(id=0){

          Swal.fire({
                icon: 'error',
                title: 'Erreur...',
                text: 'Erreur de connexion internet!',
                   //footer: '<a href="<?=base_url()?>?</a>'
              })
}


function alerteData6(id=0){

          Swal.fire({
                icon: 'error',
                title: 'Attention!',
                text: 'Nous vous evitons de ne pas faire un double paiement \npour un seul rendez-vous!',
                   //footer: '<a href="<?=base_url()?>?</a>'
              })
}


</script>

 <script>

  function back_scan(){
    //https://app.mediabox.bi/wasiliEat_support/Historiques/index/4
    window.location.assign('<?=base_url('Historiques/index/'.$this->uri->segment(3))?>','about');
  }


function startTime() {
   // getcountnombre();
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
   document.getElementById('times').innerHTML =
  h + ":" + m + ":" + s ;
  var t = setTimeout(startTime, 1000);
 // alert(t);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  
  return i;
}
</script>


<script type="text/javascript">
    $(document).ready(function () {
      
        startTime();
    });



</script>

</body>
</html>