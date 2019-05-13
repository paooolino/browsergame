{{header}}

<h1><?php echo $teaminfos["name"]; ?></h1>
<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Giocatore</th>
      <th>Ruolo</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($teaminfos["players"] as $player) { ?>
    <?php $counter = 0; ?>
    <tr>
      <td><?php echo $counter++; ?></td> 
      <td><a href="<?php echo $router->pathFor("PLAYER", ["id" => $row["id_player"]]); ?>"><?php echo $player["name"]; ?> <?php echo $player["surname"]; ?></a></td> 
      <td><?php echo $player["role"]; ?></td> 
    </tr>  
    <?php } ?>
  </tbody>
</table>

{{footer}}