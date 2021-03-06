{{header}}

<h1><?php echo $leagueinfos["name"]; ?></h1>
<table>
  <thead>
    <tr>
      <th>Squadra</th>
      <th>Punti</th>
      <th>Giocate</th>
      <th>Vinte</th>
      <th>Pareggiate</th>
      <th>Perse</th>
      <th>Gol fatti</th>
      <th>Gol subiti</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($leagueinfos["standings"] as $row) { ?>
    <tr>
      <td><a href="<?php echo $router->pathFor("TEAM", ["id" => $row["id_team"]]); ?>"><?php echo $row["team"]; ?></a></td> 
      <td><?php echo $row["points"]; ?></td> 
      <td><?php echo $row["played"]; ?></td> 
      <td><?php echo $row["wins"]; ?></td> 
      <td><?php echo $row["draws"]; ?></td> 
      <td><?php echo $row["loss"]; ?></td> 
      <td><?php echo $row["goals_scored"]; ?></td> 
      <td><?php echo $row["goals_taken"]; ?></td>
    </tr>  
    <?php } ?>
  </tbody>
</table>

{{footer}}