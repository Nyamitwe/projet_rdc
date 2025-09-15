<!-- <div class="jumbotron"> -->
<div class="row">
        <div class="col-md-3">
            <div class="card border-info mx-sm-1 p-3">
                <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-bars" aria-hidden="true"></span></div>
                <div class="text-info text-center mt-3"><h5>MES TACHES</h5></div>
                <div class="text-info text-center mt-2"><h3><?=sizeof($my_tasks)?></h3></div>
            </div>
        </div>

      
         <div class="col-md-3">
            <div class="card border-success mx-sm-1 p-3">
                <div class="card border-success shadow text-success p-3 my-card"><span class="fa fa-inbox" aria-hidden="true"></span></div>
                <div class="text-success text-center mt-3"><h5>TACHES TERMINEES</h5></div>
                <div class="text-success text-center mt-2"><h3><?=sizeof($complete)?></h3></div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card border-danger mx-sm-1 p-3">
                <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-clock-o" aria-hidden="true"></span></div>
                <div class="text-danger text-center mt-3"><h5>MESSAGES</h5></div>
                <div class="text-danger text-center mt-2"><h3>0</h3></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning mx-sm-1 p-3">
                <div class="card border-warning shadow text-warning p-3 my-card" ><span class="fa fa-comments" aria-hidden="true"></span></div>
                <div class="text-warning text-center mt-3"><h5>DOCS SIGNES</h5></div>
                <div class="text-warning text-center mt-2"><h3><?=sizeof($signed)?></h3></div>
            </div>
        </div>
     </div>
     <br>
<!-- </div> -->