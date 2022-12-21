<?php

class assignment
{
    private $assignment_table = '';
    private $pivot_table = '';

    public function __construct()
    {
        $this->assignment_table = 'assignments';
        $this->employee_table = 'employees';
        $this->pivot_table = 'assignments_employees';
    }

    public function getAssignmentList($limit = null, $offset = null)
    {
        $limitOffsetString = "";
        if (isset($limit)) {
            $limitOffsetString .= " LIMIT {$limit}";

            if (isset($offset)) {
                $limitOffsetString .= " OFFSET {$offset}";
            }
        }

        $query = "  SELECT *
					FROM `{$this->assignment_table}`
					WHERE `is_complete`='0'"
                    .$limitOffsetString;

        return mysql::select($query);
    }

    public function getArchivedAssignmentList($limit = null, $offset = null)
    {
        $limitOffsetString = "";
        if (isset($limit)) {
            $limitOffsetString .= " LIMIT {$limit}";

            if (isset($offset)) {
                $limitOffsetString .= " OFFSET {$offset}";
            }
        }

        $query = "  SELECT *
					FROM `{$this->assignment_table}`
					WHERE `is_complete`='1'"
                    .$limitOffsetString
                    ;
        return mysql::select($query);
    }


    public function getAssignmentListCount()
    {
        $query = "  SELECT COUNT(`id`) as `count`
					FROM {$this->assignment_table}";
        $data = mysql::select($query);

        return $data[0]['count'];
    }

    public function insertAssignment($data)
    {
        $query = "INSERT INTO {$this->assignment_table}
								(`title`)
								VALUES
								('{$data['title']}')";
        mysql::query($query);
    }

    public function deleteAssignmentEmployees($id)
    {
        $query = "  DELETE FROM `{$this->pivot_table}`
					WHERE `assignment_id`={$id}";
        mysql::query($query);
    }

    public function deleteAssignment($id)
    {
        $this->deleteAssignmentEmployees($id);

        $query = "  DELETE FROM `{$this->assignment_table}`
					WHERE `id`={$id}";
        mysql::query($query);
    }

    public function insertAssignmentEmployees($data, $assignmentId)
    {
        $this->deleteAssignmentEmployees($assignmentId);
        if (isset($data['employees']) && count($data['employees']) > 0) {
            foreach($data['employees'] as $key=>$val) {
                $query = "  INSERT INTO {$this->pivot_table}
										(
											`employee_id`,
											`assignment_id`
										)
										VALUES
										(
											'{$val}',
											'{$assignmentId}'
										)";
                mysql::query($query);
            }
        }
    }

    public function insertArchivedAssignmentEmployees($data, $assignmentId)
    {
        $this->deleteAssignmentEmployees($assignmentId);
        if (isset($data) && count($data) > 0) {
            foreach($data as $key=> $val) {
                $query = "  INSERT INTO `assignments_employees_archived`
										(
											`employee_id`,
											`assignment_id`
										)
										VALUES
										(
											'{$val}',
											'{$assignmentId}'
										)";
                mysql::query($query);
            }
        }
    }

    public function getLastRecords($limit, $table)
    {
        $query = " SELECT * 
				   FROM `{$table}`
				   ORDER BY `id` DESC LIMIT {$limit}";

        return mysql::select($query);
    }

    public function getEmployeeListByAssignment($id)
    {
        $query = "  SELECT `e`.`id`
                        FROM `employees` `e`
                        INNER JOIN `assignments_employees` `ae` ON `e`.`id` = `ae`.`employee_id`
                        INNER JOIN `assignments` `a` ON `ae`.`assignment_id` = `a`.`id`
						WHERE `a`.`id`='{$id}' ";
        return mysql::select($query);
    }

    public function completeAssignment($id)
    {
        $data = $this->getEmployeeListByAssignment($id);

        $ids= [];

        foreach ($data as $d){
            $ids[] = $d['id'];
        }

        print_r($ids);
        $this->insertArchivedAssignmentEmployees($ids, $id);

        $query = "  UPDATE `{$this->assignment_table}`
					SET    `is_complete`='1',
						   `completed_at`=NOW()
					WHERE `id`='{$id}'";

        return mysql::query($query);
    }
}