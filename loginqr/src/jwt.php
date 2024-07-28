<?php
class JWT {
    public static function encode($payload, $key, $alg = 'HS256') {
        $header = json_encode(['typ' => 'JWT', 'alg' => $alg]);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function decode($jwt, $key, $alg = 'HS256') {
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);
        $header = json_decode(base64_decode($headerEncoded), true);
        $payload = json_decode(base64_decode($payloadEncoded), true);
        $signature = base64_decode(str_replace(['-', '_', ''], ['+', '/', '='], $signatureEncoded));
        $validSignature = hash_hmac('sha256', $headerEncoded . "." . $payloadEncoded, $key, true);
        if (hash_equals($signature, $validSignature)) {
            return $payload;
        }
        return false;
    }
}
?>
