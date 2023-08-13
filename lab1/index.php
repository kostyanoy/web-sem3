<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Web Lab</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="assets/css/collapsible.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

    </style>
</head>
<body>

<?php include_once 'includes/header.php'; ?>
<main>
    <h1>Лабораторная работа #1</h1>
    <button class="collapsible">Выбор рисунка</button>
    <div class="content">
        <div class="grid-container">
            <?php
            for ($i = 1; $i <= 4; $i++) {
                ?>
                <div class="item">
                    <select class="figure" id="figure<?php echo $i ?>">
                        <option value="square">Квадрат</option>
                        <option value="circle">Круг</option>
                        <option value="rhombus">Ромб</option>
                    </select>
                    <div class="option">
                        <label for="radius<?php echo $i ?>">Radius:</label>
                        <select class="combobox" id="radius<?php echo $i ?>">
                            <option value="r/2">R / 2</option>
                            <option value="r">R</option>
                        </select>
                    </div>
                    <div class="option">
                        <label for="height<?php echo $i ?>">Height:</label>
                        <select class="combobox" id="height<?php echo $i ?>">
                            <option value="r/2">R / 2</option>
                            <option value="r">R</option>
                        </select>
                    </div>
                    <div class="option">
                        <label for="width<?php echo $i ?>">Width:</label>
                        <select class="combobox" id="width<?php echo $i ?>">
                            <option value="r/2">R / 2</option>
                            <option value="r">R</option>
                        </select>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


    <div class="canvas-container">
        <canvas id="myCanvas" width="400" height="400"></canvas>
    </div>
</main>

<script src="assets/js/canvas.js"></script>
<script src="assets/js/collapsible.js"></script>

<?php include_once 'includes/footer.php'; ?>

</body>
</html>