<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="results.php" method="post">

<?php
    require_once('Domanda.php');
    echo "<h1>" . substr($_POST["file"], 5) . "</h1>\n";
    $file = file($_POST["file"]);


    $quiz = null;
    foreach ($file as $line){ // solo successivamente ho pensato che si potesse adattare l'interità di questo blocco di codice nel costruttore
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

    $i = 0; // numero domanda
    foreach ($quiz as $domanda){
        $arrayStringheRisposte = array();
        $j = 0; //numero risposta
        echo "<hr><h3>" . $domanda->getdomanda() . "</h3>\n";
        foreach ($domanda->getrisposte() as $risposta){
            $arrayStringheRisposte[] .= '<input type="checkbox" id="d' . $i . "r" . $j . '" name="d' . $i . "r" . $j . '"><label for="d' . $i . "r" . $j . '">' . $risposta . "</label>\n";
            $j++;
        }
        shuffle($arrayStringheRisposte);
        foreach($arrayStringheRisposte as $risposta){
            echo $risposta;
        }
        $i++;
    }
    echo '<hr><button type="submit" name="quiz" value="' . $_POST["file"] . '">Controlla il risultato del quiz</button>' . "\n";
?>

</form>

</body>
</html>