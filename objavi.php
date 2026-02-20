<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objavi voznju</title>
</head>
<body>
    <h1>Objavi voznju</h1>
    <form method="POST" action="">
        <div>
            <label for="polaziste">Polaziste:</label>
            <input type="text" id="polaziste" name="polaziste" required>
        </div>
        <div>
            <label for="odrediste">Odrediste:</label>
            <input type="text" id="odrediste" name="odrediste" required>
        </div>
        <div>
            <label for="vreme_polaska">Vreme polaska:</label>
            <input type="datetime-local" id="vreme_polaska" name="vreme_polaska" required>
        </div>
        <div>
            <label for="slobodna_mesta">Slobodna mesta:</label>
            <input type="number" id="slobodna_mesta" name="slobodna_mesta" min="1" required>
        </div>
        <div>
            <label for="cena">Cena:</label>
            <input type="number" id="cena" name="cena" step="0.01" min="0" required>
        </div>
        <div>
            <label for="opis">Opis:</label>
            <textarea id="opis" name="opis" rows="5" cols="50"></textarea>
        </div>
        <button type="submit">Objavi voznju</button>
    </form>
</body>
</html>