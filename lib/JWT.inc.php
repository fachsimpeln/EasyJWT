<?php
     /**
     * JWT (Json Web Tokens) without composer
     * An implementation of the json web tokens in PHP
     *
     * @author fachsimpeln
     * @category Main JWT class
     * @version jwt.core.main, v1.0, 2020-04-14
     */
     namespace EasyJWT;

     require __DIR__ . '/JWTCookie.php';
     require __DIR__ . '/JWTData.php';
     require __DIR__ . '/JWTDataEncrypted.php';
     require __DIR__ . '/JWTEncryption.php';
     require __DIR__ . '/JWTFunctions.php';
     require __DIR__ . '/JWTOptions.php';
     require __DIR__ . '/JWTReservedClaims.php';
     require __DIR__ . '/JWTSignature.php';

     require __DIR__ . '/Exception/InvalidSignatureException.php';
     require __DIR__ . '/Exception/EncryptionException.php';
     require __DIR__ . '/Exception/CookieException.php';
     require __DIR__ . '/Exception/MalformedInputException.php';
     require __DIR__ . '/Exception/SecurityException.php';
     require __DIR__ . '/Exception/ClaimException.php';
     require __DIR__ . '/Exception/RegisteredClaimException.php';

     include(__DIR__ . '/JWT.php');

?>
