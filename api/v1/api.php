<?php
/*
    RESTful API interface
    Input:  $_GET['request']
    Output: A formatted JSON response
    Adapted from work by Mark Roland  http://markroland.com/blog/restful-php-api/
*/

/**
 * Deliver HTTP Response
 * @param string $api_response The desired HTTP response data
 * @return void
 **/
function deliver_response($api_response){

    // Define HTTP responses
    $http_response_code = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found'
    );

    // Set HTTP Response
    header('HTTP/1.1 '.$api_response['status'].' '.$http_response_code[ $api_response['status'] ]);

    // Set HTTP Response Content Type
    header('Content-Type: application/json; charset=utf-8');

    // Format data into a JSON response
    $json_response = json_encode($api_response);

    // Deliver formatted data
    echo $json_response;

    // End script process
    exit;

}
// --- Step 1: Initialize
// entry point

// Define whether an HTTPS connection is required
$HTTPS_required = FALSE;

// Define whether user authentication is required
$authentication_required = FALSE;

// Define API response codes and their related HTTP response
$api_response_code = array(
    0 => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
    1 => array('HTTP Response' => 200, 'Message' => 'Success'),
    2 => array('HTTP Response' => 403, 'Message' => 'HTTPS Required'),
    3 => array('HTTP Response' => 401, 'Message' => 'Authentication Required'),
    4 => array('HTTP Response' => 401, 'Message' => 'Authentication Failed'),
    5 => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
    6 => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format')
);

// Set default HTTP response

$response['status'] = 404;
$response['data'] = NULL;

// --- Step 2: Authorization

// Optionally require connections to be made via HTTPS
if( $HTTPS_required && $_SERVER['HTTPS'] != 'on' ){

    $response['status'] = 403;
    $response['data'] = 'HTTPS Required';

    // Return Response to browser. This will exit the script.
    deliver_response($response);
}

// Optionally require user authentication
if( $authentication_required ){

    if( empty($_POST['username']) || empty($_POST['password']) ){

        $response['status'] = 401;
        $response['data'] = 'Authentication Required';

        // Return Response to browser
        deliver_response($response);
    }

    // Return an error response if user fails authentication. This is a very simplistic example
    // that should be modified for security in a production environment
    elseif( $_POST['username'] != 'foo' && $_POST['password'] != 'bar' ){

        $response['status'] = 401;
        $response['data'] = 'Authentication Failed';

        // Return Response to browser
        deliver_response($response);
    }
}

// --- Step 3: Process Request

$request = $_GET['request'];
$args = explode('/', rtrim($request, '/'));

if ($args[0] == 'tags') {

    require('../../db_con.php');

    $queryAllTags = "SELECT DISTINCT Tag FROM UserSiteTag WHERE UserID ='$args[1]' AND Tag LIKE '$args[2]%'";

    $result9 = mysql_query($queryAllTags) or die (mysql_error()."<br />Couldn't execute query: $queryAllTags");
    $num_result9 = mysql_num_rows($result9);

    for ($i=0; $i <$num_result9; $i++) {
        $row9 = mysql_fetch_array($result9);

        $tags_data[] = $row9['Tag'];
    }
    $response['status'] = 200;
    $response['data'] = $tags_data;
}

// --- Step 4: Deliver Response

// Return Response to browser
deliver_response($response);

?>
