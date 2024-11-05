<?php
        // Połącz się z bazą danych
        $conn =  mysqli_connect("server", "username", "password", "dbname");

        // Sprawdź połączenie
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Pobierz losowe zdjęcie i podpis z bazy danych
        $sql = "SELECT * FROM zdjecia ORDER BY RAND() LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response = array('nazwa_pliku' => $row['nazwa_pliku'], 'podpis' => $row['podpis']);
            echo json_encode($response);
        } else {
            echo "Brak danych w bazie";
        }

        $conn->close();
?>