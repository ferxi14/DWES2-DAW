<?php
function obtenerRanking($conn, $inicio, $fin) {
    try {
        $sql = 'SELECT t.Name, SUM(il.Quantity) AS Descargas
                FROM InvoiceLine il
                JOIN Track t ON il.TrackId = t.TrackId
                JOIN Invoice i ON il.InvoiceId = i.InvoiceId
                WHERE i.InvoiceDate BETWEEN :startDate AND :endDate
                GROUP BY t.TrackId
                ORDER BY Descargas DESC
                LIMIT 10';

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':startDate', $inicio);
        $stmt->bindParam(':endDate', $fin);

        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        trigger_error("Error al obtener el ranking de descargas: " . $e->getMessage(), E_USER_ERROR);
    }    
}
?>