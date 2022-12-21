<ul id="pagePath">
	<li><a href="index.php">Start</a></li>
	<li>Assignment list</li>
</ul>
<div class="float-clear"></div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Assignment was not removed.
	</div>
<?php } ?>

<table class="listTable">
	<tr>
		<th>Title</th>
		<th>Employees</th>
		<th>Created at</th>
		<th>Completed at</th>
	</tr>
	<?php
		foreach($data as $key => $val) {
            $employees = $employeesObj->getArchivedEmployeeListByAssignment($val['id']);

            $employeeString = "";

            foreach ($employees as $employee) {
                $employeeString .= $employee['first_name']." ".$employee['last_name']."<br>";
            }

			echo
				"<tr>"
					. "<td>{$val['title']}</td>"
					. "<td>{$employeeString}</td>"
					. "<td>{$val['created_at']}</td>"
					. "<td>{$val['completed_at']}</td>"
				. "</tr>";
		}
	?>
	
</table>

<div id="pagingLabel">
    Pages:
</div>
<ul id="paging">
    <?php foreach ($paging->data as $key => $value) {
        $activeClass = "";
        if ($value['isActive'] == 1) {
            $activeClass = " class='active'";
        }
        echo "<li{$activeClass}><a href='index.php?module={$module}&action=archived&page={$value['page']}' title=''>{$value['page']}</a></li>";
    } ?>
</ul>