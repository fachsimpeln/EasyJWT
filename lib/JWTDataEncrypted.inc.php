<?php

     /**
     * JWT Data container (encrypted)
     * This class contains the acutal data, like the header, the data and the signature.
     * The encrypted version adds encryption between the server and the user, so that the JWT cannot be read by the user (useful for sensetive informations)
     *
     * @author fachsimpeln
     * @category JWT Data Encryption
     * @version jwt.core.dataenc, v1.0, 2020-04-13
     */
     namespace EasyJWT;
     class JWTDataEncrypted extends JWTData
     {

          /**
          * Creates new JWT data container object, that contains the options (header), the data and the signature. The signature is created upon creation.
          * If no data is given, the constructor attempts to get the JWT Cookie
          * (VERSION WITH ENCRYPTION)
          *
          * @param array|string|null $jwt_data The data (main content) as array for the JWT; if string it takes it instead of trying to read the cookie
          * @param JWTOptions|null $jwt_options JWT Options object which contains the header and other settings
          */
          public function __construct($jwt_data = null, $jwt_options = null)
          {
               // if data is empty, set the data to the current JWT cookie data
               // (warning: the signature will not be checked)
               if ($jwt_data === null) {
                    $jwt_data = JWTCookie::GetCookie(JWT::$JWT_COOKIE_NAME);
                    $this->HandleCookie($jwt_data);
                    return;
               }

               if (is_string($jwt_data)) {
                    $this->HandleCookie($jwt_data, true);
                    return;
               }

               // if options are empty, set them to default
               if ($jwt_options === null) {
                    $jwt_options = new JWTOptions();
               }
               $this->JWTOptions = $jwt_options;

               // set data to variable and turn it to json
               $this->JWTData = $jwt_data;
               $this->JWTData_JSON = JWTFunctions::ConvertToJSON($jwt_data);

               // generate correct signature
               $this->JWTSign = JWTSignature::CreateSignature($this->JWTData_JSON, $this->JWTOptions);
          }

          /**
          * Joins the JSON data from the attributes to the JWT standard and encrypts them
          * Uses base64url on every component and join the strings with a dot (.)
          *
          * @return string JWT cookie value as an encrypted string
          */
          public function toCookie()
          {
               $unencrypted =
               JWTFunctions::Base64URLEncode($this->JWTOptions->toJson()) . '.' .
               JWTFunctions::Base64URLEncode($this->JWTData_JSON) . '.' .
               JWTFunctions::Base64URLEncode($this->JWTSign);

               return JWTEncryption::EncryptText($unencrypted, JWT::$ENCRYPTION_KEY);
          }

          /**
          * Handles a encrypted cookie string given by the user
          * It sets all attributes according to the cookie
          *
          * @param string $cookie JWT cookie value as string
          */
          private function HandleCookie($cookie, $manual = false)
          {
               if ($cookie == '' || $cookie == null) {
                    if ($manual) {
                         throw new Exception\MalformedInputException('The JWT String representation that was supplied is empty. The data container cannot be created.');
                         return;
                    }
                    throw new Exception\CookieException('The cookie \'' . htmlspecialchars(JWT::$JWT_COOKIE_NAME, ENT_QUOTES) . '\' is not set. The data container cannot be created.');
                    return;
               }

               $cookie = JWTEncryption::DecryptText($cookie, JWT::$ENCRYPTION_KEY);

               if ($cookie === false) {
                    if ($manual) {
                         throw new Exception\MalformedInputException('The JWT String representation could not be decrypted - the key does not match. The data container cannot be created.');
                         return;
                    }
                    throw new Exception\CookieException('The cookie \'' . htmlspecialchars(JWT::$JWT_COOKIE_NAME, ENT_QUOTES) . '\' could not be decrypted - the key does not match. The data container cannot be created.');
                    return;
               }

               // Split the cookie into the different parts
               $header = $body = $sign = '';
               try {
                    $cookie = explode('.', $cookie);

                    $header = $cookie[0];
                    $body = $cookie[1];
                    $sign = $cookie[2];

                    $header = JWTFunctions::ConvertFromJSON(
                                   JWTFunctions::Base64URLDecode($header)
                              );
                    $body =   JWTFunctions::ConvertFromJSON(
                                   JWTFunctions::Base64URLDecode($body)
                              );
                    $sign =   JWTFunctions::Base64URLDecode($sign);


               } catch (\Exception $e) {
                    if ($manual) {
                         throw new Exception\MalformedInputException('The supplied string representation of the JWT has the wrong format. The data container cannot be created.');
                         return;
                    }

                    throw new Exception\CookieException('The cookie \'' . htmlspecialchars(JWT::$JWT_COOKIE_NAME, ENT_QUOTES) . '\' has the wrong format. The data container cannot be created.');
                    return;
               }

               // Check if format is valid
               $so = new JWTOptions();
               $so = $so->toArray();

               $hc = $header;

               $hc['alg'] = '';
               $so['alg'] = '';

               if ($hc !== $so) {
                    if ($manual) {
                         throw new Exception\MalformedInputException('The given JWT value has a malformed header that is not compatible with EasyJWT. The data container cannot be created.');
                         return;
                    }

                    throw new Exception\CookieException('The cookie \'' . htmlspecialchars(JWT::$JWT_COOKIE_NAME, ENT_QUOTES) . '\' has a malformed header. The data container cannot be created.');
                    return;
               }

               // Everything fine -> set the attributes accordingly
               $this->JWTOptions = new JWTOptions($header['alg']);

               $this->JWTData = $body;
               $this->JWTData_JSON = JWTFunctions::ConvertToJSON($body);

               $this->JWTSign = $sign;

          }
     }


?>