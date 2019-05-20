<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza il form per il recuper password.
 *
 *  @status 1 
 */
/* === DEVELOPER END */
?>
{{header}}

{{menu}}

<form action="<?php echo $router->pathFor("LOST_PASSWORD_ACTION"); ?>" method="post">
  Inserisci la tua mail:
  <input type="email" name="email" />
  <button type="submit">Invia</button>
</form>

{{footer}}