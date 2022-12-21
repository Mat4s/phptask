<?php
include 'config.php';

include 'utils/mysql.class.php';

$module = '';
if (isset($_GET['module'])) {
    $module = mysql::escape($_GET['module']);
}

$id = '';
if (isset($_GET['id'])) {
    $id = mysql::escape($_GET['id']);
}

$action = '';
if (isset($_GET['action'])) {
    $action = mysql::escape($_GET['action']);
}

$pageId = 1;
if (!empty($_GET['page'])) {
    $pageId = mysql::escape($_GET['page']);
}

$actionFile = "";

if (!empty($module) && !empty($action)) {
    $actionFile = "controllers/{$module}/{$module}_{$action}.php";
}

include 'views/main.php';
