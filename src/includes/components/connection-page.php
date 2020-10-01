<style id="connection-style">

</style>
<form id="connection-form" method="post">
  <input type="hidden" name="action" value="add_connection" />
  <input type="text" name="name" value="<?php echo "connection_" . (count($connections["list"]) + 1); ?>"/>  
  <input type="text" name="host" />  
  <input type="text" name="username" />  
  <input type="password" name="password" />
  <button type="submit">connect</button>
</form>