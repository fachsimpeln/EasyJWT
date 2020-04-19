<?php
     /**
     * JWT (Json Web Tokens) without composer
     * An implementation of the json web tokens in PHP
     * Main JWT class without encryption
     *
     * @author fachsimpeln
     * @category Main JWT class
     * @version jwt.core.main, v1.0, 2020-04-14
     */
     namespace EasyJWT;

     require __DIR__ . '/../lib/JWTCookie.inc.php';
     require __DIR__ . '/../lib/JWTData.inc.php';
     require __DIR__ . '/../lib/JWTDataEncrypted.inc.php';
     require __DIR__ . '/../lib/JWTEncryption.inc.php';
     require __DIR__ . '/../lib/JWTFunctions.inc.php';
     require __DIR__ . '/../lib/JWTOptions.inc.php';
     require __DIR__ . '/../lib/JWTReservedClaims.inc.php';
     require __DIR__ . '/../lib/JWTSignature.inc.php';

     require __DIR__ . '/../lib/exceptions/InvalidSignatureException.php';
     require __DIR__ . '/../lib/exceptions/EncryptionException.php';
     require __DIR__ . '/../lib/exceptions/CookieException.php';
     require __DIR__ . '/../lib/exceptions/MalformedInputException.php';
     require __DIR__ . '/../lib/exceptions/SecurityException.php';
     require __DIR__ . '/../lib/exceptions/ClaimException.php';
     require __DIR__ . '/../lib/exceptions/RegisteredClaimException.php';

     include(__DIR__ . '/../lib/JWT.php');

?>
