<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza un form che consente all'utente di cambiare password.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
<?php require __DIR__ . '/partials/' . 'header.php'; ?>

<?php require __DIR__ . '/partials/' . 'menu.php'; ?>

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

<?php require __DIR__ . '/partials/' . 'footer.php'; ?>