package com.example.lab2.servlets;

import jakarta.servlet.RequestDispatcher;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

import java.io.IOException;
import java.util.List;

import com.example.lab2.beans.Rows;

@WebServlet("/app")
public class ControllerServlet extends HttpServlet {
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        RequestDispatcher dispatcher = req.getRequestDispatcher("/WEB-INF/form.jsp");
        var params = req.getParameterMap().keySet();

        if (params.contains("init")){
            var session = req.getSession();
            var attr = session.getAttribute("result");
            var rows = attr == null ? new Rows() : (Rows)attr;
            session.setAttribute("result", rows);
            return;
        }

        if (params.containsAll(List.of("x", "y", "r"))) {
            dispatcher = req.getRequestDispatcher("/area-checker");
        }
        dispatcher.forward(req, resp);
    }
}
