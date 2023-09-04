package com.example.crud_java.helpers;

public class ApiResponse {
    private boolean error;
    private String traceCode;
    private String message;
    private Object data;

    public ApiResponse(boolean error, String traceCode, String message, Object data) {
        this.error = error;
        this.traceCode = traceCode;
        this.message = message;
        this.data = data;
    }

    public boolean isError() {
        return error;
    }

    public void setError(boolean error) {
        this.error = error;
    }

    public String getTraceCode() {
        return traceCode;
    }

    public void setTraceCode(String traceCode) {
        this.traceCode = traceCode;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public Object getData() {
        return data;
    }

    public void setData(Object data) {
        this.data = data;
    }
}
