<?php

namespace App;

class Controller
{
    protected $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $this->db = new \PDO($dsn, $config['username'], $config['password'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    protected function view($view, $data = [])
    {
        extract($data);
        
        // Check if allow partial path or just filename
        // views usually in views/ directory
        $viewPath = __DIR__ . '/../views/' . str_replace('.', '/', $view) . '.php';

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            die("View {$view} not found.");
        }
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
