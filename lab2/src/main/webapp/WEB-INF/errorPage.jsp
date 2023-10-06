<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page isErrorPage = "true" %>
<html>
<head>
    <title>Result</title>
    <link rel="stylesheet" type="text/css" href="assets/css/errorPage.css">
</head>
<body>
    <h1>Error Page</h1>
    <p>Error code: <%= response.getStatus() %></p>

    <% if (response.getStatus() == 403) { %>
    <p>You are not allowed to access this resource.</p>
    <% } else if (response.getStatus() == 404) { %>
    <p>The requested resource was not found.</p>
    <% } else if (response.getStatus() == 500) { %>
    <p>An internal server error occurred.</p>
    <% } else { %>
    <p>An unknown error occurred.</p>
    <% } %>
<center>
<a href="app">Вернуться</a>
</center>
</body>
</html>
