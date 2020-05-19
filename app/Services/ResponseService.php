<?php

namespace App\Services;

class ResponseService {

    /**
     * AuthService constructor.
     */
    public function __construct()
    {

    }

    public function json($msg = null, $code = null, $status = 200, $data = null, $extends = null)
    {
        $json = [
            'message' => $msg,
            'code' => $code,
        ];

        // add attribute data into json object
        if (!empty($data)) $json['data'] = $data;

        // replace and update data extends into json object
        if (!empty($extends)) $json = array_merge($extends, $json);

        return response($json, $status);
    }

    public function response($message = '', $data = [], $code = 200, $extends = [])
    {
        $json = [
            'message' => $message,
            'data' => $data,
            'code' => $code
        ];

        if (!empty($extends)) $json = array_merge($extends, $json);

        return response()->json($json);
    }

    public function unauthenticated()
    {
        $data = [
            'message' => 'この機能にアクセスするにはログインする必要があります！',
            'code' => 1000
        ];
        return response()->json($data, 401);
    }

    public function render_not_allow_access()
    {
        $data = [
            'message' => 'このページへのアクセス不可! ',
            'code' => 2000
        ];
        return response()->json($data, 405);
    }

    public function errors($messages, $msg = null)
    {
        $json = [
            'errors' => [],
            'code' => 400
        ];
        foreach ($messages as $message) {
            $json['errors'] = $message;
        }

        if (!empty($msg)) $json['message'] = $msg;

        return response()->json($json, 400);
    }
}
