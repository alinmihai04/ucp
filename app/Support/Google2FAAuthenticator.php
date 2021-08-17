<?php
namespace App\Support;
use PragmaRX\Google2FALaravel\Support\Authenticator;
class Google2FAAuthenticator extends Authenticator
{
	protected function canPassWithoutCheckingOTP()
	{
		if(!count($this->getUser()->passwordSecurity))
			return true;

		return
		!$this->getUser()->user_2fa ||
		!$this->isEnabled() ||
		$this->noUserIsAuthenticated() ||
		$this->twoFactorAuthStillValid();
	}
	protected function getGoogle2FASecretKey()
	{
		$secret = $this->getUser()->{$this->config('otp_secret_column')};
		if (is_null($secret) || empty($secret)) 
		{
			throw new InvalidSecretKey('Secret key cannot be empty.');
		}
		return $secret;
	}
}