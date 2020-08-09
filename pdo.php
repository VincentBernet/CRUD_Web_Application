<!-- Bernet Vincent week 2's assignment of "JavaScript, jQuery, and JSON" course from Coursera -->
<!-- Added some jQuerry to show and insert or not new Position (with a new table eponyme) -->

<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=assigmnent1', 'Admin', '1234');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
