package com.example.lab2.servlets;

import com.example.lab2.beans.Rows;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

import java.io.IOException;
import java.time.Duration;
import java.time.Instant;
import java.util.ArrayList;

@WebServlet("/area-checker")
public class AreaCheckServlet extends HttpServlet {
    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        var currentDateTime = java.time.LocalDateTime.now().toString();
        var start = Instant.now();

        var params = req.getParameterMap();
        var x = Double.parseDouble(params.get("x")[0]);
        var y = Double.parseDouble(params.get("y")[0]);
        var r = Double.parseDouble(params.get("r")[0]);

        var check = new ArrayList<Integer>();

        if (r <= 0) {
            resp.sendError(HttpServletResponse.SC_BAD_REQUEST, "Wrong arguments");
        }

        if (x <= 0 && y >= 0) check.add(1);
        if (x >= 0 && y >= 0) check.add(2);
        if (x >= 0 && y <= 0) check.add(3);
        if (x <= 0 && y <= 0) check.add(4);

        var inside = "Нет";

        for (var index : check) {
            var figure = params.get("figure" + index)[0];
            var figureR = ("r".equals(params.get("radius" + index)[0])) ? r : r / 2;
            var figureH = ("r".equals(params.get("height" + index)[0])) ? r : r / 2;
            var figureW = ("r".equals(params.get("width" + index)[0])) ? r : r / 2;

            if (checkInsideFigure(figure, figureR, figureH, figureW, x, y, r)) {
                inside = "Да";
                break;
            }
        }

        var executionTime = Duration.between(start, Instant.now()).toMillis() + " ms";

        String row = "<tr>" +
                "<td>" + currentDateTime + "</td>" +
                "<td>" + executionTime + "</td>" +
                "<td>" + r + "</td>" +
                "<td>" + x + "</td>" +
                "<td>" + y + "</td>" +
                "<td>" + inside + "</td>" +
                "</tr>";

        var session = req.getSession();
        var attr = session.getAttribute("result");
        var rows = attr == null ? new Rows() : (Rows)attr;
        rows.setLastRow(row);

        session.setAttribute("result", rows);

        req.getRequestDispatcher("/secured/result.jsp").forward(req, resp);
    }

    private static boolean checkInsideFigure(String figure, double fr, double fh, double fw, double x, double y, double r) {
        switch (figure) {
            case "rectangle":
                return Math.abs(x) <= fw && Math.abs(y) <= fh;
            case "circle":
                return x * x + y * y <= fr * fr;
            case "rhombus":
                return Math.abs(x) / (Math.abs(fw) / r) + Math.abs(y) / (Math.abs(fh) / r) <= r;
            default:
                return false;
        }
    }

}
