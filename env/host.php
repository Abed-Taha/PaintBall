<?php
class DB
{
    private static $pdo;

    private $table;
    private $columns = "*";
    private $wheres = [];
    private $limit;
    private $orderBy;
    private $relations = [];

    // -------------------------
    // Auto-connect to database
    // -------------------------
    public static function connect(
        $host = "localhost:3306",
        $db = "PaintBall",
        $user = "root",
        $pass = ""
    ) {
        if (!self::$pdo) {
            try {
                self::$pdo = new PDO(
                    "mysql:host=$host;dbname=$db;charset=utf8",
                    $user,
                    $pass
                );

            } catch (Exception $e) {
                http_response_code(500);
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }
        }
    }

    private static function ensureConnection()
    {
        if (!self::$pdo) {
            self::connect();
        }
    }

    // -------------------------
    // Table & select
    // -------------------------
    public static function table($table)
    {
        self::ensureConnection();
        $instance = new self;
        $instance->table = $table;
        return $instance;
    }
    public static function select($table, $columns = ["*"])
    {
        self::ensureConnection();
        $instance = new self;
        $instance->table = $table;
        $instance->columns = implode(", ", $columns);
        return $instance;
    }

    // -------------------------
    // WHERE
    // -------------------------
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

    public function whereNull($col)
    {
        $this->wheres[] = [$col, 'IS', null, 'AND'];
        return $this;
    }

    public function whereNotNull($col)
    {
        $this->wheres[] = [$col, 'IS NOT', null, 'AND'];
        return $this;
    }

    public function whereIn($col, $values)
    {
        $this->wheres[] = [$col, 'IN', $values, 'AND'];
        return $this;
    }
    // -------------------------
    // LIMIT
    // -------------------------
    public function limit($num)
    {
        $this->limit = $num;
        return $this;
    }

    public static function isVerified($user)
    {
        $user = self::table("users")->where("id", $user["id"])->first();
        if (is_null($user)) {
            return false;
        } else {
            return is_null($user["verified"]);
        }
    }

    // -------------------------
    // ORDER BY
    // -------------------------
    public function orderBy($col, $direction = "ASC")
    {
        $this->orderBy = "$col $direction";
        return $this;
    }

    // -------------------------
    // Relations (with)
    // -------------------------
    public function with($relationName, $function)
    {
        $this->relations[$relationName] = $function;
        return $this;
    }

    private function loadRelations($rows)
    {
        foreach ($this->relations ?? [] as $name => $function) {
            foreach ($rows as $row) {
                $row->$name = $function($row);
            }
        }
    }

    // -------------------------
    // Build Query
    // -------------------------
    private function buildQuery()
    {
        $sql = "SELECT " . $this->columns . " FROM " . $this->table;

        if (!empty($this->wheres)) {
            $sql .= " WHERE ";
            $parts = [];
            foreach ($this->wheres as $i => $w) {
                [$col, $op, $value, $type] = $w;
                if ($i == 0)
                    $type = "";

                if (is_array($value)) {
                    $placeholders = implode(", ", array_fill(0, count($value), "?"));
                    $parts[] = "$type $col $op ($placeholders)";
                } else {
                    $parts[] = "$type $col $op ?";
                }
            }
            $sql .= implode(" ", $parts);
        }

        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . $this->orderBy;
        }

        if (!empty($this->limit)) {
            $sql .= " LIMIT " . $this->limit;
        }

        return $sql;
    }

    private function getParams()
    {
        $params = [];
        foreach ($this->wheres as $w) {
            if (is_array($w[2])) {
                foreach ($w[2] as $val) {
                    $params[] = $val;
                }
            } else {
                $params[] = $w[2];
            }
        }
        return $params;
    }

    // -------------------------
    // GET / FIRST
    // -------------------------
    public function get()
    {
        $sql = $this->buildQuery();
        $stmt = self::$pdo->prepare($sql);
        try {
            $stmt->execute($this->getParams());
        } catch (Exception $e) {
            http_response_code(500);
            DTO::session_error($e->getMessage());
            header("Location:/");
            exit;
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Load relations
        $this->loadRelations($rows);

        return $rows;
    }

    public function first()
    {
        $this->limit(1);
        $data = $this->get();
        return $data[0] ?? null;
    }

    // -------------------------
    // INSERT / UPDATE / DELETE
    // -------------------------
    public function insert($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        $sql = "INSERT INTO " . $this->table . "($columns) VALUES ($placeholders)";
        $stmt = self::$pdo->prepare($sql);
        try {
            $stmt->execute(array_values($data));
        } catch (Exception $e) {
            http_response_code(500);
            DTO::session_error($e->getMessage());
            header("Location:/");
            exit;
        }

        $id = self::$pdo->lastInsertId();
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
        try {
            return $stmt->execute($params);
        } catch (Exception $e) {
            http_response_code(500);
            DTO::session_error($e->getMessage());
            header("Location:/");
            exit;
        }
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
        try {
            return $stmt->execute($this->getParams());
        } catch (Exception $e) {
            http_response_code(500);
            DTO::session_error($e->getMessage());
            header("Location:/");
            exit;
        }
    }
    public static function hasRole($role, $user_id): bool
    {
        return !empty(
            self::select('users')
                ->where('id', $user_id)
                ->where('role', $role)
                ->first()
        );
    }
}


