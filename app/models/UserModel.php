<?php
/**
 * Class UserModel
 * Menangani semua query ke tabel users
 */
class UserModel {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Registrasi user baru (Pelanggan)
     */
    public function register($nama, $username, $email, $password) {
        $query = "INSERT INTO " . $this->table_name . " (nama, username, email, password, role) 
                  VALUES (:nama, :username, :email, :password, 'pelanggan')";
        
        $stmt = $this->conn->prepare($query);

        // Standar keamanan: password_hash()
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Sanitize & Binding
        $stmt->bindParam(":nama", htmlspecialchars(strip_tags($nama)));
        $stmt->bindParam(":username", htmlspecialchars(strip_tags($username)));
        $stmt->bindParam(":email", htmlspecialchars(strip_tags($email)));
        $stmt->bindParam(":password", $hashed_password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Mengambil data user berdasarkan username (untuk verifikasi login)
     */
    public function getUserByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $username_clean= htmlspecialchars(strip_tags($username));
        $stmt->bindParam(":username", htmlspecialchars(strip_tags($username)));
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}