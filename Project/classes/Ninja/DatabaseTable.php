<?php

namespace Ninja;

class DatabaseTable
{

    private $pdo;
    private $table;
    private $primaryKey;
    private $className;
    private $constructorArgs;

    public function __construct(\PDO $pdo, string $table, string $primaryKey,
        string $className = '\stdClass', array $constructorArgs = []) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->className = $className;
        $this->constructorArgs = $constructorArgs;
    }

    private function query($sql, $parameters = [])
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }

    public function total($field = null, $value = null)
    {
        $sql = 'SELECT COUNT(*) FROM `' . $this->table . '`';
        $parameters = [];

        if (!empty($field)) {
            $sql .= ' WHERE `' . $field . '` = :value';
            $parameters = ['value' => $value];
        }
        $query = $this->query($sql, $parameters);
        $row = $query->fetch();

        return $row[0];
    }

    public function findById($value)
    {
        $sql = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :value';
        $parameters = ['value' => $value];
        $query = $this->query($sql, $parameters);

        return $query->fetchObject($this->className, $this->constructorArgs);
    }

    public function find($column, $value, $orderBy = null, $limit = null, $offSet = null)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

        $parameters = [
            'value' => $value
        ];

        if ($orderBy != null) {
            $query .= ' ORDER BY ' . $orderBy;
        }

        if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }

        if ($offSet != null) {
            $query .= ' OFFSET ' . $offSet;
        }

        $query = $this->query($query, $parameters);

        return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }

    private function insert($fields)
    {
        $sql = 'INSERT INTO `' . $this->table . '` (';
        foreach ($fields as $key => $value) {
            $sql .= '`' . $key . '`,';
        }
        $sql = rtrim($sql, ',');
        $sql .= ') VALUES (';

        foreach ($fields as $key => $value) {
            $sql .= ':' . $key . ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ')';

        $fields = $this->processDates($fields);

        $this->query($sql, $fields);

        return $this->pdo->lastInsertId();
    }

    private function update($fields)
    {
        $sql = 'UPDATE `' . $this->table . '` SET ';
        foreach ($fields as $key => $value) {
            $sql .= '`' . $key . '` = :' . $key . ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';

        $fields['primaryKey'] = $fields['id'];

        $fields = $this->processDates($fields);

        $this->query($sql, $fields);
    }

    public function delete($id)
    {
        $parameters = [':id' => $id];
        $sql = 'DELETE FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :id';
        $this->query($sql, $parameters);
    }

    public function findAll($orderBy = null, $limit = null, $offSet = null)
    {
        $sql = 'SELECT * FROM `' . $this->table . '`';

        if ($orderBy != null) {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        if ($limit != null) {
            $sql .= ' LIMIT ' . $limit;
        }

        if ($offSet != null) {
            $sql .= ' OFFSET ' . $offSet;
        }

        $result = $this->query($sql);
        return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }

    private function processDates($fields)
    {
        foreach ($fields as $key => $value) {
            if ($value instanceof \DateTime) {
                $fields[$key] = $value->format('Y-m-d');
            }
        }
        return $fields;
    }

    public function save($record)
    {
        $entity = new $this->className(...$this->constructorArgs);

        try {
            if ($record[$this->primaryKey] == '') {
                $record[$this->primaryKey] = null;
            }

            $insertId = $this->insert($record);
            $entity->{$this->primaryKey} = $insertId;

        } catch (\PDOException $e) {
            $this->update($record);
        }

        foreach ($record as $key => $value) {
            if (!empty($value)) {
                $entity->$key = $value;
            }
        }
        return $entity;
    }

    public function deleteWhere($column, $value)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' = :value';
        $parameters = [
            'value' => $value
        ];
        $query = $this->query($sql, $parameters);
    }
}