<?php

require 'config/config.php';

function connectDB($name) : mysqli {
    global $gDatabaseOptions;

    $host = $gDatabaseOptions['hostname'];
    $user = $gDatabaseOptions['username'];
    $pass = $gDatabaseOptions['password'];

    $mysqli = new mysqli($host, $user, $pass, $name);

    if ($mysqli->connect_error) {
        return null;
    }

    return $mysqli;
}

function selectAllDB($dbName, $table, $cols = '*') {
    $db = connectDB($dbName);
    if (!$db)
        return [];

    $table = $db->real_escape_string($table);
    $cols = $db->real_escape_string($cols);

    $result = $db->query("select $cols from $table");
    $db->close();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function selectDB($dbName, $table, $selector, $value, $cols = '*') {
    $db = connectDB($dbName);
    if (!$db)
        return [];

    $table = $db->real_escape_string($table);
    $cols = $db->real_escape_string($cols);
    $value = $db->real_escape_string($value);
    $selector = $db->real_escape_string($selector);

    $result = $db->query("select $cols from $table where $selector = '$value'");
    $db->close();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function selectOneDB($dbName, $table, $selector, $value, $cols = '*') {
    $result = null;
    $db = connectDB($dbName);
    if (!$db)
        return $result;

    $table = $db->real_escape_string($table);
    $cols = $db->real_escape_string($cols);
    $value = $db->real_escape_string($value);
    $selector = $db->real_escape_string($selector);

    $query = $db->query("select $cols from $table where $selector = '$value'");
    $db->close();

    if ($query->num_rows > 0) {
        $result = $query->fetch_assoc();
    }

    return $result;
}

function deleteDB($dbName, $table, $selector, $value) {
    $result = false;
    $db = connectDB($dbName);
    if (!$db)
        return $result;

    $table = $db->real_escape_string($table);
    $value = $db->real_escape_string($value);
    $selector = $db->real_escape_string($selector);

    $queryString = "delete from $table where $selector = '$value'";
    $db->query($queryString);

    if ($db->affected_rows > 0) {
        $result = true;
    }

    $db->close();

    return $result;
}

function updateDB($dbName, $table, $fields, $selector) {
    $result = false;
    $db = connectDB($dbName);

    if (!$db)
        return $result;

    $count = count($fields);

    $field = $db->real_escape_string($fields[0][0]); 
    $value = $db->real_escape_string($fields[0][1]);

    $setValues = "set $field = '$value'";

    for ($i = 1; $i < $count; ++$i) {
        $field = $db->real_escape_string($fields[$i][0]);
        $value = $db->real_escape_string($fields[$i][1]);

        $setValues .= ", $field = '$value'";
    }

    $selectorName = $db->real_escape_string($selector[0]);
    $selectorValue = "'" . $db->real_escape_string($selector[1]) . "'";
    $table = $db->real_escape_string($table);

    $queryString = "update $table $setValues where $selectorName = $selectorValue";

    $db->query($queryString);

    if ($db->affected_rows > 0) {
        $result = true;
    }

    $db->close();

    return $result;
}

function insertIgnoreDB($dbName, $table, $fieldNames, $fieldValues) {
    $result = false;
    $db = connectDB($dbName);

    if (!$db)
        return $result;

    $count = count($fieldValues);

    $fieldValuesString = "'" . $db->real_escape_string(
        $fieldValues[0]
    ) . "'";

    for ($i = 1; $i < $count; ++$i) {
        $fieldValuesString .= ",'" . $db->real_escape_string(
            $fieldValues[$i]
        ) . "'";
    }

    $fieldNames = $db->real_escape_string(implode(",", $fieldNames));
    $queryString = "insert ignore into $table ($fieldNames) values ($fieldValuesString)";
    $db->query($queryString);

    if ($db->affected_rows > 0) {
        $result = true;
    }

    $db->close();

    return $result;
}

?>
