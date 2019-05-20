<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza il form di login.
 *
 *  @status 1 
 */
/* === DEVELOPER END */
?>
{{header}}

{{menu}}

<form action="<?php echo $router->pathFor("LOGIN_ACTION"); ?>" method="post">
  Inserisci la tua mail:
  <input type="email" name="email" />
  Password:
  <input type="password" name="password" />
  <button type="submit">Entra</button>
</form>

{{footer}}