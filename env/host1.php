<?php
class DB
{
    private static $pdo;
    private $table;
    private $columns = "*";
    private $wheres = [];
    private $limit;


    public static function connect($host, $db, $user, $pass)
    {
        if (!self::$pdo) {
            self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public static function table($table)
    {
        $instance = new self;
        $instance->table = $table;
        return $instance;
    }
    public static function select($table, $columns = ["*"])
    {
        // Create new instance of DB class and it's look like SQL (name ,email , password ...)
        $instance = new self;
        $instance->table = $table;
        $instance->columns = implode(", ", $columns);  // array to string ex: ["name", "email"] => "name, email"
        return $instance;
    }

    public function where($col, $op, $value = null)
    {
        if ($value === null) {
            $value = $op;
            $op = "=";
        }

        $this->wheres[] = [$col, $op, $value, "AND"];
        return $this;
    }

    public function orWhere($col, $op, $value = null)
    {
        if ($value === null) {
            $value = $op;
            $op = "=";
        }

        $this->wheres[] = [$col, $op, $value, "OR"];
        return $this;
    }
    public function limit($num)
    {
        $this->limit = $num;
        return $this;
    }
    //!important private function
    private function buildQuery()
    {
        $sql = " SELECT " . $this->columns . " FROM " . $this->table;

        if (!empty($this->wheres)) {
            $sql .= " WHERE ";
            $parts = [];

            foreach ($this->wheres as $i => $w) {
                [$col, $op, $value, $type] = $w; // all values in $w array will separate to $column , $operator , $value , $type And , OR 

                if ($i == 0)
                    $type = "";
                $parts[] = "$type $col $op ?";
            }
            $sql .= implode(" ", $parts);
        }

        if ($this->limit) {
            $sql .= " LIMIT " . $this->limit;
        }

        return $sql;
    }

    private function getParams()
    {
        return array_map(fn($w) => $w[2], $this->wheres);
        // arrow function to return array of values from wheres array
        // example : fn(["age", ">", 18, "AND"]) => 18 
    }

    public function get()
    {
        $sql = $this->buildQuery();
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($this->getParams());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $this->limit(1);
        $data = $this->get();
        return $data[0] ?? null;
    }

    public function insert($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        $sql = "INSERT INTO " . $this->table . "(" . $columns . ") VALUES (" . $placeholders . ")";

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute(array_values($data));
        $id = self::$pdo->lastInsertId();

        // Return inserted row
        return self::table($this->table)->where("id", $id)->first();
    }

    public function update($data)
    {
        $setParts = [];
        foreach ($data as $col => $value) {
            $setParts[] = "$col = ?";
        }

        $sql = "UPDATE " . $this->table . " SET " . implode(", ", $setParts);

        if (!empty($this->wheres)) {
            $sql .= " WHERE ";
            $parts = [];
            foreach ($this->wheres as $i => $w) {
                [$col, $op, $value, $type] = $w;
                if ($i == 0)
                    $type = "";
                $parts[] = "$type $col $op ?";
            }
            $sql .= implode(" ", $parts);
        }

        $params = array_merge(array_values($data), $this->getParams());

        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete()
    {
        $sql = "DELETE FROM " . $this->table;

        if (!empty($this->wheres)) {
            $sql .= " WHERE ";
            $parts = [];

            foreach ($this->wheres as $i => $w) {
                [$col, $op, $value, $type] = $w;
                if ($i == 0)
                    $type = "";
                $parts[] = "$type $col $op ?";
            }

            $sql .= implode(" ", $parts);
        }

        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute($this->getParams());
    }
}
