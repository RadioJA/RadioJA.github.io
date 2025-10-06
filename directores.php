<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $fecha_nacimiento = $data['fecha_nacimiento'];
    $hora_entrada = $data['hora_entrada'];
    $hora_salida = $data['hora_salida'];
    $periodo_entrada = $data['periodo_entrada'];
    $periodo_salida = $data['periodo_salida'];
    $dias_laborables = $data['dias_laborables'];

    $sql = "INSERT INTO directores (nombre, apellido, fecha_nacimiento, hora_entrada, hora_salida, periodo_entrada, periodo_salida, dias_laborables) 
            VALUES (:nombre, :apellido, :fecha_nacimiento, :hora_entrada, :hora_salida, :periodo_entrada, :periodo_salida, :dias_laborables)";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':hora_entrada' => $hora_entrada,
            ':hora_salida' => $hora_salida,
            ':periodo_entrada' => $periodo_entrada,
            ':periodo_salida' => $periodo_salida,
            ':dias_laborables' => $dias_laborables
        ]);

        echo json_encode(['success' => true, 'message' => 'Registro agregado exitosamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM directores";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}
?>