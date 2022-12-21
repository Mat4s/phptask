<?php

class validator
{
    public $regexes = array(
        'date' => "^[0-9]{4}[-/][0-9]{1,2}[-/][0-9]{1,2}\$",
        'datetime' => "^[0-9]{4}[-/][0-9]{1,2}[-/][0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}(:[0-9]{1,2})?\$",
        'positivenumber' => "^[0-9\.]+\$",
        'price' => "^([1-9][0-9]*|0)(\.[0-9]{2})?\$",
        'anything' => "^[\d\D]{1,}\$",
        'alfanum' => "^[0-9a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ ,.-_\\s\?\!]+\$",
        'not_empty' => "[a-z0-9A-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+",
        'words' => "^[A-Za-ząčęėįšųūžĄČĘĖĮŠŲŪŽ]+[A-Za-ząčęėįšųūžĄČĘĖĮŠŲŪŽ \\s]*\$",
        'phone' => "^[0-9]{9,14}\$"
    );

    private $validations, $mandatories, $lengths, $errors, $corrects, $fields;

    public function __construct($validations = array(), $mandatories = array(), $lengths = array())
    {
        $this->validations = $validations;
        $this->mandatories = $mandatories;
        $this->lengths = $lengths;
        $this->errors = array();
        $this->corrects = array();
    }

    public function validate($items)
    {
        $this->fields = $items;
        $havefailures = false;
        foreach ($items as $key => $val) {
            if (((!is_array($val) && strlen($val) == 0) || key_exists($key, $this->validations) === false) && !in_array($key, $this->mandatories)) {
                $this->corrects[] = $key;
                continue;
            }

            $result = false;
            if (is_array($val)) {
                $result = $this->validateArray($val, $key);
            } else {
                $result = $this->validateItem($val, $this->validations[$key]);
            }

            if ($result === true) {
                if (key_exists($key, $this->lengths)) {
                    if (strlen($val) > $this->lengths[$key]) {
                        $result = false;
                    }
                }
            }

            if ($result === false) {
                $havefailures = true;
                $this->addError($key, $this->validations[$key]);
            } else {
                $this->corrects[] = $key;
            }
        }

        return (!$havefailures);
    }

    private function validateArray($array, $key)
    {
        $havefailures = false;
        if ((key_exists($key, $this->validations) === false) && !in_array($key, $this->mandatories)) {
            $this->corrects[] = $key;
            return false;
        }

        foreach ($array as $item) {
            $result = false;
            if ($item == "" && !in_array($key, $this->mandatories)) {
                $result = true;
            } else {
                $result = $this->validateItem($item, $this->validations[$key]);
            }

            if ($result === false) {
                $havefailures = true;
                $this->addError($key, $this->validations[$key]);
            }
        }

        if ($havefailures == false) {
            $this->corrects[] = $key;
        }

        return !$havefailures;
    }

    public function getErrorHTML()
    {
        if (!empty($this->errors)) {
            $errors = array();
            foreach ($this->errors as $key => $val) {
                $errors[] = "<li>" . $key . "</li>";
            }
            $output = "<ul>" . implode('', $errors) . "</ul>";
        }

        return ($output);
    }

    private function addError($field, $type = 'string')
    {
        $this->errors[$field] = $type;
    }

    public function validateItem($var, $type)
    {
        if (array_key_exists($type, $this->regexes)) {
            $returnval = filter_var($var, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '!' . $this->regexes[$type] . '!i'))) !== false;
            return ($returnval);
        }
        $filter = false;
        switch ($type) {
            case 'email':
                $var = substr($var, 0, 254);
                $filter = FILTER_VALIDATE_EMAIL;
                break;
            case 'int':
                $filter = FILTER_VALIDATE_INT;
                break;
            case 'float':
                $filter = FILTER_VALIDATE_FLOAT;
                break;
            case 'boolean':
                $filter = FILTER_VALIDATE_BOOLEAN;
                break;
            case 'ip':
                $filter = FILTER_VALIDATE_IP;
                break;
            case 'url':
                $filter = FILTER_VALIDATE_URL;
                break;
        }
        return !($filter === false) && (filter_var($var, $filter) !== false ? true : false);
    }

    function preparePostFieldsForSQL()
    {
        $data = array();

        foreach ($this->fields as $key => $val) {
            $tmp = null;
            if (!is_array($val)) {
                $tmp = mysql::escape($val);
            } else {
                foreach ($val as $key2 => $val2) {
                    $tmp[] = mysql::escape($val2);
                }
            }

            if (!in_array($key, $this->mandatories) && ($tmp == '' || $tmp == array())) {
                $data[$key] = '';
            } else {
                if (!is_array($tmp)) {
                    $data[$key] = $tmp;
                } else {
                    $data[$key] = $tmp;
                }

            }
        }

        return $data;
    }

}

?>