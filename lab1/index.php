<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Web Lab</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="assets/css/collapsible.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>

    </style>
</head>
<body>

<?php include_once 'includes/header.php'; ?>
<main>
    <h1>Лабораторная работа #1</h1>
    <form id="point-form" method="POST">
        <button class="collapsible">Выбор рисунка</button>
        <div class="content">
            <div class="grid-container">
                <?php
                $numbers = [1, 2, 4, 3];
                foreach ($numbers as $i) {
                    ?>
                    <div class="item">
                        <select class="figure redraw" name="figure<?php echo $i ?>" id="figure<?php echo $i ?>">
                            <option value="nothing">Ничего</option>
                            <option value="rectangle">Прямоугольник</option>
                            <option value="circle">Круг</option>
                            <option value="rhombus">Ромб</option>
                        </select>
                        <div class="item-option">
                            <label for="radius<?php echo $i ?>">Радиус:</label>
                            <select class="combobox redraw" name="radius<?php echo $i ?>" id="radius<?php echo $i ?>">
                                <option value="r/2">R / 2</option>
                                <option value="r">R</option>
                            </select>
                        </div>
                        <div class="item-option">
                            <label for="height<?php echo $i ?>">Высота:</label>
                            <select class="combobox redraw" name="height<?php echo $i ?>" id="height<?php echo $i ?>">
                                <option value="r/2">R / 2</option>
                                <option value="r">R</option>
                            </select>
                        </div>
                        <div class="item-option">
                            <label for="width<?php echo $i ?>">Ширина:</label>
                            <select class="combobox redraw" name="width<?php echo $i ?>" id="width<?php echo $i ?>">
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

        <div class="point-options">
            <div class="point-option">
                <label for="x">X: </label>
                <input type="number" name="x" id="x" required>
            </div>
            <div class="point-option">
                <label for="y">Y: </label>
                <input type="number" name="y" id="y" required>
            </div>
            <div class="point-option">
                <label for="r">R: </label>
                <input type="number" name="r" id="r" required>
            </div>
            <input type="submit" value="Отправить">
        </div>
    </form>

    <table id="response">
        <thead>
        <tr>
            <th>Время запроса</th>
            <th>Время ответа (ms)</th>
            <th>Радиус</th>
            <th>X</th>
            <th>Y</th>
            <th>Внутри?</th>
        </tr>
        </thead>
    </table>
</main>

<script src="assets/js/canvas.js"></script>
<script src="assets/js/collapsible.js"></script>
<script src="assets/js/send.js"></script>


<?php include_once 'includes/footer.php'; ?>

</body>
</html>