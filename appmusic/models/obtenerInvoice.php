<?php
function obtenerInvoice($conn) {
    try {
        $sql = 'SELECT InvoiceId, InvoiceDate, Total FROM invoice WHERE CustomerId = :CustomerId';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':CustomerId', $_SESSION['usuario']['CustomerId'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        trigger_error("Error en la obtencion de las facturas invoice: " . $e->getMessage(), E_USER_ERROR);
    }
}

?>