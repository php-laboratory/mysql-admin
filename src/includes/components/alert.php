<style id="alert-style">
  #alert-template {
    display: none;
  }
  
  #alert-container {
    position: fixed;
    bottom: 0px;
    width: 100%;
  }

  .alert {
    position: relative;
    margin: 10px;
    padding: 5px;
  }

  .alert.red {
    background-color: #ff4444;
    color: #660000;
  }

  .alert.yellow {
    background-color: #ffc107;
    color: #8e6c04;
  }

  .alert.green {
    background-color: #4caf50;
    color: #006600;
  }

  .alert .close-button {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 20px;
    height: 20px;
    font-size: 24px;
    text-align: center;
    line-height: 20px;
    cursor: pointer;
  }

  .alert .title {
    margin: 10px;
    font-size: 16px;
  }

  .alert .message {
    margin: 10px;
    font-size: 12px;
  }
</style>
<div id="alert-template">
  <div class="alert">
    <div class="close-button">&times;</div>
    <h3 class="title"></h3>
    <p class="message"></p>
  </div>
</div>
<div id="alert-container">
</div>
<script id="alert-script">
  var alertTemplate = document.querySelector("#alert-template");
  var alertContainer = document.querySelector("#alert-container");
  var alertPanel = alertTemplate.querySelector(".alert");

  function showAlert({
    title = "",
    message = "",
    color = "red"

  }) {
    var content = alertPanel.cloneNode(true);
    var closeButton = content.querySelector(".close-button");

    content.querySelector(".title").innerHTML = title;
    content.querySelector(".message").innerHTML = message;

    toggleClass(content, color, true);

    var closeAlert = function (event) {
      if (!event || event.target === this) {
        toggleClass(content, "show", false);
        content.remove();
      }
    }

    closeButton.addEventListener("click", closeAlert);

    alertContainer.append(content);
  }
</script>
