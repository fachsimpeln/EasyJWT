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


          /** @var JWTData|null JWTData object which contains the acutal data */
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
               if ($jwt_data === null) {
                    throw new \InvalidArgumentException("The JWTData parameter was not given.");
               }

               $this->JWTData = null;

               // Check if data is valid
               if (!JWTSignature::VerifySignature($jwt_data, $this)) {
                    throw new Exception\InvalidSignatureException('The signature \'' . JWTFunctions::Base64URLEncode($jwt_data->JWTSign) . '\' is invalid!');
               }

               // Check reserved claims
               $body = $jwt_data->returnData($this);

               // Expired?
               if (isset($body['exp']) && !$jwt_data->GetCreated($this)) {
                    if (time() > $body['exp']) {
                         // JWT is expired
                         throw new Exception\RegisteredClaimException("The 'exp' claim is not satisfied. The JWT has expired.");
                    }
               }

               // Not before?
               if (isset($body['nbf']) && !$jwt_data->GetCreated($this)) {
                    if (time() <= $body['nbf']) {
                         // JWT cannot be accepted currently
                         throw new Exception\RegisteredClaimException("The 'nbf' claim is not satisfied. The JWT is not valid until " . htmlspecialchars($body['nbf'], ENT_QUOTES) . '.');
                    }
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
               return $this->JWTData->returnData($this);
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
