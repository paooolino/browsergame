<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza un form che consente all'utente di cambiare password.
 *
 *  @status 1 
 */
/* === DEVELOPER END */
?>
{{header}}

{{menu}}

<form action="<?php echo $router->pathFor("CHANGE_PASSWORD_ACTION"); ?>" method="post">
  Inserisci la vecchia password:
  <input type="password" name="old_password" />
  <hr>
  Inserisci la nuova password:
  <input type="password" name="password" />
  Riscrivi la nuova password:
  <input type="password" name="password_check" />
  <button type="submit">Invia</button>
</form>

{{footer}}