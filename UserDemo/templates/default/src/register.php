<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza il form di registrazione.
 *
 *  @status 1
 */
/* === DEVELOPER END */
?>
{{header}}

{{menu}}

<form action="<?php echo $router->pathFor("REGISTER_ACTION"); ?>" method="post">
  Inserisci la tua mail:
  <input type="email" name="email" />
  Scegli una nuova password:
  <input type="password" name="password" />
  Riscrivi la password:
  <input type="password" name="password_check" />
  <button type="submit">Entra</button>
</form>

{{footer}}