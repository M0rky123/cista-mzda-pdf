<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Creator</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js"></script>
</head>

<body>
    <form action="./PDF/pdf_creator.php" method="post">
        <h2>Výpočet čisté mzdy</h2>
        <div class="formwrapper">
            <label for="gross_salary">Hrubá mzda:</label>
            <input type="text" inputmode="numeric" id="gross_salary" name="gross_salary" required>
            <span>&nbsp;Neplatný vstup! Můžete zadávat pouze čísla.</span>
        </div>
        <br>
        <div class="formwrapper">
            <label for="children">Počet dětí:</label>
            <input type="text" inputmode="numeric" id="children" name="children" required>
            <span>&nbsp;Neplatný vstup! Můžete zadávat pouze čísla.</span>
        </div>
        <br>
        <button type="submit">Vypočítat</button>
    </form>
</body>

</html>