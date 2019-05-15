
<form method="post" action="<?php echo $router->pathFor("REGISTER_EX"); ?>">
  <h1>Registrazione</h1>
  <div class="form-row">
    <div class="form-group col-sm">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-sm">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-sm">
      <label for="inputPassword4">Riscrivi la Password</label>
      <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Crea un account</button>
  <p>Hai già un account? <a href="<?php echo $router->pathFor("LOGIN"); ?>">vai alla pagina di Login</a> </p>   
</form>
