<?php
     /**
     * JWT (Json Web Tokens)
     * An implementation of the json web tokens in PHP
     * Main JWT class without encryption
     *
     * @author fachsimpeln
     * @category Main JWT class
     * @version jwt.core.main, v1.0, 2020-04-14
     */
     namespace EasyJWT;

     require __DIR__ . '/JWTCookie.inc.php';
     require __DIR__ . '/JWTData.inc.php';
     require __DIR__ . '/JWTDataEncrypted.inc.php';
     require __DIR__ . '/JWTEncryption.inc.php';
     require __DIR__ . '/JWTFunctions.inc.php';
     require __DIR__ . '/JWTOptions.inc.php';
     require __DIR__ . '/JWTReservedClaims.inc.php';
     require __DIR__ . '/JWTSignature.inc.php';

     require __DIR__ . './exceptions/InvalidSignatureException.php';
     require __DIR__ . './exceptions/EncryptionException.php';
     require __DIR__ . './exceptions/CookieException.php';
     require __DIR__ . './exceptions/MalformedInputException.php';
     require __DIR__ . './exceptions/SecurityException.php';
     require __DIR__ . './exceptions/ClaimException.php';
     require __DIR__ . './exceptions/RegisteredClaimException.php';

     include(__DIR__ . DIRECTORY_SEPARATOR . 'JWT.php');

?>
