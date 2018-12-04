<?php

function total( $pdo, $table ) {
    $sql = 'SELECT COUNT(*) FROM `' . $table . '`';
    $query = query($pdo, $sql);
    $row = $query->fetch();

    return $row[0];
}

/*function getJoke( $pdo, $id ) {
    $parameters = [':id' => $id];
    $sql = 'SELECT * FROM `joke` WHERE `id` = :id';
    $query = query($pdo, $sql, $parameters);

    return $query->fetch();
}*/

function findById( $pdo, $table, $primaryKey, $value ) {
    $sql = 'SELECT * FROM `' . $table . '` WHERE `' . $primaryKey . '` = :value';
    $parameters = ['value' => $value];
    $query = query($pdo, $sql, $parameters);

    return $query->fetch();
}

function query( $pdo, $sql, $parameters = []) {
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

function insert( $pdo, $table, $fields ) {
    $sql = 'INSERT INTO `' . $table . '` (';
    foreach($fields as $key => $value) {
        $sql .= '`' . $key . '`,';
    }
    $sql = rtrim($sql, ',');
    $sql .= ') VALUES (';

    foreach ($fields as $key => $value) {
        $sql .= ':' . $key . ',';
    }
    $sql = rtrim($sql, ',');
    $sql .= ')';

    $fields = processDates($fields);

    query($pdo, $sql, $fields);
}

    function update( $pdo, $table, $primaryKey, $fields ) {
        $sql = 'UPDATE `' . $table . '` SET ';
        foreach ($fields as $key => $value) {
            $sql .= '`' . $key . '` = :' . $key . ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ' WHERE `' . $primaryKey . '` = :primaryKey';

        $fields['primaryKey'] = $fields['id'];

        $fields = processDates($fields);

        query($pdo, $sql, $fields);
    }

function delete( $pdo, $table, $primaryKey, $id ) {
    $parameters = [':id' => $id];
    $sql = 'DELETE FROM `' . $table . '` WHERE `' . $primaryKey . '` = :id';
    query( $pdo, $sql, $parameters );
}

/*function allJokes( $pdo ) {
    $sql = 'SELECT `joke`.`id`, `joketext`, `jokedate`, `name`, `email`
    FROM `joke` INNER JOIN `author` ON `authorId` = `author`.`id`';
    $jokes = query($pdo, $sql);
    return $jokes->fetchAll();
}*/

function processDates( $fields ) {
    foreach ($fields as $key => $value) {
        if ($value instanceof DateTime) {
            $fields[$key] = $value->format('Y-m-d');
        }
    }
    return $fields;
}

function findAll( $pdo, $table ) {
    $sql = 'SELECT * FROM `' . $table . '`';
    $result = query($pdo, $sql);
    return $result->fetchAll();
}

function save( $pdo, $table, $primaryKey, $record ) {
    try {
        if ($record[$primaryKey] == '') {
            $record[$primaryKey] = null;
        }
        insert($pdo, $table, $record);
    } catch (PDOException $e) {
        update($pdo, $table, $primaryKey, $record);
    }
}