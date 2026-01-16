<?php
// JWT configuration pour LRC Group

define("JWT_SECRET", "ton_secret_très_sécurisé");  // clé secrète pour encoder le JWT
define("JWT_ALGO", "HS256");                        // algorithme de signature
define("JWT_ISSUER", "lrc-group.com");             // émetteur
define("JWT_AUDIENCE", "lrc-group-users");         // audience
define("JWT_EXPIRE_TIME", 3600); 