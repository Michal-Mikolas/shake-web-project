<?php
declare(strict_types=1);

namespace App\Model;

use Shake\Scaffolding\Manager;
use Nette;
use Nette\Security;
use Nette\Security\Passwords;
use Nette\Utils\DateTime;


/**
 * Users management.
 */
class UserManager extends Manager implements Nette\Security\IAuthenticator
{

	/**
	 * Performs an authentication.
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials): Nette\Security\IIdentity
	{
		list($email, $password) = $credentials;

		$user = $this->find([
			'email' => $email,
			'active' => 1,
		]);

		if (!$user) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $user['password_hash'])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($user['password_hash'])) {
			$user->update([
				'password_hash' => Passwords::hash($password),
			]);
		}

		$arr = $user->toArray();
		unset($arr['password_hash']);
		return new Nette\Security\Identity($user['id'], $user->getRoles(), $arr);
	}


	/**
	 * Adds new user.
	 * @throws DuplicateNameException
	 */
	public function add(string $email, string $password)
	{
		try {
			return $this->create([
				'email' => $email,
				'password_hash' => Passwords::hash($password),
				'created' => new DateTime,
				'active' => 1,
			]);
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	}

}



class DuplicateNameException extends \Exception
{}
