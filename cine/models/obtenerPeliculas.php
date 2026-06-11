<?php
function obtenerPeliculas($conn){
    try {
        $sql = "SELECT *
                FROM rpeliculas
                WHERE disponible='S'
                ORDER BY titulo";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }   
}

?>