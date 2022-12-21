<ul id="pagePath">
    <li><a href="index.php">Start</a></li>
    <li><a href="index.php?module=<?php echo $module; ?>&action=list">Assignment list</a></li>
    <li>New assignment</li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
    <?php if ($formErrors != null) { ?>
        <div class="errorBox">
            Error in these fields:
            <?php
            echo $formErrors;
            ?>
        </div>
    <?php } ?>
    <form action="" method="post">
        <fieldset>
            <legend>Assignment info</legend>
            <p>
                <label class="field"
                       for="title">Title<?php echo in_array('title', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="name" name="title" class="textbox textbox-150"
                       value="<?php echo isset($data['title']) ? $data['title'] : ''; ?>">
                <?php if (key_exists('title', $maxLengths)) echo "<span class='max-len'>(to {$maxLengths['title']} char.)</span>"; ?>
            </p>
        </fieldset>
        <fieldset>
            <legend>Assignment members</legend>
            <div class="labelLeft wide<?php if (empty($data['employees']) || sizeof($data['employees']) == 0) echo ' hidden'; ?>">
                Employee
            </div>
            <div class="float-clear"></div>
            <?php

            if ($employeeObj->getAvailableEmployeeCount() == 0) {
                ?>
                <p>
                    No available employees
                    <select class="elementSelector" style="display: none;" name="employees[]">
                        <option></option>
                    </select>
                </p>
            <?php } else { ?>
                <?php
                if (empty($data['employees']) || sizeof($data['employees']) == 0) {
                    ?>
                    <div class="childRowContainer">

                        <div class="childRow hidden">
                            <select class="elementSelector" name="employees[]" disabled="disabled">
                                <?php
                                $tmp = $employeeObj->getEmployeeList();
                                foreach ($tmp as $key1 => $val1) {
                                    echo "<option value='{$val1['id']}'>{$val1['first_name']} {$val1['last_name']}</option>";
                                }
                                ?>
                            </select>
                            <a href="#" title="" class="removeChild">remove</a>
                        </div>
                        <div class="float-clear"></div>
                    </div>

                    <p id="newItemButtonContainer">
                        <a href="#" title="" class="addChild">Add</a>
                    </p>

                    <?php
                }
            }
            ?>

        </fieldset>
        <p class="required-note">* required fields</p>
        <p>
            <input type="submit" class="submit button" name="submit" value="Save">
        </p>

        <?php if (isset($data['id'])) { ?>
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>"/>
        <?php } ?>
    </form>
</div>