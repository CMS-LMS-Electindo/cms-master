<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

/**
 * Format response.
 */
class Response
{
    /**
     * API Response
     *
     * @var array
     */
    public const TokenLMS = '6a2a623594e388b348277f12d8a77be2';
    public const TokenLMSAdmin = '355bd52d8188b98c2216e8523481af80';
    public const TokenLMSAuth = '4faa1c732f21754873e7d972783a79c9';
    
    public const DomainLMS = 'https://lms.electindo.com';
    public const DomainSIA = 'http://apisia.unm.ac.id';
    public const HeaderSIA = 'cms-apisia-4b72926408f7ggfa93946';
    public const AppSIA = 'cms-lms';

    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
    ];

    /**
     * Give success response.
     */
    public static function success($data = null, $message = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    /**
     * Give error response.
     */
    public static function error($data = null, $message = null, $code = 400)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }
    public static function encrypt($value){
        
        $return = Crypt::encryptString($value);
        return $return;
    }
    public static function decrypt($value){
        
        $return = Crypt::decryptString($value);
        return $return;
    }
}
