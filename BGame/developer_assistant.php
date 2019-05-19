<?php
function get_file_infos($dir, $file) {
  if (is_file($dir . "/" . $file)) {
    $lines = file($dir . "/" . $file);
    $result = [];
    foreach ($lines as $l) {
      if (strpos($l, "@status")) {
        $result["status"] = trim(str_replace("@status", "", $l));
      }
      if (strpos($l, "@desc")) {
        $result["desc"] = trim(str_replace("@desc", "", $l));
      }
    }
    if (!empty($result)) {
      $result["filename"] = $file;
      return $result;
    }
  }
  return false;
}
$controllers = array_filter(array_map(function($item) {
  return get_file_infos(__DIR__ . '/src/Controller', $item);
}, scandir(__DIR__ . '/src/Controller')));

$templates = array_filter(array_map(function($item) {
  return get_file_infos(__DIR__ . '/templates/default/src', $item);
}, scandir(__DIR__ . '/templates/default/src')));
print_r($templates);die();

$models = array_filter(array_map(function($item) {
  return get_file_infos(__DIR__ . '/src/Model', $item);
}, scandir(__DIR__ . '/src/Model')));

$services = array_filter(array_map(function($item) {
  return get_file_infos(__DIR__ . '/src', $item);
}, scandir(__DIR__ . '/src')));
?>
<!doctype html>
<html>
<head>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>Actions</th>
        <th>Models</th>
        <th>Templates</th>
        <th>Services</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td valign="top">
          <ul>
          <?php foreach ($controllers as $c) { ?>
            <li><?php echo $c["filename"]; ?></li>
          <?php } ?>
          </ul>
        </td>
        <td valign="top">
          <ul>
          <?php foreach ($models as $m) { ?>
            <li><?php echo $m["filename"]; ?></li>
          <?php } ?>
          </ul>
        </td>
        <td valign="top">
          <ul>
          <?php foreach ($templates as $t) { ?>
            <li><?php echo $t["filename"]; ?></li>
          <?php } ?>
          </ul>
        </td>
        <td valign="top">
          <ul>
          <?php foreach ($services as $s) { ?>
            <li><?php echo $s["filename"]; ?></li>
          <?php } ?>
          </ul>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>