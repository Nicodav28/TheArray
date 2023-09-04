package com.example.crud_java.helpers;

import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;

// ...
public class HandleResponse {
    public static ResponseEntity<Object> success(String traceCode, Object data, String message, HttpStatus httpStatus) {
        ApiResponse response = new ApiResponse(false, traceCode, message, data);
        return new ResponseEntity<>(response, httpStatus);
    }

    public static ResponseEntity<Object> error(String traceCode, String message, HttpStatus httpStatus) {
        ApiResponse response = new ApiResponse(true, traceCode, message, null);
        return new ResponseEntity<>(response, httpStatus);
    }
}
