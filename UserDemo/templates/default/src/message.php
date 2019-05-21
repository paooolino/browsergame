<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza un messaggio. Viene utilizzata come thankyou page dopo un'azione completata correttamente, oppure per notificare un errore.
 *
 *  @status 1
 */
/* === DEVELOPER END */
?>
{{header}}

{{menu}}

<h2><?php echo $message["title"]; ?></h2>
<p><?php echo $message["description"]; ?></p>

{{footer}}