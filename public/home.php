<?php

if (isset($_SESSION['email']))
{
    echo "<p>Hello: " . $_SESSION['email'] . "</p>";
    echo "<p>Today is: " . date("d/m/Y") . "</p>";
}