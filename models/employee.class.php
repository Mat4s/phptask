<?php

class employee
{
    private $employee_table = '';

    public function __construct()
    {
        $this->employee_table = 'employees';
    }

    public function getEmployeeList()
    {
        $query = "  SELECT DISTINCT  `e`.`id`,
						   `e`.`first_name`,
         				   `e`.`last_name`
                    FROM `employees` `e`
                    LEFT JOIN `assignments_employees` `ae` ON `e`.`id` = `ae`.`employee_id`
                    LEFT JOIN `assignments` a ON `ae`.`assignment_id` = `a`.`id`
                    WHERE NOT EXISTS (
                      SELECT 1
                      FROM `assignments_employees` `ae2`
                      WHERE `ae2`.`employee_id` = `e`.`id`
                    )";
        return mysql::select($query);
    }

    public function getArchivedEmployeeListByAssignment($id)
    {
        $query = "  SELECT `e`.`id`,
						   `e`.`first_name`,
         				   `e`.`last_name`
                        FROM `employees` `e`
                        INNER JOIN `assignments_employees_archived` `ae` ON `e`.`id` = `ae`.`employee_id`
                        INNER JOIN `assignments` `a` ON `ae`.`assignment_id` = `a`.`id`
						WHERE `a`.`id`='{$id}' ";
        return mysql::select($query);
    }

    public function getEmployeeListByAssignment($id)
    {
        $query = "  SELECT `e`.`id`,
						   `e`.`first_name`,
         				   `e`.`last_name`
                        FROM `employees` `e`
                        INNER JOIN `assignments_employees` `ae` ON `e`.`id` = `ae`.`employee_id`
                        INNER JOIN `assignments` `a` ON `ae`.`assignment_id` = `a`.`id`
						WHERE `a`.`id`='{$id}' ";
        return mysql::select($query);
    }

    public function insertEmployee($data)
    {
        $query = "  INSERT INTO {$this->employee_table}
								(
									`first_name`,
									`last_name`
								)
								VALUES
								(
									'{$data['first_name']}',
									'{$data['last_name']}'
								)";
        mysql::query($query);
    }

    public function getAvailableEmployeeCount()
    {
        $query = "  SELECT DISTINCT COUNT('*') as `count`
                    FROM `employees` `e`
                    LEFT JOIN `assignments_employees` `ae` ON `e`.`id` = `ae`.`employee_id`
                    LEFT JOIN `assignments` a ON `ae`.`assignment_id` = `a`.`id`
                    WHERE NOT EXISTS (
                      SELECT 1
                      FROM `assignments_employees` `ae2`
                      WHERE `ae2`.`employee_id` = `e`.`id`
                    )";
        $data = mysql::select($query);

        return $data[0]['count'];
    }
}
