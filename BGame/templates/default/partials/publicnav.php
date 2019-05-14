<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link active" href="<?php echo $router->pathFor("HOME"); ?>">Home</a>
  </li>
  <?php foreach ($leagues as $league) { ?>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo $router->pathFor("LEAGUE", ["id" => $league["id"]]); ?>"><?php echo $league["name"]; ?></a>
  </li>
  <?php } ?>
</ul>
