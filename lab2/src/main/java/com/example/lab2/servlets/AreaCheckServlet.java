package com.example.lab2.servlets;

import com.example.lab2.beans.Rows;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

import java.io.IOException;
import java.time.ZoneOffset;
import java.time.ZonedDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.Map;

@WebServlet("/area-checker")
public class AreaCheckServlet extends HttpServlet {
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        var start = System.nanoTime(); // start timer

        var params = req.getParameterMap();
        
        // validate params
        var x = tryParseDoubleOrNull(params.get("x")[0]);
        var y = tryParseDoubleOrNull(params.get("y")[0]);
        var r = tryParseDoubleOrNull(params.get("r")[0]);
        
        if (x == null || y == null || r == null || r <= 0) {
            resp.sendError(HttpServletResponse.SC_BAD_REQUEST, String.format("Wrong arguments: x=%s, y=%s, r=%s", x, y, r));
            return;
        }
        
        // get timezone offset
        var timezoneOffsetMinutes = tryParseIntOrNull(params.getOrDefault("timezoneOffsetMinutes", new String[] {"0"})[0]);
        if (timezoneOffsetMinutes == null){
            timezoneOffsetMinutes = 0;
        }
        var formattedDateTime = getCurrentTime(timezoneOffsetMinutes);

        var check = new ArrayList<Integer>();
        if (x <= 0 && y >= 0) check.add(1);
        if (x >= 0 && y >= 0) check.add(2);
        if (x >= 0 && y <= 0) check.add(3);
        if (x <= 0 && y <= 0) check.add(4);

        var inside = "Нет";

        // process point and figure
        for (var index : check) {
            var figure = getStringParam(params, "figure" + index);
            var figureR = ("r".equals(getStringParam(params, "radius" + index))) ? r : r / 2;
            var figureH = ("r".equals(getStringParam(params, "height" + index))) ? r : r / 2;
            var figureW = ("r".equals(getStringParam(params, "width" + index))) ? r : r / 2;

            if (checkInsideFigure(figure, figureR, figureH, figureW, x, y, r)) {
                inside = "Да";
                break;
            }
        }

        if (getStringParam(params, "clickHandle") != ""){
            resp.setContentType("text/plain;charset=UTF-8");
            resp.getWriter().println(inside == "Да");
            return;
        }

        var executionTime = (System.nanoTime() - start);

        // storage 
        var session = req.getSession();
        var attr = session.getAttribute("result");
        var rows = attr == null ? new Rows() : (Rows)attr;
        rows.setLastRow(formattedDateTime, ""+executionTime, ""+r, ""+x, ""+y, inside);

        session.setAttribute("result", rows);

        req.getRequestDispatcher("/WEB-INF/result.jsp").forward(req, resp); 
    }
    
    // process point and figure
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
    // try to parse double from parameters
    private Double tryParseDoubleOrNull(String str) {
        try {
            var x = Double.parseDouble(str);
            return x;
        } catch (NumberFormatException e) {
            return null;
        }
    }

    // try to parse int from parameters
    private Integer tryParseIntOrNull(String str) {
        try {
            var x = Integer.parseInt(str);
            return x;
        } catch (NumberFormatException e) {
            return null;
        }
    }

    // get current time with offset
    private String getCurrentTime(int offsetMinutes) {
        ZonedDateTime currentTime = ZonedDateTime.now(ZoneOffset.UTC)
        .plusMinutes(offsetMinutes);

        // Format the time as 'yyyy-MM-dd HH:mm:ss'
        String formattedTime = currentTime.format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss"));
        return formattedTime;
    }
    // try to get string param
    private String getStringParam(Map<String, String[]> params, String name){
        if (params.get(name) == null) return "";
        return params.get(name)[0];
    }

}
