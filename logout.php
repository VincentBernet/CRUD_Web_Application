<!-- Bernet Vincent Crud Application -->
<!-- Added some jQuerry to show and insert or not new Position (with a new table eponymic) -->

<!-- Simple page where we log-out of our session by destroying it, after that we redirect to index.php -->
<?php
session_start();
session_destroy();
// unset(session_id()); Was another solution to logout, but i prefer the radical one
header("Location: index.php");
return;
?>
