<?php 
// ! Index non e' altro che uno dei due metodi delle cRud, ovvero READ (plurale)
define("DB_SERVERNAME", "localhost:3306");
define("DB_USERNAME","root");
define("DB_PASSWORD", "root");	
define("DB_NAME", "db_127");  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers Index LIST</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <header>
        <h1>
            Teachers:
        </h1>
    </header>


    <main class="container">
        <section class="row">
            <?php 
                // # Creo una nuova istanza di un oggetto di tipo mysqli che abbia come valori di configurazione i valori passati	
                $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
                    
                // < Verfico l'esistenza e il popolamento di $conn e controllo se ci sono errori
                if ($conn && $conn->connect_error) {
                    echo "Connection failed: " . $conn->connect_error;
                } else {
                    // echo "Connection successful!";
                }

                $query = "SELECT * FROM `teachers`";
                $pQuery = $conn->prepare($query);
                $pQuery->execute();
                $result = $pQuery->get_result();

                if ($result && $result->num_rows > 0) {   
                    while($row = $result->fetch_assoc()) {?> 
                        <article class="col-2 mb-3 p-2 text-center">
                            <div class="card w-100" >
                                <div class="card-body">
                                    <a href="./show.php?id=<?php echo$row['id']; ?>" class="card-link">
                                        <?php echo $row['name']; ?> <?php echo $row['surname']; ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php  }
                } elseif ($result) {
                    echo "Accesso negato";
                } else {
                    echo "query error";
                }


                // > Chiudiamo la nostra connessione
                $conn->close();
                ?>
        </section>
    </main>


</body>
</html>
