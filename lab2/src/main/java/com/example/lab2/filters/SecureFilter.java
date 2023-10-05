package com.example.lab2.filters;

import jakarta.servlet.*;
import jakarta.servlet.annotation.WebFilter;
// import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

import java.io.IOException;

@WebFilter("/area-checker")
public class SecureFilter implements Filter {
    @Override
    public void doFilter(ServletRequest request, ServletResponse response, FilterChain chain) throws IOException, ServletException {
        // HttpServletRequest httpRequest = (HttpServletRequest) request;
        HttpServletResponse httpResponse = (HttpServletResponse) response;
    //    if (isAllowed(httpRequest)) {
    //        chain.doFilter(request, response);
    //    } else {
            httpResponse.sendError(HttpServletResponse.SC_FORBIDDEN, "Access denied");
    //    }
    }

//    private boolean isAllowed(HttpServletRequest httpRequest) {
//        return "ControllerServlet".equals(httpRequest.getHeader("Referer"));
//    }
}
