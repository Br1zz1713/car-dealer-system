<?php

namespace App\Controllers;

use App\Controller;
use App\Models\User;
use App\Models\Vehicle;

class AdminController extends Controller
{
    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/admin/dashboard');
        }
        $this->view('admin.login');
    }

    public function authenticate()
    {
        session_start();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User($this->db);
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $this->redirect('/admin/dashboard');
        } else {
            $this->view('admin.login', ['error' => 'Invalid credentials']);
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        $this->redirect('/admin/login');
    }

    public function dashboard()
    {
        $this->requireAuth();
        $vehicleModel = new Vehicle($this->db);
        $vehicles = $vehicleModel->all();
        $this->view('admin.dashboard', ['vehicles' => $vehicles]);
    }

    public function add()
    {
        $this->requireAuth();
        $this->view('admin.form');
    }

    public function store()
    {
        $this->requireAuth();
        
        $data = [
            'make' => $_POST['make'],
            'model' => $_POST['model'],
            'year' => $_POST['year'],
            'price' => $_POST['price'],
            'description' => $_POST['description'],
            'media_urls' => $this->handleUploads()
        ];

        $vehicleModel = new Vehicle($this->db);
        $vehicleModel->create($data);
        
        $this->redirect('/admin/dashboard');
    }

    public function edit($id)
    {
        $this->requireAuth();
        $vehicleModel = new Vehicle($this->db);
        $vehicle = $vehicleModel->find($id);
        
        if (!$vehicle) {
            $this->redirect('/admin/dashboard');
        }

        $this->view('admin.form', ['vehicle' => $vehicle]);
    }

    public function update($id)
    {
        $this->requireAuth();
        
        $vehicleModel = new Vehicle($this->db);
        $currentVehicle = $vehicleModel->find($id);
        
        $newMedia = $this->handleUploads();
        $existingMedia = json_decode($currentVehicle['media_urls'], true) ?? [];
        
        // Merge new media with existing (unless replaced - logic can vary, here we allow adding)
        // ideally we would have a way to remove specific images, but for simplicity:
        // if new files are uploaded, we append them. 
        // A robust system would have a separate media management UI.
        // For this task, let's say if you upload new files, they are ADDED.
        
        $mediaUrls = array_merge($existingMedia, $newMedia);

        $data = [
            'make' => $_POST['make'],
            'model' => $_POST['model'],
            'year' => $_POST['year'],
            'price' => $_POST['price'],
            'description' => $_POST['description'],
            'media_urls' => $mediaUrls // Pass array, model encodes it
        ];

        $vehicleModel->update($id, $data);
        $this->redirect('/admin/dashboard');
    }

    public function delete($id)
    {
        $this->requireAuth();
        $vehicleModel = new Vehicle($this->db);
        $vehicleModel->delete($id);
        $this->redirect('/admin/dashboard');
    }

    protected function requireAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/admin/login');
        }
    }

    protected function handleUploads()
    {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../../public/uploads/';

        if (!empty($_FILES['media']['name'][0])) {
            foreach ($_FILES['media']['name'] as $key => $name) {
                if ($_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['media']['tmp_name'][$key];
                    $name = basename($name);
                    $filename = uniqid() . '_' . $name;
                    $destination = $uploadDir . $filename;
                    
                    if (move_uploaded_file($tmpName, $destination)) {
                        $uploadedFiles[] = 'uploads/' . $filename;
                    }
                }
            }
        }
        
        return $uploadedFiles;
    }
}
