<?php
/**
 * Class ProdukModel
 * Menangani operasi CRUD untuk tabel produk
 */
class ProdukModel {
    private $conn;
    private $table_name = "produk";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mengambil semua produk beserta nama kategorinya
     */
    public function getAll() {
        $query = "SELECT p.*, k.nama_kategori 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN kategori k ON p.kategori_id = k.id 
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Menambah produk baru
     */
    public function create($kategori_id, $nama_produk, $deskripsi, $harga, $stok, $ukuran, $foto, $is_best_seller) {
        $query = "INSERT INTO " . $this->table_name . " (kategori_id, nama_produk, deskripsi, harga, stok, ukuran, foto) 
                  VALUES (:kategori_id, :nama_produk, :deskripsi, :harga, :stok, :ukuran, :foto)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":kategori_id", $kategori_id);
        $stmt->bindParam(":nama_produk", htmlspecialchars(strip_tags($nama_produk)));
        $stmt->bindParam(":deskripsi", htmlspecialchars(strip_tags($deskripsi)));
        $stmt->bindParam(":harga", $harga);
        $stmt->bindParam(":stok", $stok);
        $stmt->bindParam(":ukuran", htmlspecialchars(strip_tags($ukuran)));
        $stmt->bindParam(":foto", $foto);

        return $stmt->execute();
    }

    public function getById($id) {

    $query = "SELECT * FROM produk
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(
        ':id',
        $id,
        PDO::PARAM_INT
    );

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);

}
    public function update($id, $nama_produk, $kategori_id, $harga, $stok, $ukuran, $deskripsi, $foto, $is_best_seller) {
        $query = "UPDATE produk
                  SET
                      nama_produk   = :nama_produk,
                      kategori_id   = :kategori_id,
                      harga         = :harga,
                      stok          = :stok,
                      ukuran        = :ukuran,
                      deskripsi     = :deskripsi,
                      foto          = :foto,
                      is_best_seller = :is_best_seller
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id',             $id,            PDO::PARAM_INT);
        $stmt->bindParam(':nama_produk',    htmlspecialchars(strip_tags($nama_produk)));
        $stmt->bindParam(':kategori_id',    $kategori_id,   PDO::PARAM_INT);
        $stmt->bindParam(':harga',          $harga);
        $stmt->bindParam(':stok',           $stok,          PDO::PARAM_INT);
        $stmt->bindParam(':ukuran',         htmlspecialchars(strip_tags($ukuran)));
        $stmt->bindParam(':deskripsi',      htmlspecialchars(strip_tags($deskripsi)));
        $stmt->bindParam(':foto',           $foto);
        $stmt->bindParam(':is_best_seller', $is_best_seller, PDO::PARAM_INT);

        return $stmt->execute();
    }

public function toggleStatus($id){

    $query = "
    UPDATE produk
    SET tersedia =
    IF(tersedia = 1, 0, 1)
    WHERE id = :id
    ";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(
        ':id',
        $id,
        PDO::PARAM_INT
    );

    return $stmt->execute();
}

    /**
     * Menghapus produk berdasarkan ID
     */
    /**
     * Menghapus produk dari database dengan bypass Foreign Key sementara
     */
    public function delete($id) {
        try {
            // Gunakan $this->conn (sesuaikan dengan properti database di model kamu)
            $this->conn->exec("SET FOREIGN_KEY_CHECKS = 0;");

            $query = "DELETE FROM produk WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            $this->conn->exec("SET FOREIGN_KEY_CHECKS = 1;");

            return $result;
        } catch (PDOException $e) {
            // Jika error, pastikan foreign key check dinyalakan kembali
            if (isset($this->conn)) {
                $this->conn->exec("SET FOREIGN_KEY_CHECKS = 1;");
            }
            return false;
        }
    }
}