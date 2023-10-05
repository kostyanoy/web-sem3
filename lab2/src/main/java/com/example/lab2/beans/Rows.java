package com.example.lab2.beans;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class Rows implements Serializable {
    private List<List<String>> allRows = new ArrayList<>();
    private List<String> lastRow = new ArrayList<>();

    public String getAllRows() {
        StringBuilder rows = new StringBuilder("");
        for (List<String> row : allRows) {
            rows.append("<tr>");
            for (String value : row) {
                rows.append("<td>").append(value).append("</td>");
            }
            rows.append("</tr>");
        }
        return rows.toString();
    }

    public void setAllRows(List<List<String>> allRows) {
        this.allRows = allRows;
    }

    public String getLastRow() {
        StringBuilder row = new StringBuilder("");
        row.append("<tr>");
        for (String value : lastRow) {
            row.append("<td>").append(value).append("</td>");
        }
        row.append("</tr>");
        
        return row.toString();
    }

    public void setLastRow(String ..._lastRow) {
        var list = new ArrayList<>(Arrays.asList(_lastRow));
        allRows.add(list);
        lastRow = list;
    }
}
