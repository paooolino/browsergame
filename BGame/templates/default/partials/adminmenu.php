<div class="mt-3 mb-3">
  <?php foreach ($adminmenuitems as $section => $items) { ?>
    <ul class="list-group list-group-flush">
      <li class="list-group-item h5"><?php echo $section; ?></li>
      <?php foreach ($items as $item) { ?>
      <a class="list-group-item" href="<?php echo $item["url"]; ?>"><?php echo $item["label"]; ?></a>
      <?php } ?>
    </ul>
  <?php } ?>
</div>