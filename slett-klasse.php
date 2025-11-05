<?php  /* slett-poststed */
/*
/*  Programmet lager et skjema for å velge et poststed som skal slettes  
/*  Programmet sletter det valgte poststedet
*/
?> 

<script src="funksjoner.js"> </script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema" onSubmit="return bekreft()">
  Klassenavn <input type="text" id="klassenavn" name="klassenavn" required /> <br/>
  Studiumkode <input type="text" id="studiumkode" name="studiumkode" required /> <br/>
		<select name="klassekode" id="klassekode">
<?php print("<option value=''>velg klasse </option>");
include("dynamiske-funksjoner.php"); listeboksklasse(); ?>
	</select><br/>
  <input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp" /> 
</form>

<?php
  if (isset($_POST ["slettklasseKnapp"]))
    {	
      $klassekode=$_POST ["klassekode"];
      $klassenavn=$_POST ["klassenavn"];
      $studiumkode=$_POST ["studiumkode"];
	  
	  if (!$klassekode || !$klassenavn || !$studiumkode)
        {
          print ("Klassekode, klassenavn og studiumkode m&aring; fylles ut");
        }
      else
        {
          include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

          $sqlSetning="SELECT * FROM klasse WHERE klassekode='$klassekode';";
          $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
          $antallRader=mysqli_num_rows($sqlResultat); 

          if ($antallRader==0)  /* poststedet er ikke registrert */
            {
              print ("Klassen finnes ikke");
            }
          else
            {	  
              $sqlSetning="DELETE FROM klasse WHERE klassekode='$klassekode';";
              mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; slette data i databasen");
                /* SQL-setning sendt til database-serveren */
		
              print ("F&oslash;lgende klasse er n&aring; slettet: $klassekode  <br />");

				function slettKlasse(string $klassekode, PDO $pdo): array
{
    // 1. Sjekk om klassen har studenter
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM student WHERE klassekode = :klassekode");
    $stmt->execute(['klassekode' => $klassekode]);
    $antallStudenter = (int) $stmt->fetchColumn();

    if ($antallStudenter > 0) {
        return [
            'ok' => false,
            'message' => "Kan ikke slette klassen '$klassekode' fordi den har $antallStudenter student(er)."
        ];
    }

    // 2. Slett klassen
    $delete = $pdo->prepare("DELETE FROM klasse WHERE klassekode = :klassekode");
    $delete->execute(['klassekode' => $klassekode]);

    if ($delete->rowCount() === 0) {
        return [
            'ok' => false,
            'message' => "Fant ingen klasse med klassekode '$klassekode'."
        ];
    }

    return [
        'ok' => true,
        'message' => "Klassen '$klassekode' ble slettet."
    ];
}
            }
        }
    }

?> 




