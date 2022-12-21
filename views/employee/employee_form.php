<ul id="pagePath">
    <li><a href="index.php">Start</a></li>
    <li><a href="index.php?module=<?php echo $module; ?>&action=list">Employee list</a></li>
    <li>New employee</li>
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
            <legend>Employee info</legend>
            <p>
                <label class="field" for="first_name">First
                    name<?php echo in_array('first_name', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="name" name="first_name" class="textbox textbox-150"
                       value="<?php echo isset($data['first_name']) ? $data['first_name'] : ''; ?>">
                <?php if (key_exists('first_name', $maxLengths)) echo "<span class='max-len'>(to {$maxLengths['first_name']} chars.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="last_name">Last
                    name<?php echo in_array('last_name', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="name" name="last_name" class="textbox textbox-150"
                       value="<?php echo isset($data['last_name']) ? $data['last_name'] : ''; ?>">
                <?php if (key_exists('last_name', $maxLengths)) echo "<span class='max-len'>(to {$maxLengths['last_name']} chars.)</span>"; ?>
            </p>
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