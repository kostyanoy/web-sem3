<%@ page contentType="text/html;charset=UTF-8" language="java" %>
   
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
    ${result.allRows}
</table>
<% } %>