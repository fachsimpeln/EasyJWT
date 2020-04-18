<?php

     /**
     * JWT Reserved Claims
     * This class represents all claims that can be set and are reserved variable names in the data (body) of a JWT
     *
     * @author fachsimpeln
     * @category Options
     * @version jwt.core.options, v1.0, 2020-04-14
     */
     namespace EasyJWT;
     class JWTReservedClaims
     {
          /* CLAIMS */

          /** @var array All possible reserved claims */
          public const RESERVED_POSSIBLE_CLAIMS = array("iss", "sub", "aud", "exp", "nbf", "iat", "jti");

          /** @var array All possible public claims */
          public const PUBLIC_POSSIBLE_CLAIMS =  array("iss", "sub", "aud", "exp", "nbf", "iat", "jti", "name", "given_name", "family_name", "middle_name", "nickname", "preferred_username", "profile", "picture", "website", "email", "email_verified", "gender", "birthdate", "zoneinfo", "locale", "phone_number", "phone_number_verified", "address", "updated_at", "azp", "nonce", "auth_time", "at_hash", "c_hash", "acr", "amr", "sub_jwk", "cnf", "sip_from_tag", "sip_date", "sip_callid", "sip_cseq_num", "sip_via_branch", "orig", "dest", "mky", "events", "toe", "txn", "rph", "sid", "vot", "vtm", "attest", "origid", "act", "scope", "client_id", "may_act", "jcard", "at_use_nbr");

          /** @var string|null Issuer of the JWT */
          private $iss = null;
          /** @var string|null Subject of the JWT (the user) */
          private $sub = null;
          /** @var array|null Recipient for which the JWT is intended */
          private $aud = null;
          /** @var int|null Time after which the JWT expires */
          private $exp = null;
          /** @var int|null Time before which the JWT must not be accepted for processing */
          private $nbf = null;
          /** @var int|null Time at which the JWT was issued; can be used to determine age of the JWT -> is automatically set to time the JWTClaims object was created */
          private $iat = null;
          /** @var string|null Unique identifier; can be used to prevent the JWT from being replayed (allows a token to be used only once) */
          private $jti = null;

          /**
          * Contructor for JWTClaims
          *
          * @param int|null $iat Set own issue time (when not set, automatically set to the current timestamp)
          */
          public function __construct($iat = null)
          {
               if ($iat === null || !is_numeric($iat)) {
                    $this->iat = time();
                    return;
               }
               $this->iat = $iat;
          }

          /**
          * SetClaim provides the functionality to set a claim value
          *
          * @param string $claim_name Name of the claim you want to set (possible values: iss, sub, aud, exp, nbf, jti)
          * @param string $claim_value Value for the claim
          * @return bool Success message, false if error (like wrong value type)
          */
          public function SetClaim($claim_name, $claim_value)
          {
               $claim_name = strtolower($claim_name);
               switch ($claim_name) {
                    case 'iss':
                         $this->iss = $claim_value;
                         break;

                    case 'sub':
                         $this->sub = $claim_value;
                         break;

                    case 'aud':
                         $this->iss = $claim_value;
                         break;

                    case 'exp':
                         if (!is_numeric($claim_value)) {
                              return false;
                         }
                         $this->exp = $claim_value;
                         break;

                    case 'nbf':
                         if (!is_numeric($claim_value)) {
                              return false;
                         }
                         $this->nbf = $claim_value;
                         break;

                    case 'jti':
                         $this->jti = $claim_value;
                         break;

                    default:
                         throw new \InvalidArgumentException("The Claim " . $claim_name . ' does not exist! Possible claim names: iss, sub, aud, exp, nbf, jti');
               }

               return true;
          }

          /**
          * Enables the timestamp and sets it to the current timestamp
          */
          public function EnableIAT()
          {
               $this->iat = time();
          }

          /**
          * Disables the timestamp completely
          */
          public function DisableIAT()
          {
               $this->iat = null;
          }


          /**
          * Returns an array with all of the claims set by the user.
          * Unset claims will be ignored
          *
          * @return array The claims set by the user
          */
          public function GetClaims()
          {
               $claims = array();
               foreach (self::RESERVED_POSSIBLE_CLAIMS as $key => $value) {
                    if ($this->{$value} !== null) {
                         $claims[$value] = $this->{$value};
                    }
               }

               return $claims;
          }


     }
?>
