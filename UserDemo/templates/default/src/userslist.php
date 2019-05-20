<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza una lista di utenti registrati al sito.
 *
 *  @status 1
 */
/* === DEVELOPER END */
?>
{{header}}

{{menu}}

<ul>
<?php foreach ($userslist as $user) { ?>
  <li><?php echo $user["name"]; ?></li>
<?php } ?>
</ul>

{{footer}}