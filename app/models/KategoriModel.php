<?php
/**
 * Class KategoriModel
 * Menangani operasi CRUD untuk tabel kategori
 */
class KategoriModel {
    private $conn;
    private $table_name = "kategori";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mengambil semua data kategori
     */
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nama_kategori ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Menambah kategori baru
     */
    public function create($nama_kategori) {
        $query = "INSERT INTO " . $this->table_name . " (nama_kategori) VALUES (:nama_kategori)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nama_kategori", htmlspecialchars(strip_tags($nama_kategori)));
        return $stmt->execute();
    }

    /**
     * Menghapus kategori berdasarkan ID
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}