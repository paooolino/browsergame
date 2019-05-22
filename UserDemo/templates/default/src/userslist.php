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

<div class="contaner-fluid bg-light">
  <div class="container py-5">
    <div class="row">
      <div class="col-4 offset-4">
        
        <?php foreach ($userslist as $user) { ?>
          <li><?php echo $user["username"]; ?></li>
        <?php } ?>
        </ul>
      
      </div>
    </div>
  </div>
</div>

{{footer}}