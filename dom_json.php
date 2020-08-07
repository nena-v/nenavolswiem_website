<!DOCTYPE html>

<html lang="fr">

  <head>
    
    <meta charset="utf-8"/>
    <title>DOM to JSON</title>
    
  </head>

  <body>

      <?php
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

      if(isset($_POST['dom_input'])){
          echo '<pre>' . $_POST['dom_input'] . '</pre>';
      } 
      ?>
    
  </body>

</html>

      
