<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Creator</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <script src="./js/script.js"></script>
</head>

<body>
    <form action="./PDF/pdf_creator.php" method="post">
        <h2>Výpočet čisté mzdy</h2>
        <div>
            <label for="gross_salary"><span style="visibility: visible;">* </span>Hrubá mzda:</label>
            <input type="text" inputmode="numeric" id="gross_salary" name="gross_salary" required>
            <span>&nbsp;Neplatný vstup! Můžete zadávat pouze čísla.</span>
        </div>
        <br>
        <div>
            <label for="children">Počet dětí, na které je uplaňovaná sleva na dani:</label>
            <input type="text" inputmode="numeric" id="children" name="children">
            <span>&nbsp;Neplatný vstup! Můžete zadávat pouze čísla.</span>
        </div>
        <br>
        <div>
            <label for="ztpchildren">Z toho počet dětí s průkazem ZTP/P: <sup title="Počítáme s tím, že děti s ZTP/P průkazem byli zapsány na pozdější místa.">[ i ]</sup></label>
            <input type="text" inputmode="numeric" id="ztpchildren" name="ztpchildren">
            <span>&nbsp;Neplatný vstup! Můžete zadávat pouze čísla.</span>
        </div>
        <br>
        <div class="checkbox">
            <label for="taxdiscount" style="display: inline-block;">Uplatnit slevu na poplatníka:</label>
            <input type="checkbox" name="taxdiscount" id="taxdiscount">
        </div>
        <div class="checkbox">
            <label for="disability1or2" style="display: inline-block;">Invalidní důchod 1. nebo 2. stupně:</label>
            <input type="checkbox" name="disability1or2" id="disability1or2">
        </div>
        <div class="checkbox">
            <label for="disability3" style="display: inline-block;">Invalidní důchod 3. stupně:</label>
            <input type="checkbox" name="disability3" id="disability3">
        </div>
        <div class="checkbox">
            <label for="ztpcard" style="display: inline-block;">Držitel průkazu ZTP/P (rodič):</label>
            <input type="checkbox" name="ztpcard" id="ztpcard">
        </div>
        <br>
        <button type="submit">Vypočítat</button>
        <span style="visibility: visible;">* = povinný údaj</span>
    </form>
</body>

</html>