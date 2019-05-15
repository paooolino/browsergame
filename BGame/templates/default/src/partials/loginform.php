
<form method="post" action="<?php echo $router->pathFor("LOGIN_EX"); ?>">
  <h1>Login</h1>
  <div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" placeholder="Scrivi il tuo nome utente">
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" placeholder="Scrivi la tua password">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Ricordami</label>
  </div>
  <button type="submit" class="btn btn-primary">Entra</button>
</form>