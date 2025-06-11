<?php
require_once "../app/db/dbConnection.php";

class ChecklistItem {
    private $db;

    function __construct() {
        $this->db = Database::getInstance();
    }

    function insert($dados) {
        $query = "INSERT INTO tChecklistItems (description, id_father, is_concluded)
                  VALUES (?, ?, ?)";

        $params = [
            'description' => $dados['description'],
            'id_father'   => $dados['id_father']
        ];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }

    function searchById($id) {
        $query = "SELECT * FROM tChecklistItems WHERE checklist_id = ?";

        $params = ['id' => $id];

        $stmt = $this->db->executeQuery($query, $params);
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return [
            'lastQuery' => $lastQuery,
            'result'    => $results
        ];
    }

    function removeById($id) {
        $query = "UPDATE tChecklistItems SET inactivated_at = CURRENT_TIMESTAMP WHERE id = ? AND inactivated_at IS NULL";

        $params = ['id' => $id];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }

    function updateById($id, $dados) {
        $query = "UPDATE tChecklistItems SET description = ?, id_father = ?, is_concluded = ?
                  WHERE id = ? AND inactivated_at IS NULL";

        $params = [
            'description'  => $dados['description'],
            'id_father'    => $dados['id_father'],
            'is_concluded' => $dados['is_concluded'],
            'id'           => $id
        ];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }
}
?>