<?php
session_start();
session_unset();     
session_destroy(); 
header("Location: login.php?status=logout_sukses");
exit();
?>