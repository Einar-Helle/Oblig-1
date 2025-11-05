<?php  /* slett-klasse */
/*
/*  Programmet lager et skjema for å velge en klasse som skal slettes  
/*  Programmet sletter den valgte klassen (men ikke hvis den har studenter)
*/
?> 

<script src="funksjoner.js"> </script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema" onSubmit="return bekreft()">
  Klassenavn <input type="text" id="klassenavn" name="klassenavn" required /> <br/>
  Studiumkode <input type="text" id="studiumkode" name="studiumkode" required /> <br/>
  <select name="klassekode" id="klassekode">
    <?php 
      print("<option value=''>velg klasse </option>");
      include("dynamiske-funksjoner.php"); 
      listeboksklasse(); 
    ?>
  </select><br/>
  <input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp" /> 
</form>

<?php
if (isset($_POST["slettklasseKnapp"])) {	
    $klassekode = $_POST["klassekode"];
    $klassenavn = $_POST["klassenavn"];
    $studiumkode = $_POST["studiumkode"];
    
    if (!$klassekode || !$klassenavn || !$studiumkode) {
        print ("Klassekode, klassenavn og studiumkode m&aring; fylles ut");
    } else {
        include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

        // 1. Finnes klassen?
        $sqlSetning = "SELECT * FROM klasse WHERE klassekode='$klassekode';";
        $sqlResultat = mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
        $antallRader = mysqli_num_rows($sqlResultat); 

        if ($antallRader == 0) {  /* klassen er ikke registrert */
            print ("Klassen finnes ikke");
        } else {

            // 2. Sjekk om det finnes studenter i denne klassen
            $sqlSetning = "SELECT COUNT(*) AS antall FROM student WHERE klassekode='$klassekode';";
            $sqlResultat = mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
            $rad = mysqli_fetch_assoc($sqlResultat);
            $antallStudenter = $rad["antall"];

            if ($antallStudenter > 0) {
                // Det finnes studenter → ikke slett
                print ("Kan ikke slette klassen $klassekode fordi den har $antallStudenter student(er).");
            } else {
                // 3. Ingen studenter → slett klassen
                $sqlSetning = "DELETE FROM klasse WHERE klassekode='$klassekode';";
                mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; slette data i databasen");
                
                print ("F&oslash;lgende klasse er n&aring; slettet: $klassekode  <br />");
            }
        }
    }
}
?> 









