<?php
define("IN_SYSTEM", true);
require "system/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css" type="text/css"/>
    <title><?=title?></title>
</head>
<body>
    <div id="container">
        <div class="main">
            <div class="nav">
                <ul>
                    <li class="logo"></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">How it works</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="content">
                <?php include_once(dir . "/components/email.form.php"); ?>
                
                <hr />

                <div class="social-icons">
                    <a href="#" class="icon facebook"></a>
                    <a href="#" class="icon instagram"></a>
                    <a href="#" class="icon twitter"></a>
                    <a href="#" class="icon youtube"></a>
                </div>
            </div>
        </div>
        <div class="bg"></div>
    </div>
</body>
</html>