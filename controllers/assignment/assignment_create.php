<?php

include 'models/assignment.class.php';
$assignmentObj = new assignment();

include 'models/employee.class.php';
$employeeObj = new employee();

$formErrors = null;
$data = [];

$required = ['title', 'employees'];

$maxLengths = [
    'title' => 255,
];

if (!empty($_POST['submit'])) {
    $validations = [
        'title' => 'anything',
        'employees' => 'anything'
    ];

    include 'utils/validator.class.php';
    $validator = new validator($validations, $required, $maxLengths);

    if ($validator->validate($_POST)) {

        $dataPrepared = $validator->preparePostFieldsForSQL();

        $dataPrepared['employees'] = array_unique($dataPrepared['employees'],SORT_NUMERIC);

        $assignmentObj->insertAssignment($dataPrepared);
        $assignmentId = $assignmentObj->getLastRecords(1, 'assignments')[0]['id'];

        $assignmentObj->insertAssignmentEmployees($dataPrepared, $assignmentId);

        header("Location: index.php?module={$module}&action=list");
        die();
    } else {
        $formErrors = $validator->getErrorHTML();
        $data = $_POST;
    }
}

include 'views/assignment/assignment_form.php';
