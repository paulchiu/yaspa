<?php

namespace Yaspa\Constants;

use GuzzleHttp\RequestOptions;

/**
 * Class RequestBuilder
 *
 * @package Yaspa\Constants
 *
 * Constants shared by request builder classes.
 */
class RequestBuilder
{
    const JSON_HEADERS = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];
    const ACCEPT_JSON_HEADERS = ['Accept' => 'application/json'];
    const GET_HTTP_METHOD = 'GET';
    const POST_HTTP_METHOD = 'POST';
    const PUT_HTTP_METHOD = 'PUT';
    const DELETE_HTTP_METHOD = 'DELETE';
    const JSON_BODY_TYPE = RequestOptions::JSON;
    const QUERY_BODY_TYPE = RequestOptions::QUERY;
    const MULTIPART_BODY_TYPE = RequestOptions::MULTIPART;
    const STARTING_PAGE = 1;
}
