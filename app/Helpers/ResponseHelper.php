<?php

//suscces

function ok($data = null, $message = 'Success', $code = 200)
{
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $data
    ], $code);
}

function created($data = null, $message = 'Created successfully')
{
    return ok($data, $message, 201);
}

function updated($data = null, $message = 'Updated successfully')
{
    return ok($data, $message, 200);
}

function deleted($message = 'Deleted successfully')
{
    return response()->json([
        'success' => true,
        'message' => $message
    ], 200);
}

function noContent()
{
    return response()->json(null, 204);
}

//eror

function fail($message = 'Error', $code = 400, $error = null)
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'error' => $error
    ], $code);
}

function badRequest($message = 'Bad Request', $error = null)
{
    return fail($message, 400, $error);
}

function unauthorized($message = 'Unauthorized')
{
    return fail($message, 401);
}

function forbidden($message = 'Forbidden')
{
    return fail($message, 403);
}

function notFound($message = 'Not Found')
{
    return fail($message, 404);
}

function conflict($message = 'Conflict')
{
    return fail($message, 409);
}

function validationError($errors = null, $message = 'Validation Error')
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'errors' => $errors
    ], 422);
}

function serverError($message = 'Internal Server Error', $error = null)
{
    return fail($message, 500, $error);
}