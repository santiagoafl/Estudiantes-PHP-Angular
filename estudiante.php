<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


$method = $_SERVER['REQUEST_METHOD'];

include 'conexion.php';

switch ($method) {

    case 'GET':
        $stmt = $conn->query("SELECT * FROM estudiante");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("INSERT INTO estudiante (id_persona, numero_matricula, grado) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['id_persona'],
            $data['numero_matricula'],
            $data['grado']
        ]);
        break;

    case 'PUT':
        parse_str($_SERVER['QUERY_STRING'], $params);
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("UPDATE estudiante SET id_persona = ?, numero_matricula = ?, grado = ? WHERE id = ?");
        $stmt->execute([
            $data['id_persona'],
            $data['numero_matricula'],
            $data['grado'],
            $params['id']
        ]);
        break;

    case 'DELETE':
        parse_str($_SERVER['QUERY_STRING'], $params);
        $stmt = $conn->prepare("DELETE FROM estudiante WHERE id = ?");
        $stmt->execute([$params['id']]);
        break;
}
?>