<?php  /* slett-student */
/*
   Programmet lager et skjema for å velge en student som skal slettes  
   Programmet sletter den valgte studenten
*/
?> 

<script src="funksjoner.js"> </script>

<h3>Slett student</h3>

<form method="post" action="" id="slettStudentSkjema" name="slettStudentSkjema" onSubmit="return bekreft()">
  <label for="brukernavn">Velg student som skal slettes:</label><br/>
  <select name="brukernavn" id="brukernavn" required>
    <?php 
      print("<option value=''>velg student</option>");
      include("dynamiske-funksjoner.php"); 
      listeboksstudent(); 
    ?>
  </select><br/><br/>

  <input type="submit" value="Slett student" name="slettStudentKnapp" id="slettStudentKnapp" />
</form>

<?php
if (isset($_POST["slettStudentKnapp"])) {	
    $brukernavn = $_POST["brukernavn"];
    
    if (!$brukernavn) {
        print("Du m&aring; velge en student.");
    } else {
        include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

        // 1. Finnes studenten?
        $sqlSetning  = "SELECT * FROM student WHERE brukernavn='$brukernavn';";
        $sqlResultat = mysqli_query($db, $sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
        $antallRader = mysqli_num_rows($sqlResultat); 

        if ($antallRader == 0) {  /* studenten er ikke registrert */
            print("Studenten finnes ikke");
        } else {
            // 2. Slett studenten
            $sqlSetning = "DELETE FROM student WHERE brukernavn='$brukernavn';";
            mysqli_query($db, $sqlSetning) or die ("ikke mulig &aring; slette data i databasen");
            
            print("F&oslash;lgende student er n&aring; slettet: $brukernavn<br />");
        }
    }
}
?> 









