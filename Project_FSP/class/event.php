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

    public function getDetailEvent($idevent)
    {
        $sql = "SELECT * FROM event WHERE idevent = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function insertEvent($data)
    {
        $idgrup = $data['idgrup'];
        $judul = $data['judul'];
        $slug = $data['judul_slug'];
        $tanggal = $data['tanggal'];
        $keterangan = $data['keterangan'];
        $jenis = $data['jenis'];
        $poster = $data['poster_extension'];

        $sql = "INSERT INTO event (idgrup, judul, `judul-slug`, tanggal, keterangan, jenis, poster_extension)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("issssss", $idgrup, $judul, $slug, $tanggal, $keterangan, $jenis, $poster);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function deleteEvents($idgrup,$idevent)
    {
        $sql = "DELETE FROM event WHERE idevent = ? AND idgrup = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ii", $idevent, $idgrup);


        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
