<?php  /* slett-klasse med kun listeboks */
/*
   Programmet lar deg velge en klasse fra en listeboks
   og sletter den kun hvis den ikke har studenter.
*/
?>

<script src="funksjoner.js"></script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema" onSubmit="return bekreft()">
  <label for="klassekode">Velg klasse som skal slettes:</label><br/>
  <select name="klassekode" id="klassekode" required>
    <?php 
      print("<option value=''>Velg klasse</option>");
      include("dynamiske-funksjoner.php");
      listeboksklasse();  // henter liste over klasser fra databasen
    ?>
  </select><br/><br/>
  
  <input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp" />
</form>

<?php
if (isset($_POST["slettklasseKnapp"])) {	
    $klassekode = $_POST["klassekode"];
    
    if (!$klassekode) {
        print("Du må velge en klasse.");
    } else {
        include("db-tilkobling.php");  // kobler til databasen

        // 1. Finnes klassen?
        $sqlSetning = "SELECT * FROM klasse WHERE klassekode='$klassekode';";
        $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig &aring; hente data fra databasen");
        $antallRader = mysqli_num_rows($sqlResultat); 

        if ($antallRader == 0) {
            print("Klassen finnes ikke i databasen.");
        } else {
            // 2. Sjekk om klassen har studenter
            $sqlSetning = "SELECT COUNT(*) AS antall FROM student WHERE klassekode='$klassekode';";
            $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig &aring; hente data fra databasen");
            $rad = mysqli_fetch_assoc($sqlResultat);
            $antallStudenter = $rad["antall"];

            if ($antallStudenter > 0) {
                print("Kan ikke slette klassen $klassekode fordi den har $antallStudenter student(er).");
            } else {
                // 3. Ingen studenter → slett
                $sqlSetning = "DELETE FROM klasse WHERE klassekode='$klassekode';";
                mysqli_query($db, $sqlSetning) or die("Ikke mulig &aring; slette data i databasen");

                print("Klassen <strong>$klassekode</strong> er nå slettet.");
            }
        }
    }
}
?>




















