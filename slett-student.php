<?php  /* slett-student */
/*
/*  Programmet lager et skjema for å velge et poststed som skal slettes  
/*  Programmet sletter det valgte poststedet
*/
?> 

<script src="funksjoner.js"> </script>

<h3>Slett student</h3>

<form method="post" action="" id="slettStudentSkjema" name="slettStudentSkjema" onSubmit="return bekreft()">
  Brukernavn <input type="text" id="brukernavn" name="brukernavn" required /> <br/>
  Fornavn <input type="text" id="fornavn" name="fornavn" required /> <br/>
  Etternavn <input type="text" id="etternavn" name="etternavn" required /> <br/>
  Klassekode <input type="text" id="klassekode" name="klassekode" required /> <br/>
	<select name="studiumkode" id="studiumkode">
<?php print("<option value=''>velg student </option>");
include("dynamiske-funksjoner.php"); listebokstudent(); ?>
	</select><br/>
  <input type="submit" value="Slett student" name="slettStudentKnapp" id="slettStudentKnapp" />
 </form>

<?php
  if (isset($_POST ["slettStudentKnapp"]))
    {	
      $brukernavn=$_POST ["brukernavn"]; 
      $fornavn=$_POST ["fornavn"];
      $etternavn=$_POST ["etternavn"];
      $klassekode=$_POST ["klassekode"];
	  
	  if (!$brukernavn || !$fornavn || !$etternavn || !$klassekode)
        {
          print ("Brukernavn, fornavn, etternavn og klassekode m&aring; fylles ut");
        }
      else
        {
          include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

          $sqlSetning="SELECT * FROM student WHERE brukernavn='$brukernavn';";
          $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
          $antallRader=mysqli_num_rows($sqlResultat); 

          if ($antallRader==0)  /* poststedet er ikke registrert */
            {
              print ("studenten finnes ikke");
            }
          else
            {	  
              $sqlSetning="DELETE FROM student WHERE brukernavn='$brukernavn';";
              mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; slette data i databasen");
                /* SQL-setning sendt til database-serveren */
		
              print ("F&oslash;lgende student er n&aring; slettet: $brukernavn  <br />");
            }
        }
    }

?> 

