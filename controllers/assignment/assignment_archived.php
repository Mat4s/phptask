<?php

include 'models/assignment.class.php';
include 'models/employee.class.php';

$assignmentsObj = new assignment();
$employeesObj = new employee();

$elementCount = $assignmentsObj->getAssignmentListCount();

include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

$paging->process($elementCount, $pageId);

$data = $assignmentsObj->getArchivedAssignmentList($paging->size, $paging->first);

include 'views/assignment/assignment_archived.php';
