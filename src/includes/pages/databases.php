<?php $defaultDatabaseName = "database_" . (count($databases["list"]) + 1); ?>
<style id="database-list-style">

</style>
<ul id="database-list" class="list">
  <form method="post">
    <input type="hidden" name="action" value="create_database" />
    <input type="hidden" name="name" value="<?php echo $defaultDatabaseName; ?>" />
    <button type="button" onclick="createDatabase(this.form)">create</button>  
  </form>
  <?php foreach ($databases["list"] as $name => $tables) : ?>
    <li class="">
      <form method="post">
        <input type="hidden" name="action" value="select_database" />
        <input type="hidden" name="name" value="<?php echo $name; ?>" />
        <input type="hidden" name="copy_to" value="<?php echo $defaultDatabaseName; ?>" />
        <button type="submit"><?php echo $name; ?></button>  
        <button type="button" onclick="dropDatabase('<?php echo $name; ?>', this.form)">drop</button>
        <button type="button" onclick="copyDatabase('<?php echo $name; ?>', this.form)">copy</button>
        <button type="button" onclick="importDatabase('<?php echo $name; ?>', this.form)">import</button>
        <button type="button" onclick="exportDatabase('<?php echo $name; ?>', this.form)">export</button>
        <button type="button" onclick="clearDatabase('<?php echo $name; ?>', this.form)">clear</button>
      </form>
    </li>
  <?php endforeach ?>
</ul>
<script id="database-list-script">
  function createDatabase(form) {
    showPromptDialog({
      message: "Please enter database name:",
      submit: "create",
      fields: [
        {
          element: "input",
          name: "database",
          placeholder: "Database name",
          value: form.elements["name"].value,
          required: true
        }
      ],
      callback: function(fields) {
        form.elements["name"].value = fields["database"].trim();
        form.submit();
      }
    });
  }

  function dropDatabase(database, form) {
    showConfirmDialog({
      message: "Are you sure you want to drop `" + database + "`?",
      submit: "delete",
      callback: function() {
        form.elements["action"].value = "drop_database";
        form.submit();
      }
    });
  }

  function copyDatabase(database, form) {
    showPromptDialog({
      message: "Please enter database name to copy to:",
      submit: "copy",
      fields: [
        {
          element: "input",
          name: "database",
          placeholder: "Database name",
          value: form.elements["copy_to"].value,
          required: true
        }
      ],
      callback: function(fields) {
        form.elements["action"].value = "copy_database";
        form.elements["copy_to"].value = fields["database"].trim();
        form.submit();
      }
    });
  }

  function importDatabase(database, form) {
    selectFile({
      multiple: true,
      accept: "csv",
      callback: function(files) {
        console.log(files);
      }
    });
  }

  function exportDatabase(database, form) {
    form.elements["action"].value = "export_database";
    form.target = "_blank";
    form.submit();
  }

  function clearDatabase(database, form) {
    showConfirmDialog({
      message: "Are you sure you want to clear all data from `" + database + "`?",
      submit: "clear",
      callback: function() {
        form.elements["action"].value = "clear_database";
        form.submit();
      }
    });
  }

  <?php if (isset($databases["error"])) : ?>
    showAlert({title: "Database error", message: "<?php echo $databases["error"]; ?>"});
  <?php endif ?>
</script>