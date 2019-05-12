<ul>
  <?php foreach ($leagueslist as $league) { ?>
  <li><a href="<?php echo $router->pathFor("LEAGUE", ["url" => $league["url"]]); ?>"><?php echo $league["name"]; ?></a></li>
  <?php } ?>
</ul>