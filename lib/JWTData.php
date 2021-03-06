<?php

     /**
     * JWT Data container
     * This class contains the acutal data, like the header, the data and the signature.
     *
     * @author fachsimpeln
     * @category JWT Data
     * @version jwt.core.data, v1.0, 2020-04-13
     */
     namespace EasyJWT;
     class JWTData
     {
          /** @var JWTOptions JWT Options object which contains the header (the options) */
          public $JWTOptions;
          /** @var array Main data (claims) as array including reserved claims */
          protected $JWTData;
          /** @var string Main data as a JSON string with reserved claims*/
          protected $JWTData_JSON;
          /** @var raw Signature Data (raw) */
          public $JWTSign;

          /** @var bool Shows if the object was created from an existing JWT or new (do not change) */
          private $created = false;


          /**
          * Creates new JWT data container object, that contains the options (header), the data and the signature. The signature is created upon creation.
          * If no data is given, the constructor attempts to get the JWT Cookie
          *
          * @param array|string|null $jwt_data The data (main content) as array for the JWT (no reserved claim names!); if string it takes it instead of trying to read the cookie
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

               // Check reserved claims
               foreach (JWTReservedClaims::RESERVED_POSSIBLE_CLAIMS as $key => $value) {
                    if (array_key_exists($key, $jwt_data)) {
                         throw new Exception\ClaimException("The array for the JWT Data object contains the reserved claim name '" . $key . "'. If you want to use that claim, please specify it in a JWTClaims object.");
                    }
               }

               // Check public claims
               if (!$jwt_options->allow_private_claims) {
                    foreach ($jwt_data as $key => $value) {
                         if (!array_key_exists($key, JWTReservedClaims::PUBLIC_POSSIBLE_CLAIMS)) {
                              throw new Exception\ClaimException("The claim '" . $key . "' is a private claim. Through JWTOptions only public claims are allowed.");
                         }
                    }
               }

               // Merge reserved claims with the user's array
               $jwt_data = array_merge($jwt_data, $jwt_options->jwt_reserved_claims->GetClaims());
               $this->created = true;


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
          * Joins the JSON data from the attributes to the JWT standard
          * Uses base64url on every component and join the strings with a dot (.)
          *
          * @return string JWT cookie value as string
          */
          public function toCookie()
          {
               return
               JWTFunctions::Base64URLEncode($this->JWTOptions->toJson()) . '.' .
               JWTFunctions::Base64URLEncode($this->JWTData_JSON) . '.' .
               JWTFunctions::Base64URLEncode($this->JWTSign);
          }

          /**
          * Returns the data (body) of the JWTData object.
          * Cannot be accessed by the software, only by an object of JWT
          *
          * @param object $caller The caller as a object ($this)
          * @return string JWT cookie value as string
          */
          public function returnData($caller) {
               if ($caller instanceof JWT) {
                    return $this->JWTData;
               }
               throw new Exception\SecurityException("This value cannot be accessed directly. Please use an object of class JWT to access the data!");
          }

          /**
          * Returns the data (body) JSON encoded of the JWTData object.
          * Cannot be accessed by the software, only by an object of JWT
          *
          * @param object $caller The caller as a object ($this)
          * @return string JWT cookie value as JSON-encoded string
          */
          public function returnDataJSON($caller) {
               if ($caller instanceof JWT) {
                    return $this->JWTData_JSON;
               }
               throw new Exception\SecurityException("This value cannot be accessed directly.");
          }

          /**
          * Returns if the object was created by an existing JWT or new
          * Cannot be accessed by the software, only by an object of JWT
          *
          * @param object $caller The caller as a object ($this)
          * @return bool Created new or not
          */
          public function GetCreated($caller) {
               if ($caller instanceof JWT) {
                    return $this->created;
               }
               return null;
          }

          /**
          * Handles a cookie string given by the user
          * It sets all attributes according to the cookie
          *
          * @param string $cookie JWT cookie value as string
          */
          protected function HandleCookie($cookie, $manual = false)
          {
               if ($cookie == '' || $cookie == null) {
                    if ($manual) {
                         throw new Exception\MalformedInputException('The JWT String representation that was supplied is empty. The data container cannot be created.');
                    }
                    throw new Exception\CookieException('The cookie \'' . htmlspecialchars(JWT::$JWT_COOKIE_NAME, ENT_QUOTES) . '\' is not set. The data container cannot be created.');
               }

               // Split the cookie into the different parts
               $header = $body = $sign = '';
               $cookie = explode('.', $cookie);

               if (!isset($cookie[0]) || !isset($cookie[1]) || !isset($cookie[2]) ) {
                    if ($manual) {
                         throw new Exception\MalformedInputException('The supplied string representation of the JWT has the wrong format. The data container cannot be created.');
                    }

                    throw new Exception\CookieException('The cookie \'' . htmlspecialchars(JWT::$JWT_COOKIE_NAME, ENT_QUOTES) . '\' has the wrong format. The data container cannot be created.');
               }

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


               // Check if format is valid
               $so = new JWTOptions();
               $so = $so->toArray();

               $hc = $header;

               $hc['alg'] = '';
               $so['alg'] = '';

               if ($hc !== $so) {
                    if ($manual) {
                         throw new Exception\MalformedInputException('The given JWT value has a malformed header that is not compatible with EasyJWT. The data container cannot be created.');
                    }

                    throw new Exception\CookieException('The cookie \'' . htmlspecialchars(JWT::$JWT_COOKIE_NAME, ENT_QUOTES) . '\' has a malformed header. The data container cannot be created.');
               }


               // Everything fine -> set the attributes accordingly
               $this->JWTOptions = new JWTOptions($header['alg']);

               $this->JWTData = $body;
               $this->JWTData_JSON = JWTFunctions::ConvertToJSON($body);

               $this->JWTSign = $sign;

          }
     }


?>
