<?php

class OfficineManager
{
    private $conn;

    public function __construct()
    {
        require_once __DIR__ . "/DatabaseManager.php";
        $db = new DatabaseManager();
        $this->conn = $db->getConnection();
    }

    //returns all servizi of an officina based on the officinaId (codiceOfficina)
    public function getAllServiziOfOfficina($codiceOfficina)
    {
        $stmt = $this->conn->prepare("SELECT *
        FROM servizi s INNER JOIN officine_servizi os USING (codice_servizio)
        WHERE  os.codice_officina=?");
        $stmt->bind_param("i", $codiceOfficina);
        $stmt->execute();
        $result = $stmt->get_result();
        $servizi = [];
        while ($row = $result->fetch_assoc()) {
            $servizi[] = $row;
        }
        return $servizi;
    }
    public function getAllPezziOfOfficina($codiceOfficina)
    {
        $stmt = $this->conn->prepare("SELECT *
        FROM pezzi_ricambio p INNER JOIN officine_pezzi op USING (codice_pezzo)
        WHERE  op.codice_officina=?");
        $stmt->bind_param("i", $codiceOfficina);
        $stmt->execute();
        $result = $stmt->get_result();
        $pezzi = [];
        while ($row = $result->fetch_assoc()) {
            $pezzi[] = $row;
        }
        return $pezzi;
    }

    public function getAllAccessoriOfOfficina($codiceOfficina)
    {
        $stmt = $this->conn->prepare("SELECT *
        FROM accessori a INNER JOIN officine_accessori oa USING (codice_accessorio)
        WHERE  oa.codice_officina=?");
        $stmt->bind_param("i", $codiceOfficina);
        $stmt->execute();
        $result = $stmt->get_result();
        $accessori = [];
        while ($row = $result->fetch_assoc()) {
            $accessori[] = $row;
        }
        return $accessori;
    }

    //returns all columns and all rows of any table given
    public function getAll($table)
    {
        $q = "SELECT * FROM $table";
        $result = $this->conn->query($q);

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }


    //returns all officine optionally filtered by a certain pezzo or accessorio or servizio (or all of them)
    public function getAllOfficineFiltered($pezzoId = null, $accessorioId = null, $servizioId = null)
    {
        $q = "SELECT * FROM officine a";
        $qExtraConditions = "";
        $types = "";
        $params = [];

        if (!is_null($pezzoId)) {
            $q .= " INNER JOIN officine_pezzi op USING (codice_officina)";
            $qExtraConditions .= " AND op.codice_pezzo=?";
            $types .= "i";
            $params[] = $pezzoId;
        }

        if (!is_null($accessorioId)) {
            $q .= " INNER JOIN officine_accessori oa USING (codice_officina)";
            $qExtraConditions .= " AND oa.codice_accessorio=?";
            $types .= "i";
            $params[] = $accessorioId;
        }

        if (!is_null($servizioId)) {
            $q .= " INNER JOIN officine_servizi os USING (codice_officina)";
            $qExtraConditions .= " AND os.codice_servizio=?";
            $types .= "i";
            $params[] = $servizioId;
        }

        $q .= " WHERE 1=1";
        $q .= $qExtraConditions;

        $stmt = $this->conn->prepare($q);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();

        // $result = $stmt->get_result();

        // $officine = [];
        // while ($row = $result->fetch_assoc()) {
        //     $officine[] = $row;
        // }
        // return $officine;

        //the following line is the same as the previous commented code apparently (just learned this from gemini)
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addPezzo($nome, $costo, $descrizione)
    {
        $stmt = $this->conn->prepare("INSERT INTO pezzi_ricambio (nome_pezzo, costo_unitario, descrizione) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $nome, $costo, $descrizione);
        return $stmt->execute();
    }

    public function addServizio($nome, $costo_orario, $descrizione)
    {
        $stmt = $this->conn->prepare("INSERT INTO servizi (nome_servizio, costo_orario, descrizione) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $nome, $costo_orario, $descrizione);
        return $stmt->execute();
    }

    public function addAccessorio($nome, $costo, $descrizione)
    {
        $stmt = $this->conn->prepare("INSERT INTO accessori (nome_accessorio, costo_unitario, descrizione) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $nome, $costo, $descrizione);
        return $stmt->execute();
    }

    public function addPezzoToOfficina($codiceOfficina, $codicePezzo, $quantita)
    {
        $stmt = $this->conn->prepare("INSERT INTO officine_pezzi (codice_officina, codice_pezzo, quantita) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $codiceOfficina, $codicePezzo, $quantita);
        return $stmt->execute();
    }

    public function addServizioToOfficina($codiceOfficina, $codiceServizio)
    {
        $stmt = $this->conn->prepare("INSERT INTO officine_servizi (codice_officina, codice_servizio) VALUES (?, ?)");
        $stmt->bind_param("ii", $codiceOfficina, $codiceServizio);
        return $stmt->execute();
    }

    public function addAccessorioToOfficina($codiceOfficina, $codiceAccessorio, $quantita)
    {
        $stmt = $this->conn->prepare("INSERT INTO officine_accessori (codice_officina, codice_accessorio, quantita) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $codiceOfficina, $codiceAccessorio, $quantita);
        return $stmt->execute();
    }
}
