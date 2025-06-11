<?php
require_once "../app/db/dbConnection.php";

class Checklist {
    private $db;

    function __construct() {
        $this->db = Database::getInstance();
    }

    function insert($dados) {
        $query = "INSERT INTO tChecklists (id, description)
                  VALUES (?, ?)";

        $params = [
            'id'          => $dados['id'],
            'description' => $dados['description']
        ];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }

    function searchById($id) {
        $query = "SELECT * FROM tChecklists WHERE id = ?";

        $params = ['id' => $id];

        $stmt = $this->db->executeQuery($query, $params);
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return [
            'lastQuery' => $lastQuery,
            'result'    => $results
        ];
    }

    function updateById($id, $dados) {
        $query = "UPDATE tChecklists SET description = ?
                  WHERE id = ? AND inactivated_at IS NULL";

        $params = [
            'description' => $dados['descriptionChecklist'],
            'id'          => $id
        ];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }
}
?>