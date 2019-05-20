<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza una call to action che porta alla pagina d'iscrizione.
 *
 *  @status 1
 */
/* === DEVELOPER END */
?>
{{header}}

{{menu}}

<a href="<?php echo $router->pathFor("REGISTER"); ?>">Registrati</a>
oppure
<a href="<?php echo $router->pathFor("LOGIN"); ?>">Entra nel sito</a>

{{footer}}