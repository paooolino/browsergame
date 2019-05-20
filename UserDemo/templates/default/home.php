<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza una call to action che porta alla pagina d'iscrizione.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
<?php require __DIR__ . '/partials/' . 'header.php'; ?>

<?php require __DIR__ . '/partials/' . 'menu.php'; ?>

<a href="<?php echo $router->pathFor("REGISTER"); ?>">Registrati</a>
oppure
<a href="<?php echo $router->pathFor("LOGIN"); ?>">Entra nel sito</a>

<?php require __DIR__ . '/partials/' . 'footer.php'; ?>