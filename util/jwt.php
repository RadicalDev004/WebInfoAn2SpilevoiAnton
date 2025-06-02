<?php
class JWT {
    
    public static $secret = 'my_super_secret_key';
    
    public static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function base64UrlDecode($data) {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public static function create($payload, $alg = 'HS256') {
        $header = ['alg' => $alg, 'typ' => 'JWT'];
        $headerEncoded = self::base64UrlEncode(json_encode($header));
        $payloadEncoded = self::base64UrlEncode(json_encode($payload));
        $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", self::$secret, true);
        $signatureEncoded = self::base64UrlEncode($signature);
        return "$headerEncoded.$payloadEncoded.$signatureEncoded";
    }

    public static function verify($jwt) {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) return false;
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = $parts;
        $validSignature = self::base64UrlEncode(hash_hmac('sha256', "$headerEncoded.$payloadEncoded", self::$secret, true));
        return hash_equals($validSignature, $signatureEncoded);
    }

    public static function getPayload($jwt) {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) return null;
        $payloadJson = self::base64UrlDecode($parts[1]);
        return json_decode($payloadJson, true);
    }
    
    public static function verifyAndResend()
    {
        if (isset($_COOKIE['auth_token']) && JWT::verify($_COOKIE['auth_token'])) {
            $data = JWT::getPayload($_COOKIE['auth_token']);
            return $data;
        } else {
            header("Location: /auth/status");
            exit;
        }
    }
}
?>
