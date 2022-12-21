<?php

include 'models/employee.class.php';
$employeeObj = new employee();

$formErrors = null;
$data = array();

$required = ['first_name', 'last_name'];

$maxLengths = [
    'first_name' => 100,
    'last_name' => 100,
];

if(!empty($_POST['submit'])) {
    $validations = [
        'first_name' => 'anything',
        'last_name' => 'anything',
    ];

    include 'utils/validator.class.php';
    $validator = new validator($validations, $required, $maxLengths);

    if($validator->validate($_POST)) {
        $dataPrepared = $validator->preparePostFieldsForSQL();

        $employeeObj->insertEmployee($dataPrepared);

        header("Location: index.php?module=assignment&action=list");
        die();
    } else {

        $formErrors = $validator->getErrorHTML();

        $data = $_POST;
    }
}

include 'views/employee/employee_form.php';

?>