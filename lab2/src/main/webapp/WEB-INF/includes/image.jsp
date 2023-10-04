<%@ page contentType="text/html;charset=UTF-8" language="java" %>

<div class="collapsible">Выбор рисунка</div>
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