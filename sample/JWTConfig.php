<?php

     require '../vendor/autoload.php';

     /* =========== INITIALIZE JWT AND CONFIGURE ============ */

     // Signature Symmetric Key
     EasyJWT\JWT::$SECRET = 'PLEASE_CHANGE';

     // Encryption Symmetric Key
     EasyJWT\JWT::$ENCRYPTION_KEY = 'PLEASE_CHANGE';


     // Whitelist of available algorithms
     EasyJWT\JWT::$JWTAlgorithmWhitelist = ['HS256', 'HS512', 'HS384'];

     // Cookie settings
     EasyJWT\JWT::$JWT_COOKIE_NAME = 'EasyJWT';
     EasyJWT\JWT::$SSL = false;
     EasyJWT\JWT::$HTTP_ONLY = true;

?>
