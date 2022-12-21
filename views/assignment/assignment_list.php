<ul id="pagePath">
    <li><a href="index.php">Start</a></li>
    <li>Assignment list</li>
</ul>
<div id="actions">
    <a href='index.php?module=<?php echo $module; ?>&action=create'>New assignment</a>
    <a href='index.php?module=employee&action=create'>New employee</a>
</div>
<div class="float-clear"></div>

<?php if (isset($_GET['remove_error'])) { ?>
    <div class="errorBox">
        Assignment was not removed.
    </div>
<?php } ?>

<table class="listTable">
    <tr>
        <th>Title</th>
        <th>Employees</th>
        <th>Created at</th>
        <th>Actions</th>
    </tr>
    <?php
    foreach ($data as $key => $val) {
        $employees = $employeesObj->getEmployeeListByAssignment($val['id']);

        $employeeString = "";

        foreach ($employees as $employee) {
            $employeeString .= $employee['first_name'] . " " . $employee['last_name'] . "<br>";
        }
        echo
            "<tr>"
            . "<td>{$val['title']}</td>"
            . "<td>{$employeeString}</td>"
            . "<td>{$val['created_at']}</td>"
            . "<td>"
            . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id']}\", \"complete\" ); return false;' title=''>complete</a>&nbsp;"
            . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id']}\", \"delete\"); return false;' title=''>delete</a>"
            . "</td>"
            . "</tr>";
    }
    ?>

</table>
