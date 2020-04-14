<?php

     /**
     * JWT Cookie Handler
     * Handles setting and reading cookie data
     *
     * @author fachsimpeln
     * @category Cookie System
     * @version jwt.system.cookie, v1.0, 2020-04-14
     */
     namespace EasyJWT;
     class JWTCookie
     {
          /**
          * Sets a cookie to the user's browser
          *
          * @param string $key Key for the cookie (e.g. JWT)
          * @param string $value Value for the cookie (e.g. eyJhbGciOiJ...)
          * @param bool $ssl Only over HTTPS (Standard: false)
          * @param bool $httpOnly Cookie only accessible through the HTTP-protocol (Standard: true)
          * @param int $expires Cookie expiration as UNIX timestamp (standard: 14days)
          */
          public static function SetCookie($key, $value, $ssl = false, $httpOnly = true, $expires = 0) {
               // Standard 14 Days
               if ($expires === 0) {
                    $expires = time() + (14 * 24 * 60 * 60); // 14d * 24h * 60min * 60 sec
               }
               setcookie($key, $value, intval($expires), '/', $_SERVER['HTTP_HOST'], $ssl, $httpOnly);
               return;
          }

          /**
          * Gets cookie value from key
          *
          * @param string $key Key for the cookie (e.g. JWT)
          * @return string|null Value of the cookie
          */
          public static function GetCookie($key) {
               return (isset($_COOKIE[$key]) ? $_COOKIE[$key] : null);
          }

          /**
          * Removes a cookie
          *
          * @param string $key Key for the cookie (e.g. JWT)
          */
          public static function RemoveCookie($key) {
               setcookie($key, "", time() - 3600);
          }
     }


?>
