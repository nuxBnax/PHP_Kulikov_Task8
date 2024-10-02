<?php

// setcookie("login", "admin", time() - 3600, '/');
// // setcookie("login", "admin", time() - 3600, '/');
// setcookie("хрень", "значение", time() - 3600, '/');
$time = strtotime("15-12-2041");
echo $time;
echo '<br>';
echo "<pre>";
print_r($_COOKIE['alex']);