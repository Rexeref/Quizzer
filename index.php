<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizzer</title>
</head>
<body>

<h1>Quizzer</h1>
<p>Scegli il file:</p>
<form action="test.php" method="post">
    <label>
        <select name="file">
<?php // Bello 'sto metodo per mettere in una lista di tipo select i file, eh?
foreach (glob("quiz/*") as $filename) {
    echo "<option value='" . $filename . "'>" . $filename . "</option>";
}
?>
        </select>
    </label>
    <button type="submit">Avvia il quiz</button>
</form>

</body>
</html>