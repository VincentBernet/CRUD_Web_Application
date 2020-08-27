<!-- Bernet Vincent Crud Application, check the READ-ME -->

<!-- !!!! follow the read-me instruction to change those value to connect it to your own database (port=3306 in most case for windows user, and 8880 for mac users) -->
<!-- Specific file to link our code and querry to our database, gonna reuse it a lot in other page, by requiring it. -->


<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=assigmnent1', 'Admin', '1234');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>


