<?php
require_once './models/TaskModel.php';
require_once './models/UserModel.php';

class TaskController {
    private $taskModel;
    private $userModel;

    public function __construct() {
        $this->taskModel = new TaskModel();
        $this->userModel = new UserModel();
    }

    public function handleRequest() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (!isset($data['action'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Acción no especificada'
            ]);
            return;
        }

        switch($data['action']) {
            case 'login':
                $this->login($data);
                break;
            case 'getTasks':
                $this->getTasks($data);
                break;
            case 'createTask':
                $this->createTask($data);
                break;
            case 'updateTask':
                $this->updateTask($data);
                break;
            case 'deleteTask':
                $this->deleteTask($data);
                break;
            default:
                echo json_encode([
                    'success' => false,
                    'message' => 'Acción no válida'
                ]);
        }
    }

    private function login($data) {
        if (!isset($data['username']) || !isset($data['password'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Datos incompletos'
            ]);
            return;
        }

        $result = $this->userModel->login($data['username'], $data['password']);
        echo json_encode($result);
    }

    private function getTasks($data) {
        if (!isset($data['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'ID de usuario no especificado'
            ]);
            return;
        }

        $result = $this->taskModel->getTasksByUser($data['user_id']);
        echo json_encode($result);
    }

    private function createTask($data) {
        if (!isset($data['user_id']) || !isset($data['title'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Datos incompletos'
            ]);
            return;
        }

        $result = $this->taskModel->createTask(
            $data['title'],
            $data['description'] ?? '',
            $data['user_id']
        );
        echo json_encode($result);
    }

    private function updateTask($data) {
        if (!isset($data['id']) || !isset($data['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Datos incompletos'
            ]);
            return;
        }

        $result = $this->taskModel->updateTask(
            $data['id'],
            $data['user_id'],
            $data['title'] ?? null,
            $data['description'] ?? null,
            isset($data['status']) ? (int)$data['status'] : null
        );
        echo json_encode($result);
    }

    private function deleteTask($data) {
        if (!isset($data['id']) || !isset($data['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Datos incompletos'
            ]);
            return;
        }

        $result = $this->taskModel->deleteTask($data['id'], $data['user_id']);
        echo json_encode($result);
    }
}
?>