<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza il form per il recuper password.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
<?php require __DIR__ . '/partials/' . 'header.php'; ?>

<?php require __DIR__ . '/partials/' . 'menu.php'; ?>

<form action="<?php echo $router->pathFor("LOST_PASSWORD_ACTION"); ?>" method="post">
  Inserisci la tua mail:
  <input type="email" name="email" />
  <button type="submit">Invia</button>
</form>

<?php require __DIR__ . '/partials/' . 'footer.php'; ?>