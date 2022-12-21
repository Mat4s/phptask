<?php
include 'models/assignment.class.php';
$assignmentObj = new assignment();

if(!empty($id)) {

    $assignmentObj->completeAssignment($id);

    header("Location: index.php?module={$module}&action=list");
    die();
}
