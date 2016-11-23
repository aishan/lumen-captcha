<?php

namespace Aishan\LumenCaptcha;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

/**
 * Class CaptchaController
 * @package Mews\Captcha
 */
class LumenCaptchaController extends Controller
{

   /* /**
     * get CAPTCHA
     *
     * @param \Aishan\LumenCaptcha\CaptchaService $captcha
     * @param string $config
     * @return \Intervention\Image\ImageManager->response
     */
    /**
     * get CAPTCHA
     * @param Captcha $captcha
     * @param string $type
     * @param $captchaId
     * @return \Intervention\Image\ImageManager
     */
    public function getCaptcha(Captcha $captcha, $type = 'default',$captchaId)
    {
        return $captcha->createById($type,$captchaId);
    }

    /**
     * get CAPTCHA getCaptchaInfo API
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCaptchaInfo(Request $request,$type = 'default')
    {
        $urlDomain = substr(str_replace($request->decodedPath(),'',$request->url()),0,-1);
        $captchaUuid = $this->generate_uuid();
        $captchaData = [
            'captchaUrl'=>$urlDomain.'/captcha/'.$type.'/'.$captchaUuid,
            'captchaUuid'=>(string)$captchaUuid
        ];
        return makeSuccessMsg($captchaData);
    }

    /**
     * 生成UUID
     * @return string
     */
    function generate_uuid(){
        $charId = md5(uniqid(rand(), true));
        $hyphen = chr(45);// "-"
        $uuid = substr($charId, 0, 8).$hyphen
            .substr($charId, 8, 4).$hyphen
            .substr($charId,12, 4).$hyphen
            .substr($charId,16, 4).$hyphen
            .substr($charId,20,12);
        return $uuid;
    }
}
