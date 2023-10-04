<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Result</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>
<body>
<% if (request.getSession().getAttribute("result") != null) { %>
<table id="response-table">
    <thead>
    <tr>
        <th>Время запроса</th>
        <th>Время ответа (ns)</th>
        <th>Радиус</th>
        <th>X</th>
        <th>Y</th>
        <th>Внутри?</th>
    </tr>
    </thead>
    ${result.lastRow}
</table>
<% } %>
<center>
<a href="app">Вернуться</a>
</center>
</body>
</html>
