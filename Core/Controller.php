<?php
namespace App\Core;

class Controller {
    protected function render($view, $data = []) {
        // Extract data to make it available in view
        extract($data);
        
        // Build the view path
        $viewPath = __DIR__ . "/../Views/" . $view . ".php";
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new \Exception("View {$view} not found");
        }
        
        // Get contents and clean the buffer
        $content = ob_get_clean();
        
        // Include the layout
        require __DIR__ . "/../Views/layout/main.php";
    }

    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }

    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    protected function isAuthenticated(): bool {
        return isset($_SESSION['user_id']);
    }

    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }

    protected function requireRole($role) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== $role) {
            $this->redirect('/unauthorized');
        }
    }

    protected function getCurrentUser() {
        if ($this->isAuthenticated()) {
            return \App\Models\User::getUserById($this->getDB(), $_SESSION['user_id']);
        }
        return null;
    }

    protected function getDB() {
        global $db;
        return $db;
    }

    protected function validateCSRF() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $this->jsonResponse(['error' => 'Invalid CSRF token'], 403);
            }
        }
    }

    protected function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
?>
