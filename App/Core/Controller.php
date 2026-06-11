<?php
namespace App\Core;

class Controller {
    public function view($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once __DIR__ . '/../Views/templates/header.php';
            require_once $viewFile;
            require_once __DIR__ . '/../Views/templates/footer.php';
        } else {
            die("View $view not found!");
        }
    }
    
    public function viewWithoutTemplate($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View $view not found!");
        }
    }

    public function redirect($url) {
        // Base URL helper
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1));
        header("Location: " . $basepath . $url);
        exit;
    }
}
