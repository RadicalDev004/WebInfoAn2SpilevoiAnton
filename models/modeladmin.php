<?php

class ModelAdmin {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getTables() {
        $stmt = $this->db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getTableData($table) {
        $allowedTables = $this->getTables();
        if (!in_array($table, $allowedTables)) {
            return [];
        }

        $stmt = $this->db->query("SELECT * FROM \"$table\"");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
