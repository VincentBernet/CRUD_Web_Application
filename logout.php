<!--  Bernet Vincent week 4's assignment of "Building web application" course from Coursera -->

<?php
session_start();
session_destroy();
//unset(session_id());
header("Location: index.php");
return;
?>
