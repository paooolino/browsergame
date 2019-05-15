  
  <footer class="page-footer font-small blue pt-4">
    <div class="container-fluid">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <h5>Esplora le serie</h5>
            <ul class="list-unstyled">
              <li>
                <a href="<?php echo $router->pathFor("HOME"); ?>">Home</a>
              </li>
              <?php foreach ($leagues as $league) { ?>
              <li>
                <a href="<?php echo $router->pathFor("LEAGUE", ["id" => $league["id"]]); ?>"><?php echo $league["name"]; ?></a>
              </li>
              <?php } ?>
            </ul>
          </div>
          <div class="col-sm">
            <h5>Interagisci</h5>
            <ul class="list-unstyled">
              <li>
                <a href="<?php echo $router->pathFor("REGISTER"); ?>">Registrati</a>
              </li>
              <li>
                <a href="<?php echo $router->pathFor("LOGIN"); ?>">Login</a>
              </li>
            </ul>
          </div>
          <div class="col-sm">
            Copyright (c) <?php echo date("Y"); ?>
          </div>
        </div>
      </div>
    </div>
  </footer>
  
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>