<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Vehicle;

class PublicController extends Controller
{
    public function index()
    {
        $vehicleModel = new Vehicle($this->db);
        
        $filters = [
            'make' => $_GET['make'] ?? null,
            'model' => $_GET['model'] ?? null,
            'min_price' => $_GET['min_price'] ?? null,
            'max_price' => $_GET['max_price'] ?? null,
        ];

        $vehicles = $vehicleModel->all($filters);
        $this->view('public.home', ['vehicles' => $vehicles, 'filters' => $filters]);
    }

    public function show($id)
    {
        $vehicleModel = new Vehicle($this->db);
        $vehicle = $vehicleModel->find($id);

        if (!$vehicle) {
            http_response_code(404);
            echo "Vehicle not found";
            return;
        }

        $this->view('public.detail', ['vehicle' => $vehicle]);
    }
}
