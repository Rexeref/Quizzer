<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Quizzer</title>
</head>
<body>

<?php
    // ?d0r0=on&d1r0=on&d2r2=on&d3r0=on&d4r1=on&quiz=example.txt
    require_once('Domanda.php');
    echo "<h1>" . substr($_POST["quiz"], 5) . "</h1>\n";
    $file = file($_POST["quiz"]);

    $quiz = null;
    foreach ($file as $line){
        if(trim($line) !== ''){
            if(!strpos($line, "\\\\")){ // è una domanda (controllo se la sottostringa "\\\\" è presente)
                $quiz[Domanda::$counterDomande + 1] = new Domanda(trim($line));
            }
            else { // è una risposta
                $quiz[Domanda::$counterDomande]->addrisposta(trim(explode("\\\\", $line)[0]));
                $quiz[Domanda::$counterDomande]->addveridicitarisposta(filter_var(trim(explode("\\\\", $line)[2]), FILTER_VALIDATE_BOOLEAN));
            }
        }
    }

    //controllo il risultato
    $i = 0; // contatore domande
    $puntiMassimi = 0; $puntiFatti = 0;
    foreach ($quiz as $domanda){
        $correzione = array();
        $j = 0;$flagTuttoGiusto = true;$puntiFattiNellaDomanda = 0; // contatore risposte
        foreach ($domanda->getveridicitarisposte() as $risposta){
			@$magicKey = $_POST["d".$i."r".$j]; // La chiocciola serve per sopprimere i warning, non capisco perché ci siano visto che funziona come voluto
            if ($risposta){
                $puntiMassimi += 1;
            }
            if($magicKey == "on" && $risposta){ // giusto
                $correzione[] = 3;$puntiFattiNellaDomanda += 1;
            }
            else if($magicKey == "on" && !$risposta) { // errore
                $correzione[] = 2;$flagTuttoGiusto = false;
            }
            else if($risposta && $magicKey !== "on"){ // missed
                $correzione[] = 1;$flagTuttoGiusto = false;
            }
            else { // neutrale
                $correzione[] = 0;
            }
            $j++;
        }
        $puntiFatti += $flagTuttoGiusto ? $puntiFattiNellaDomanda : 0;
        $j = 0;
        // mostro il risultato
        $mostraCorrezioneDomanda = $flagTuttoGiusto ? " è giusta! Un punto in più!" : " è sbagliata . . . Niente punti . . .";
        echo "<hr><h3>" . '"' . $domanda->getdomanda() . '"' . $mostraCorrezioneDomanda . "</h3>\n";
        foreach ($domanda->getrisposte() as $risposta){
            switch($correzione[$j]){
                case 3:
                    echo "<p class='giusto' >■ " . $risposta . " ✓</p>\n";
                    break;
                case 2:
                    echo "<p class='sbagliato' >■ " . $risposta . " </p>\n";
                    break;
                case 1:
                    echo "<p class='mancato' >□ " . $risposta . " </p>\n";
                    break;
                default:
                    echo "<p>□ " . $risposta . "</p>\n";
                    break;
            }
            $j++;
        }
        $i++;
    }
    $finalResult = $puntiFatti / $puntiMassimi * 10 > 0 ? round($puntiFatti / $puntiMassimi * 10, 2) : 0;
    echo "<hr><h1>Voto: " . $finalResult . "</h1> <h2>" . $puntiFatti . "/" . $puntiMassimi . "</h2>";

?>

</body>
</html>
