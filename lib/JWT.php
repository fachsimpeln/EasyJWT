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
     require __DIR__ . '/JWTSignature.inc.php';

     require __DIR__ . './exceptions/InvalidSignatureException.php';
     require __DIR__ . './exceptions/EncryptionException.php';
     require __DIR__ . './exceptions/CookieException.php';
     require __DIR__ . './exceptions/MalformedInputException.php';

     class JWT
     {
          /** @var string Symmetric secure secret for the signing of the JWT (length appropriate to the signing method) */
          public static $SECRET = 'PLEASE_CHANGE';

          /** @var string|null Optional encryption key to encrypt the JWT when sensitive information is passed (openssl_random_pseudo_bytes) */
          public static $ENCRYPTION_KEY = 'PLEASE_CHANGE';

          /** @var array Algorithm whitelist to prevent misuse of the JWT header (e.g. none)*/
          public static $JWTAlgorithmWhitelist = ['HS256', 'HS512', 'HS384'];


          /** @var string Name for the cookie (standard: EasyJWT) */
          public static $JWT_COOKIE_NAME = 'EasyJWT';
          /** @var bool Cookie security: Only SSL */
          public static $SSL = false;
          /** @var bool Cookie security: HttpOnly */
          public static $HTTP_ONLY = true;


          /** @var JWTData|null Actual Data of the JWT */
          private $JWTData = null;


          /**
          * Creates new JWT object, that provides the verification and management of any JWT.
          * First, the constructor verifies that the signature is valid, then it saves the data object.
          * **WARNING: Before any interaction with the data of a JWT, create a JWT object to verify that the data is valid!**
          *
          * @param JWTData $jwt_data The data container (required)
          */
          function __construct($jwt_data)
          {
               $this->JWTData = null;

               // Check if data is valid
               if (!JWTSignature::VerifySignature($jwt_data)) {
                    throw new Exception\InvalidSignatureException('The signature \'' . JWTFunctions::Base64URLEncode($jwt_data->JWTSign) . '\' is invalid!');

                    return;
               }

               $this->JWTData = $jwt_data;
          }

          /**
          * Returns if the data is valid
          * @return bool True when valid, False when invalid
          */
          public function IsValid() {
               if ($this->JWTData !== null) {
                    return true;
               }
               return false;
          }

          /**
          * Returns the data of the JWTData object
          * @return array|null Array containing the data of the JWTData object
          */
          public function GetData() {
               if ($this->JWTData === null) {
                    return null;
               }
               return $this->JWTData->JWTData;
          }

          /**
          * Alias for GetData
          * @return array|null Array containing the data of the JWTData object
          */
          public function GetJWT() {
               return $this->GetData();
          }

          /**
          * Alias for GetData
          * @return array|null Array containing the data of the JWTData object
          */
          public function d() {
               return $this->GetData();
          }

          /**
          * Sends the current JWT Data container object to the user's browser as a cookie
          * @return bool Returns if the cookie was successfully set
          */
          public function SetJWT()
          {
               if ($this->JWTData === null) {
                    return false;
               }

               JWTCookie::SetCookie(self::$JWT_COOKIE_NAME, $this->toString(), self::$SSL, self::$HTTP_ONLY);
               return true;
          }

          /**
          * Returns the string representation of the JWT
          * @return string|bool String representation of the JWT, on error false
          */
          public function toString()
          {
               if ($this->JWTData === null) {
                    return false;
               }
               return $this->JWTData->toCookie();
          }

          /**
          * Removes the JWT cookie from the user's browser
          */
          public function RemoveJWT()
          {
               JWTCookie::RemoveCookie(self::$JWT_COOKIE_NAME);
          }


     }


?>
