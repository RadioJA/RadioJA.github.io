<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $fecha_nacimiento = $data['fecha_nacimiento'];
    $hora_inicio = $data['hora_inicio'];
    $hora_fin = $data['hora_fin'];
    $periodo_inicio = $data['periodo_inicio'];
    $periodo_fin = $data['periodo_fin'];
    $dias_trabajo = $data['dias_trabajo'];

    $sql = "INSERT INTO locutores (nombre, apellido, fecha_nacimiento, hora_inicio, hora_fin, periodo_inicio, periodo_fin, dias_trabajo) 
            VALUES (:nombre, :apellido, :fecha_nacimiento, :hora_inicio, :hora_fin, :periodo_inicio, :periodo_fin, :dias_trabajo)";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':hora_inicio' => $hora_inicio,
            ':hora_fin' => $hora_fin,
            ':periodo_inicio' => $periodo_inicio,
            ':periodo_fin' => $periodo_fin,
            ':dias_trabajo' => $dias_trabajo
        ]);

        echo json_encode(['success' => true, 'message' => 'Registro agregado exitosamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM locutores";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}
?>