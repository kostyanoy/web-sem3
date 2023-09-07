<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8" %>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Web Lab</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/collapsible.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>

    </style>
</head>
<body>

<%@include file="includes/header.jsp" %>
<main>
    <h1>Лабораторная работа #1</h1>
    <form id="point-form" method="POST" action="/app">
        <button class="collapsible">Выбор рисунка</button>
        <div class="content">
            <div class="grid-container">
                <%
                    int[] numbers = {1, 2, 4, 3};
                    for (int i : numbers) {
                %>
                <div class="item">
                    <select class="figure redraw" name="figure<%=i%>" id="figure<%=i%>">
                        <option value="nothing">Ничего</option>
                        <option value="rectangle">Прямоугольник</option>
                        <option value="circle">Круг</option>
                        <option value="rhombus">Ромб</option>
                    </select>
                    <div class="item-option">
                        <label for="radius<%=i%>">Радиус:</label>
                        <select class="combobox redraw" name="radius<%=i%>" id="radius<%=i%>">
                            <option value="r/2">R / 2</option>
                            <option value="r">R</option>
                        </select>
                    </div>
                    <div class="item-option">
                        <label for="height<%=i%>">Высота:</label>
                        <select class="combobox redraw" name="height<%=i%>" id="height<%=i%>">
                            <option value="r/2">R / 2</option>
                            <option value="r">R</option>
                        </select>
                    </div>
                    <div class="item-option">
                        <label for="width<%=i%>">Ширина:</label>
                        <select class="combobox redraw" name="width<%=i%>" id="width<%=i%>">
                            <option value="r/2">R / 2</option>
                            <option value="r">R</option>
                        </select>
                    </div>
                </div>
                <% } %>
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

    <% if (request.getSession().getAttribute("result") != null) { %>
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
        ${result.allRows}
    </table>
    <% } %>
</main>

<script src="assets/js/canvas.js"></script>
<script src="assets/js/collapsible.js"></script>

<%@include file="includes/footer.jsp" %>

</body>
</html>