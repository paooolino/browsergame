<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc [Please add a description here for this sub-template]
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
<ul class="nav bg-light">
  <li class="nav-item">
    <a class="nav-link" href="<?php echo $router->pathFor("HOME"); ?>">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo $router->pathFor("LOGIN"); ?>">Login</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo $router->pathFor("REGISTER"); ?>">Register</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo $router->pathFor("USERSLIST"); ?>">Users list</a>
  </li>
</ul>
