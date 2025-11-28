<?php
require_once 'parent.php';

class Event extends classParent {

    public function __construct() {
        parent::__construct();
    }

    public function getEventsGroup($idgrup)
    {
        $sql = "SELECT * FROM event 
                WHERE idgrup = ?
                ORDER BY tanggal DESC";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idgrup);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getPosterExtension($idevent) {
        $stmt = $this->mysqli->prepare("SELECT poster_extension FROM event WHERE idevent=?");
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['poster_extension'];
    }

    public function getDetailEvent($idevent)
    {
        $sql = "SELECT * FROM event WHERE idevent = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updatePoster($idevent, $ext)
    {
        $stmt = $this->mysqli->prepare("
            UPDATE event SET poster_extension = ? WHERE idevent = ?
        ");
        $stmt->bind_param("si", $ext, $idevent);
        return $stmt->execute();
    }

    public function updateEvent($data)
    {
        $sql = "UPDATE event 
                SET judul = ?, tanggal = ?, jenis = ?, keterangan = ?, poster_extension = ?
                WHERE idevent = ? AND idgrup = ?";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param(
            "sssssii",
            $data['judul'],
            $data['tanggal'],
            $data['jenis'],
            $data['keterangan'],
            $data['poster_extension'],
            $data['idevent'],
            $data['idgrup']
        );
        $stmt->execute();
    }

    public function insertEvent($data)
    {
        $sql = "INSERT INTO event 
                (idgrup, judul, `judul-slug`, tanggal, keterangan, jenis, poster_extension)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param(
            "issssss",
            $data['idgrup'],
            $data['judul'],
            $data['judul_slug'],
            $data['tanggal'],
            $data['keterangan'],
            $data['jenis'],
            $data['poster_extension']
        );

        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }

    public function deleteEvents($idgrup,$idevent)
    {
        $sql = "DELETE FROM event WHERE idevent = ? AND idgrup = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ii", $idevent, $idgrup);

        return $stmt->execute();
    }
}
