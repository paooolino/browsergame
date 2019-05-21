<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza un messaggio. Viene utilizzata come thankyou page dopo un'azione completata correttamente, oppure per notificare un errore.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
<?php require __DIR__ . '/partials/' . 'header.php'; ?>

<?php require __DIR__ . '/partials/' . 'menu.php'; ?>

<h2><?php echo $message["title"]; ?></h2>
<p><?php echo $message["description"]; ?></p>

<?php require __DIR__ . '/partials/' . 'footer.php'; ?>