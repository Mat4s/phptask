<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex">
    <title>Project management system</title>
    <link rel="stylesheet" type="text/css" href="style/main.css" media="screen"/>
    <script type="text/javascript" src="scripts/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="scripts/main.js"></script>
</head>
<body>
<div id="body">
    <div id="header">
        <h3 id="slogan"><a href="index.php">Project management system</a></h3>
    </div>
    <div id="content">
        <div id="topMenu">
            <li>
                <a href="index.php?module=assignment&action=list"
                   title="Assignments"<?php if ($module == 'assignment') {
                    echo 'class="active"';
                } ?>>Assignments</a>
            </li>
            <li>
                <a href="index.php?module=assignment&action=archived"
                   title="Archived"<?php if ($module == 'assignment') {
                    echo 'class="active"';
                } ?>>Archived</a>
            </li>
        </div>
        <div id="contentMain">
            <?php
            if (file_exists($actionFile)) {
                include $actionFile;
            } else {
                ?>
                <h1>Welcome!</h1>
                Go to:
                <p><a href="index.php?module=assignment&action=list"
                      title="Assignments">Assignments</a>
                </p>
                <p>
                    <a href="index.php?module=assignment&action=archived"
                       title="Archived">Archived</a>
                </p>
                <?php
            }
            ?>
            <div class="float-clear"></div>
        </div>
    </div>
</div>
</body>
</html>