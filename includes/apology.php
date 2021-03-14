<!DOCTYPE html>
<html>

  <head>

    <meta charset="utf-8">

    <link href="css/board.css" rel="stylesheet" type="text/css">

    <title>Message Board</title>

  </head>

  <body>

<?php
  require_once("includes/top-banner.php");
?>

    <div id="all" class="center">

      <div id="middle">
	<h4>Sorry: <?php print("$message") ?></h4>
      </div>

      <div id="bottom">
	<a href="javascript:history.go(-1);">Back</a>
      </div>

    </div>

  </body>

</html>
