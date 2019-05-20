<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza il form di login.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
<?php require __DIR__ . '/partials/' . 'header.php'; ?>

<?php require __DIR__ . '/partials/' . 'menu.php'; ?>

<form action="<?php echo $router->pathFor("LOGIN_ACTION"); ?>" method="post">
  Inserisci la tua mail:
  <input type="email" name="email" />
  Password:
  <input type="password" name="password" />
  <button type="submit">Entra</button>
</form>

<?php require __DIR__ . '/partials/' . 'footer.php'; ?>