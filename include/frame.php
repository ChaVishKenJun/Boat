<!doctype html>
<html lang="en">
  <head>
    <!-- Meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/frame.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="image/favicon.ico" type="image/x-icon"/>

    <!-- Title -->
    <title>Boat <?php if (!empty($GLOBALS['title'])) { echo ' - ' . $GLOBALS['title']; } ?></title>
  </head>
  <body class="d-flex flex-column h-100">
    <?php include (PATH_INC . "navigation.php"); ?>

    <?php  include $GLOBALS['leftbox']; ?>
    
    <div class="container-fluid">
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php  include $GLOBALS['content']; ?>
      </main>
      
      <?php  include $GLOBALS['footer']; ?>
    </div>
    
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script href="javascript/boat.js"></script>
  </body>
</html>