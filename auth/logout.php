<?php
session_start();
session_unset();     
session_destroy(); 
header("Location: /sistem-perpus/index.php?status=logout_sukses");
exit();
?>