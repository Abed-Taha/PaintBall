<?php
function block($route)
{
    if (basename($_SERVER['REQUEST_URI']) == $route)
        die('<h1 style="text-align:center">Access Denied  <br /> you don&apos;t has permission to access this page <br /> <a href="/">go back </a> </h1>
    ');
}
?>