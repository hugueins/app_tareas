<?php
require_once './config/config.php';

class TaskModel {
    private $db;

    // TODO: Constructor e inicialización de la base de datos
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // TODO: Obtener tareas por usuario
    public function getTasksByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT id, title, description, status, created_at, updated_at 
            FROM tasks 
            WHERE author_id = ? 
            ORDER BY created_at DESC
        ");
        
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        
        return $tasks;
    }

    // TODO: Crear nueva tarea
    public function createTask($title, $description, $userId) {
        $stmt = $this->db->prepare("
            INSERT INTO tasks (title, description, author_id) 
            VALUES (?, ?, ?)
        ");
        
        $stmt->bind_param("ssi", $title, $description, $userId);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Tarea creada exitosamente',
                'task_id' => $stmt->insert_id
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Error al crear la tarea'
        ];
    }

    // TODO: Actualizar tarea existente
    public function updateTask($taskId, $title, $description, $status, $userId) {
        // Verificar que la tarea pertenece al usuario
        $stmt = $this->db->prepare("
            SELECT id FROM tasks 
            WHERE id = ? AND author_id = ?
        ");
        
        $stmt->bind_param("ii", $taskId, $userId);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows === 0) {
            return [
                'success' => false,
                'message' => 'Tarea no encontrada o sin permisos'
            ];
        }

        // Construir la consulta de actualización dinámicamente
        $updateFields = [];
        $types = "";
        $values = [];

        if ($title !== null) {
            $updateFields[] = "title = ?";
            $types .= "s";
            $values[] = $title;
        }

        if ($description !== null) {
            $updateFields[] = "description = ?";
            $types .= "s";
            $values[] = $description;
        }

        if ($status !== null) {
            $updateFields[] = "status = ?";
            $types .= "i";
            $values[] = $status;
        }

        if (empty($updateFields)) {
            return [
                'success' => false,
                'message' => 'No hay campos para actualizar'
            ];
        }

        $query = "UPDATE tasks SET " . implode(", ", $updateFields) . " WHERE id = ? AND author_id = ?";
        $types .= "ii";
        $values[] = $taskId;
        $values[] = $userId;

        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Tarea actualizada exitosamente'
            ];
        }

        return [
            'success' => false,
            'message' => 'Error al actualizar la tarea'
        ];
    }

    // TODO: Eliminar tarea
    public function deleteTask($taskId, $userId) {
        $stmt = $this->db->prepare("
            DELETE FROM tasks 
            WHERE id = ? AND author_id = ?
        ");
        
        $stmt->bind_param("ii", $taskId, $userId);
        
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return [
                'success' => true,
                'message' => 'Tarea eliminada exitosamente'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Tarea no encontrada o sin permisos'
        ];
    }
}
?>