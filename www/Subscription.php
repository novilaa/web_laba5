<?php
class Subscription {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($name, $subscription_period, $magazine, $electronic_version, $payment_method) {
        $sql = "INSERT INTO subscriptions (name, subscription_period, magazine, electronic_version, payment_method) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $name,
            $subscription_period,
            $magazine,
            $electronic_version ? 1 : 0,
            $payment_method
        ]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM subscriptions ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function update($id, $data) {
        $sql = "UPDATE subscriptions 
                SET name = ?, 
                    subscription_period = ?, 
                    magazine = ?, 
                    electronic_version = ?,
                    payment_method = ?
                WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['subscription_period'],
            $data['magazine'],
            isset($data['electronic_version']) ? 1 : 0,
            $data['payment_method'],
            $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM subscriptions WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM subscriptions WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}