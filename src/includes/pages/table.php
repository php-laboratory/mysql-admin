<style id="table-list-style">

</style>
<form method="post">
  <input type="hidden" name="action" value="select_database" />
  <button type="submit"><?php echo $databases["selected"]; ?></button>
</button>
</form>
<ul id="table-list" class="list">
  <button type="button" onclick="showCreateTableDialog()">create</button>  
  <?php foreach ($tables["list"] as $name => $columns) : ?>
    <li class="">
      <form method="post">
        <input type="hidden" name="action" value="select_table" />
        <input type="hidden" name="name" value="<?php echo $name; ?>" />
        <button type="submit"><?php echo $name; ?></button>  
      </form>
    </li>
  <?php endforeach ?>
</ul>
<script id="table-list-script">
  <?php if (isset($tables["error"])) : ?>
    showAlert({title: "Table error", message: "<?php echo $tables["error"]; ?>"});
  <?php endif ?>
</script>