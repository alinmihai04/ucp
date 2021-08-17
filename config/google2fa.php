<?php

return [

    /*
     * Auth container binding
     */

    'enabled' => true,

    /*
     * Lifetime in minutes.
     * In case you need your users to be asked for a new one time passwords from time to time.
     */

    'lifetime' => 0, // 0 = eternal

    /*
     * Renew lifetime at every new request.
     */

    'keep_alive' => true,

    /*
     * Auth container binding
     */

    'auth' => 'auth',

    /*
     * 2FA verified session var
     */

    'session_var' => 'google2fa',

    /*
     * One Time Password request input name
     */
    'otp_input' => '2fa_code',

    /*
     * One Time Password Window
     */
    'window' => 1,

    /*
     * Forbid user to reuse One Time Passwords.
     */
    'forbid_old_passwords' => false,

    /*
     * User's table column for google2fa secret
     */
    'otp_secret_column' => 'user_2fakey',

    /*
     * One Time Password View
     */
    'view' => 'auth.validate_code',

    /*
     * One Time Password error message
     */
    'error_messages' => [
        'wrong_otp' => "The code you typed was wrong.",
    ],

    /*
     * Throw exceptions or just fire events?
     */
    'throw_exceptions' => true,

];
