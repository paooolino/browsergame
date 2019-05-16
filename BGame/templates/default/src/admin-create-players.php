{{header}}

<div class="container-fluid bg-dark">
  <div class="row">
    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
      {{adminmenu}}
    </div>
    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
      <div class="text-light mt-3 mb-3">
        <div class="p-3">
          <p>Ci sono <b><?php echo $counts["players"]; ?></b> giocatori e <b><?php echo $counts["teams"]; ?></b> squadre nel database.</p>
          <form action="<?php $router->pathFor("ADMIN_CREATE_PLAYERS_EX"); ?>" method="post" class="form-inline">
            <div class="form-group">
              <label>Quanti giocatori vuoi creare?</label>
              <input name="n" type="number" value="1" class="form-control mx-3" min="1" placeholder="Inserisci un numero maggiore di zero">
            </div>
            <button type="submit" class="btn btn-primary">Crea</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  
{{footer}}