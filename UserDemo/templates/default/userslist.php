<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza una lista di utenti registrati al sito.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
<?php require __DIR__ . '/partials/' . 'header.php'; ?>

<?php require __DIR__ . '/partials/' . 'menu.php'; ?>

<ul>
<?php foreach ($userslist as $user) { ?>
  <li><?php echo $user["name"]; ?></li>
<?php } ?>
</ul>

<?php require __DIR__ . '/partials/' . 'footer.php'; ?>