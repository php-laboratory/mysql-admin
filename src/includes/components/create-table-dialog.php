<style id="create-table-dialog-style">
  #create-table-template {
    display: none;
  }

  .create-table-form .create-table-message {
    padding: 20px 0px;
  }

  .create-table-form .column:first-child input[type="button"] {
    visibility: hidden;
  }

  .create-table-form .submit-button {
    float: right;
  }
</style>
<div id="create-table-template">
  <form method="post" class="create-table-form">
    <div class="create-table-message"></div>
    <input type="text" name="name" value="" placeholder="table name" required />
    <input type="hidden" name="action" value="create_table" />
    <button class="add-column-button" type="button">add column</button>
    <div class="column-container">
    </div>
    <button class="cancel-button" type="button"></button>
    <button class="submit-button" type="submit"></button>
  </form>
  <div class="column-template">
    <div class="column">
      <input type="text" name="column_name[]" value="" placeholder="column name" required />
      <input type="text" name="column_definition[]" value="" placeholder="definition" required />
      <button type="button" onclick="this.parentNode.remove()">&times;</button>
    </div>
  </div>
</div>
<script id="create-table-dialog-script">
  var createTableTemplate = document.querySelector("#create-table-template");
  var createTableForm = createTableTemplate.querySelector(".create-table-form");
  var columnTemplate = createTableTemplate.querySelector(".column-template .column");

  function showCreateTableDialog({
    message = "Please enter table schema:",
    cancel = "cancel",
    submit = "create",
    callback = function(form) { form.submit(); },
    onCancel = function () {}
  } = {}) {
    var content = createTableForm.cloneNode(true);
    var addColumnButton = content.querySelector(".add-column-button");
    var columnContainer = content.querySelector(".column-container");

    addColumnButton.onclick = function () {
      columnContainer.appendChild(columnTemplate.cloneNode(true));
    };
    
    content.querySelector(".create-table-message").innerHTML = message;
    content.querySelector(".cancel-button").innerHTML = cancel;
    content.querySelector(".submit-button").innerHTML = submit;
    columnContainer.appendChild(columnTemplate.cloneNode(true));

    var hideCreateTableDialog = showDialog({ content, onCancel });

    content.querySelector(".cancel-button").addEventListener("click", hideCreateTableDialog);
  }
</script>
