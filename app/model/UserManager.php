<?php

//declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Database\Context;
use Nette\Security\Passwords;

class UserManager extends DatabaseManager implements Nette\Security\IAuthenticator {

	use Nette\SmartObject;

	private const
		TABLE_NAME = 'users',
		COLUMN_ID = 'id',
		COLUMN_NAME = 'name',
		COLUMN_SURNAME = 'surname',
		COLUMN_BIRTH = 'birth',
		COLUMN_SKILLS = 'skills';

/*
	public function __construct(Context $database){
        parent::__construct($database);
    }
*/
    public function getPublicUsers(){
	    return $this->database->table(self::TABLE_NAME);
    }


	/**
	 * Performs an authentication.
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials): Nette\Security\IIdentity
	{
		[$username, $password] = $credentials;

		$row = $this->database->table(self::TABLE_NAME)
			->where(self::COLUMN_NAME, $username)
			->fetch();

		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!$this->passwords->verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif ($this->passwords->needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
			$row->update([
				self::COLUMN_PASSWORD_HASH => $this->passwords->hash($password),
			]);
		}

		$arr = $row->toArray();
		unset($arr[self::COLUMN_PASSWORD_HASH]);
		return new Nette\Security\Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
	}


	/**
	 * Adds new user.
	 * @throws DuplicateNameException
	 */
	public function add(string $name, string $surname, string $birth, string $skills): void {
		try {
			$this->database->table(self::TABLE_NAME)->insert([
				self::COLUMN_NAME => $name,
				self::COLUMN_SURNAME => $surname,
				self::COLUMN_BIRTH => $birth,
				self::COLUMN_SKILLS => $skills,
			]);
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	}

	public function deleteUser($id){
        $this->getPublicUsers()->where(self::COLUMN_ID,$id)->delete();
    }

}


/*
class DuplicateNameException extends \Exception
{
}
*/
