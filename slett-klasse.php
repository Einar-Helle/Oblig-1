<?php  /* slett-klasse */
/*
/*  Programmet lager et skjema for å velge en klasse som skal slettes  
/*  Programmet sletter den valgte klassen (men ikke hvis den har studenter)
*/
?> 

<script src="funksjoner.js"> </script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema" onSubmit="return bekreft()">
  <select name="klassenavn" id="klassenavn">
  <select name="studiumkode" id="studiumkode">
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

        // 1. Finnes klassen?
        $sqlSetning = "SELECT * FROM klasse WHERE klassekode='$klassekode';";

        if ($antallRader == 0) {  /* klassen er ikke registrert */
            print ("Klassen finnes ikke");
        } else {

            // 2. Sjekk om det finnes studenter i denne klassen
            $sqlSetning = "SELECT COUNT(*) AS antall FROM student WHERE klassekode='$klassekode';";
            $sqlResultat = mysqli_query($sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
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
?> 

















