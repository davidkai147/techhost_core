<?php

namespace App\Services;

class BaseService {

    private $responseService;

    /**
     * BaseService constructor.
     */
    public function __construct()
    {
        $this->responseService = new ResponseService();
    }

    public function per_page()
    {
        return !empty(request()->input('per_page')) ? request()->input('per_page') : 9999;
    }

    public function setCookie($access_token, $name = 'access_token', $minute  = 43200, $httOnly = false)
    {
        return cookie(
            $name,
            $access_token,
            $minute,
            null,
            null,
            false,
            $httOnly);
    }

    public function renderNotfound()
    {
        return $this->responseService->json('該当するレコードが見つかりません!',404, 404);
    }
}
