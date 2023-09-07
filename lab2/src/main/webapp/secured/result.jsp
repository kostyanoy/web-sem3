<%--
  Created by IntelliJ IDEA.
  User: Konstantin
  Date: 24.08.2023
  Time: 19:44
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Result</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
</head>
<body>
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
    ${result.lastRow}
</table>
<% } %>
<a href="app">Вернуться</a>
</body>
</html>
