<form action="./index.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username">

    <label for="password">Password:</label>
    <input type="text" name="password" id="password">

    <button type="submit">Cerca</button>
</form>

<?php 

define("DB_SERVERNAME", "localhost:3306");
define("DB_USERNAME","root");
define("DB_PASSWORD", "root");	

// % inserisci in una nuova costante DB_NAME il valore "db_127"
define("DB_NAME", "127_login"); 

	
// # Creo una nuova istanza di un oggetto di tipo mysqli che abbia come valori di configurazione i valori passati	
$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
	
// < Verfico l'esistenza e il popolamento di $conn e controllo se ci sono errori
if ($conn && $conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} else {
    echo "Connection successful!";
}


// ! IL DATO IN ARRIVO DAL DB E' SACRO
// > IL DATO IN ARRIVO DALL'UTENTE E' IL MALE
    // > HTML, JS, BACKEND

// % controlliamo che esistano i valori username e password nella chiamata post e siano popolati
if (isset($_POST["username"]) && isset($_POST["password"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // % prepariamo la nostra query, inserendo dove vogliamo inserire valori un ?
    $query = "SELECT * FROM `users` WHERE `username` = ? AND `password`= ?";
    
    // % chiediamo all'istanza di mysqli di preparare la nostra query con i parametri e i ?
    $pQuery = $conn->prepare($query);

    // > chiediamo a mysqli di sostituire ogni ? con le variabili inserite successivamente e di quale tipo siano
    $pQuery->bind_param("ss", $username, $password);

    $pQuery->execute();

    $result = $pQuery->get_result();

    if ($result && $result->num_rows > 0) {   
        while($row = $result->fetch_assoc()) {
            echo "Accesso consentito!";
            var_dump($row);
        }
    } elseif ($result) {
        echo "Accesso negato";
    } else {
        echo "query error";
    }
}

// > Chiudiamo la nostra connessione
$conn->close();
?>