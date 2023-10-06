<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8" %>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Web Lab</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="assets/css/collapsible.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<%@include file="includes/header.jsp" %>
<main>
    <h1>Лабораторная работа #2</h1>
    <form id="point-form" method="GET" action="app">
        <%@include file="includes/image.jsp" %>

        <div class="canvas-container">
            <canvas id="myCanvas" width="400" height="400"></canvas>
        </div>

        <div class="point-options">
            <div class="point-option">
                <label for="x">X: </label>
                <%
                    // Generate checkboxes for values from -2 to 2
                    for (double x = -2; x <= 2; x+=0.5) { 
                %>
                    <input type="checkbox" name="x" class="x-checkbox" value="<%=x%>"><%=x%> 
                <% } %>
            </div>
            <div class="point-option">
                <label for="y">Y: </label>
                <input type="number" name="y" id="y" min="-3" max="5" maxlength="3" required>
            </div>
            <div class="point-option">
                <label for="r">R: </label>
                <%
                    // Generate checkboxes for values from -2 to 2
                    for (double r = 1; r <= 3; r+=0.5) { 
                %>
                    <input type="checkbox" name="r" class="r-checkbox" value="<%=r%>"><%=r%> 
                <% } %>
                <%-- <input type="hidden" name="x" id="x" required>
                <input type="hidden" name="r" id="r" required> --%>
            </div>
            <input id="time-offset" type="hidden" name="timezoneOffsetMinutes">
            <input type="submit" value="Отправить">
        </div>
    </form>

    <%@include file="includes/table.jsp" %>
</main>

<script src="assets/js/canvas.js"></script>
<script src="assets/js/collapsible.js"></script>
<script src="assets/js/send.js"></script>

<%@include file="includes/footer.jsp" %>

</body>
</html>