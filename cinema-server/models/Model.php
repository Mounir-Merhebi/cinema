<?php 
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $mysqli, int $id){
        $sql = sprintf("Select * from %s WHERE %s = ?", 
                        static::$table, 
                        static::$primary_key);
        
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    public static function all(mysqli $mysqli){
        $sql = sprintf("Select * from %s", static::$table);
        
        $query = $mysqli->prepare($sql);
        $query->execute();

        $data = $query->get_result();

        $objects = [];
        while($row = $data->fetch_assoc()){
            $objects[] = new static($row); 
        }

        return $objects; 
    }


    public static function create(mysqli $mysqli, array $data)
    {
        $tableName = static::$table;
        $columns = array_keys($data);
        $columnsSql = implode(', ', $columns);
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $tableName,
            $columnsSql,
            $placeholders
        );

        $query = $mysqli->prepare($sql);

        if ($query === false) {
            error_log("Failed to prepare statement: " . $mysqli->error);
            return false;
        }

        $types = '';
        $values = [];

        foreach ($data as $key => $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } elseif (is_string($value)) {
                $types .= 's';
            } elseif (is_bool($value)) {
                $types .= 'i';
                $value = (int)$value;
            } elseif (is_null($value)) {
                $types .= 's';
            } else {
                $types .= 's';
                $value = (string)$value;
            }
            $values[] = $value;
        }

        if (!empty($values)) {
            $bindResult = $query->bind_param($types, ...$values);
            if ($bindResult === false) {
                error_log("Failed to bind parameters: " . $query->error);
                $query->close();
                return false;
            }
        }
        $executeResult = $query->execute();
        if ($executeResult === false) { 
            error_log("Failed to execute statement: " . $query->error);
            $query->close();
            return false;
        }
        $newId = $mysqli->insert_id;

        $query->close();

        return $newId;
    }
}