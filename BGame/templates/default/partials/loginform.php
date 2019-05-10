
<form method="post" action="<?php echo $router->pathFor("LOGIN_EX"); ?>">
  <div class="formRow">
    <div class="formLabel">Username</div>
    <div class="formField"><input type="text" name="username" /></div>
  </div>
  <div class="formRow">
    <div class="formLabel">Password</div>
    <div class="formField"><input type="password" name="password" /></div>
  </div>
  <div class="formRow">
    <button type="submit">Entra</button>
  </div>
</form>