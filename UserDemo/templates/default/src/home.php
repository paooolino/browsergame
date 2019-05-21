<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza una call to action che porta alla pagina d'iscrizione.
 *
 *  @status 2
 */
/* === DEVELOPER END */
?>
{{header}}

{{menu}}

<div class="contaner-fluid bg-light">
  <div class="container py-5">
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="<?php echo $router->pathFor("REGISTER"); ?>" class="btn btn-primary">Registrati ora</a>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Hai già un account?</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="<?php echo $router->pathFor("LOGIN"); ?>" class="btn btn-primary">Entra nel sito</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{footer}}