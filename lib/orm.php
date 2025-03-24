<?php

class ORM
{
    public PDO $pdo;
    public function __construct()
    {
        $connectionString = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
        $this->pdo = new PDO($connectionString, DB_USER, DB_PASS);
    }

    public function __destruct()
    {
        unset($this->pdo);
    }

    public function insertInto(string $table_name, array $params)
    {
        $template = "insert into $table_name"; //TODO: fix this
        $columns = array_keys($params);
        $template = $template . " " . "(" . join(", ", $columns) . ")";
        $template = $template . " " . "values" . " " . "(" . join(", ", array_map(fn($col) => ":$col", $columns)) . ")";
        $stmt = $this->pdo->prepare($template);
        $stmt->execute($params);
    }

    public function selectManyFrom(string $table_name, array $columns, array $where = [])
    {
        $params = [];
        $template = "select" . " " . join(", ", $columns) . " " .  "from $table_name"; //TODO: fix this
        if (count($where)) {
            $readyConds = [];
            foreach ($where as $condition) {
                if (!($condition instanceof Where)) throw new Exception("invalid conition");
                $readyConds[] = $condition->translate();

                $params = array_merge($params, $condition->getParams());
            }
            $template = $template . " " . "where" . " " . join(" and ", $readyConds);
        }
        $stmt = $this->pdo->prepare($template);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function selectOneFrom(string $table_name, array $columns, array $where = [])
    {
        $params = [];
        $template = "select" . " " . join(", ", $columns) . " " .  "from $table_name"; //TODO: fix this
        if (count($where)) {
            $readyConds = [];
            foreach ($where as $condition) {
                if (!($condition instanceof Where)) throw new Exception("invalid conition");
                $readyConds[] = $condition->translate();

                $params = array_merge($params, $condition->getParams());
            }
            $template = $template . " " . "where" . " " . join(" and ", $readyConds);
        }
        $stmt = $this->pdo->prepare($template);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function deleteFrom(string $table_name, array $on)
    {
        $template = "delete from $table_name";
        $params = [];
        if (!count($on)) throw new Exception("blind deletion is not allowed");
        $readyConds = [];
        foreach ($on as $condition) {
            if (!($condition instanceof Where)) throw new Exception("invalid conition");
            $readyConds[] = $condition->translate();
            $params = array_merge($params, $condition->getParams());
        }
        $template = $template . " " . "where" . " " . join(" and ", $readyConds);
        $stmt = $this->pdo->prepare($template);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function updateFrom(string $table_name, array $payload, array $where = []) {
        if(!count($where))throw new Exception("blind update is not allowed");
        $template = "update $table_name";
        $sets = [];
        $params = [];
        foreach ($payload as $column => $value) {
            $sets[] = "$column = :$column";
            $params[$column] = $value;
        }
        $template = $template . " " . "set" . " " . join(", ", $sets);
        foreach ($where as $condition) {
            if (!($condition instanceof Where)) throw new Exception("invalid conition");
            $readyConds[] = $condition->translate();

            $params = array_merge($params, $condition->getParams());
        }
        $template = $template . " " . "where" . " " . join(" and ", $readyConds);
        $stmt = $this->pdo->prepare($template);
        $stmt->execute($params);
        return $stmt;
        


    }
}



class Where
{
    private $hash;
    public function __construct(public string $column, public string $operation, public $value)
    {
        $this->hash = substr(md5(uniqid(rand(), true)), 0, 3);
    }

    public static function eq(string $column, $value)
    {
        return new Where($column, "=", $value);
    }


    public function getParams()
    {
        return ["{$this->column}_{$this->hash}" => $this->value];
    }


    public function translate()
    {
        return "{$this->column} {$this->operation} :{$this->column}_{$this->hash}";
    }
}

class WhereAnd extends Where
{
    private array $conds;
    public function __construct(array $conds)
    {

        foreach ($conds as $cond) {
            if (!($cond instanceof Where)) throw new Exception("invalid condition");
        }
        $this->conds = $conds;
    }

    public function getParams()
    {
        $result = [];
        foreach ($this->conds as $cond) {
            $result = array_merge($result, $cond->getParams());
        }
        return $result;
    }


    public function translate()
    {
        $readyConds = array_map(fn($cond) => $cond->translate(), $this->conds);
        return "(" . join(" and ", $readyConds) . ")";
    }
}

class WhereOr extends Where
{
    private array $conds;
    public function __construct(array $conds)
    {

        foreach ($conds as $cond) {
            if (!($cond instanceof Where)) throw new Exception("invalid condition");
        }
        $this->conds = $conds;
    }

    public function getParams()
    {
        $result = [];
        foreach ($this->conds as $cond) {
            $result = array_merge($result, $cond->getParams());
        }
        return $result;
    }


    public function translate()
    {
        $readyConds = array_map(fn($cond) => $cond->translate(), $this->conds);
        return "(" . join(" or ", $readyConds) . ")";
    }
}
