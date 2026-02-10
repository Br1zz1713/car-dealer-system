<?php

namespace App\Models;

class Vehicle
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function all($filters = [])
    {
        $sql = "SELECT * FROM vehicles WHERE 1=1";
        $params = [];

        if (!empty($filters['make'])) {
            $sql .= " AND make LIKE :make";
            $params['make'] = '%' . $filters['make'] . '%';
        }
        if (!empty($filters['model'])) {
            $sql .= " AND model LIKE :model";
            $params['model'] = '%' . $filters['model'] . '%';
        }
        if (!empty($filters['min_price'])) {
            $sql .= " AND price >= :min_price";
            $params['min_price'] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND price <= :max_price";
            $params['max_price'] = $filters['max_price'];
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM vehicles WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO vehicles (make, model, year, price, description, media_urls) 
                VALUES (:make, :model, :year, :price, :description, :media_urls)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'make' => $data['make'],
            'model' => $data['model'],
            'year' => $data['year'],
            'price' => $data['price'],
            'description' => $data['description'],
            'media_urls' => json_encode($data['media_urls'])
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE vehicles SET make = :make, model = :model, year = :year, 
                price = :price, description = :description, media_urls = :media_urls 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'make' => $data['make'],
            'model' => $data['model'],
            'year' => $data['year'],
            'price' => $data['price'],
            'description' => $data['description'],
            'media_urls' => json_encode($data['media_urls'])
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM vehicles WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
