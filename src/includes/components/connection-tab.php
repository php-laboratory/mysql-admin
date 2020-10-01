<style id="connection-tab-style">
  #connection-tab {
    display: flex;
    width: 100%;
    padding: 0px;
    margin: 0px;
    background-color: #f1f3f4;
    overflow-x: auto;
  }

  #connection-tab form {
    height: 30px;
    flex: none;
    border-top: 2px solid transparent;
    box-sizing: border-box;
    padding: 0px 5px;
  }

  #connection-tab form.selected {
    border-top-color: #1e87f0;
    background-color: #ffffff;
  }

  #connection-tab form {
    display: inline-block;
    vertical-align: top;
  }

  #connection-tab form button {
    border: none;
    background: none;
    color: black;
    font-size: 24px;
    font-weight: lighter;
    line-height: 25px;
    vertical-align: top;
  }

  #connection-tab form button:enabled {
    cursor: pointer;
  }

  #connection-tab form button.name {
    height: 100%;
    font-size: 16px;
  }
</style>
<div id="connection-tab">
  <?php $hasSelected = isset($connections["selected"]); ?>
  <?php foreach ($connections["list"] as $name => $connection) : ?>
    <?php $selected = $connections["selected"] === $name; ?>
    <form method="post" class="<?php echo $selected ? "selected" : "" ?>">
      <input type="hidden" name="name" value ="<?php echo $name; ?>" />
      <button type="submit" name="action" value="select_connection" <?php echo $selected ? "disabled" : "" ?> class="name"><?php echo $name; ?></button>
      <button type="submit" name="action" value="remove_connection">&times;</button>  
    </form>
  <?php endforeach ?>
  <form method="post" class="<?php echo !$hasSelected ? "selected" : "" ?>">
    <input type="hidden" name="name" value="" />
    <button type="submit" name="action" value="select_connection" <?php echo !$hasSelected ? "disabled" : "" ?>>+</button>  
  </form>
</div>