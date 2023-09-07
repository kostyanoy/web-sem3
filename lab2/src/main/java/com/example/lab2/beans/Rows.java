package com.example.lab2.beans;

import java.io.Serializable;

public class Rows implements Serializable {
    private String lastRow;
    private String allRows;

    public String getAllRows() {
        return allRows;
    }

    public void setAllRows(String allRows) {
        this.allRows = allRows;
    }

    public String getLastRow() {
        return lastRow;
    }

    public void setLastRow(String lastRow) {
        this.lastRow = lastRow;
        this.allRows = this.allRows == null ? lastRow : this.allRows + lastRow;
    }
}
