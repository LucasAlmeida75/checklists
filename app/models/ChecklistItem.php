<?php
require_once "../app/db/dbConnection.php";

class ChecklistItem {
    private $db;

    function __construct() {
        $this->db = Database::getInstance();
    }

    function insert($dados) {
        $query = "INSERT INTO tChecklistItems (checklist_id, description, position, is_concluded)
                  VALUES (?, ?, ?, ?)";

        $params = [
            'checklist_id' => $dados['idChecklist'],
            'description'  => $dados['description'],
            'position'     => $dados['position'],
            'is_concluded' => $dados['concluded']
        ];

        $id = $this->db->executeQuery($query, $params, true);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return [
            'lastQuery' => $lastQuery,
            'result' => $id
        ];
    }

    function searchByChecklistId($id) {
        $query = "SELECT * FROM tChecklistItems WHERE checklist_id = ? and inactivated_at is NULL ORDER BY POSITION";

        $params = ['checklist_id' => $id];

        $stmt = $this->db->executeQuery($query, $params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return [
            'lastQuery' => $lastQuery,
            'result'    => $results
        ];
    }

    function searchById($id, $dados) {
        $query = "SELECT * FROM tChecklistItems WHERE id = ? AND checklist_id = ? ORDER BY POSITION";

        $params = [
            'id' => $id,
            'checklist_id' => $dados['idChecklist']
        ];

        $stmt = $this->db->executeQuery($query, $params);
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return [
            'lastQuery' => $lastQuery,
            'result'    => $results
        ];
    }

    function deleteById($id) {
        $query = "UPDATE tChecklistItems SET inactivated_at = CURRENT_TIMESTAMP WHERE id = ? AND inactivated_at IS NULL";

        $params = ['id' => $id];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }

    function updateById($id, $dados) {
        $query = "UPDATE tChecklistItems SET description = ?, is_concluded = ?, position = ?
                  WHERE id = ? AND inactivated_at IS NULL";

        $params = [
            'description'  => $dados['description'],
            'is_concluded' => $dados['concluded'],
            'position'     => $dados['position'],
            'id'           => $id
        ];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }

    function updatePosition($dados) {
        $query = "UPDATE tChecklistItems SET position = ?
                  WHERE id = ? AND inactivated_at IS NULL";

        $params = [
            'position' => $dados['position'],
            'id'       => $dados['itemId'],
        ];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }
}
?>