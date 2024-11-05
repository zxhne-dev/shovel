<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pochwal się swoim szpadlem</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="file"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        input[type="submit"] {
            background-color: #e6e4df;
            padding: 10px 15px;
            border: 1px solid black;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: .2s;
        }

        input[type="submit"]:hover {
            background-color: #96948f;
            color: white;
        }

        /* Optional: Add responsive styles for smaller screens */
        @media (max-width: 768px) {
            form {
                max-width: 100%;
            }
        }
        p{
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file">Wybierz plik:</label>
        <input type="file" name="file" id="file" accept="video/mp4,image/*" required> <br>
        <label for="podpis">Podpis do zdjęcia:</label>
        <input type="text" name="podpis" id="podpis" required><br>
        <input type="submit" value="Prześlij plik">
    </form>
    <?php
        $targetDirectory = "img/";
        $conn =  mysqli_connect("server", "username", "password", "dbname");
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
            $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
                elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } 
                else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                $hostname = gethostbyaddr($ip);

                $file = $_FILES["file"]["name"];
                $podpis = $_POST['podpis'];
                $sql = "INSERT INTO zdjecia(nazwa_pliku,podpis,ip_dawcy,dawca) VALUES ('$file','$podpis','$ip','$hostname')";
                //$sql = "INSERT INTO zdjecia(nazwa_pliku,podpis) VALUES ('$file','$podpis')";
                $conn -> query($sql);
                echo "<p>Plik został pomyślnie przesłany i zapisany.</p>";
            } else {
                echo "<p>Wystąpił błąd podczas zapisywania pliku.</p>";
            }
        } 
    ?>
    <script>
            window.addEventListener('load', function () {
            let adsDiv = document.getElementById('ads');
            let ads_bottom_static = document.getElementById('ads_bottom_static');
            if (adsDiv || ads_bottom_static) {
                adsDiv.remove();
                ads_bottom_static.remove();
            }
        });
    </script>


</body>
</html>


