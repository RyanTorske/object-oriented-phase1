<?php

namespace RyanTorske\ObjectOrientedPhase1;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Exception;
use InvalidArgumentException;use Ramsey\Uuid\Uuid;use RangeException;
use TypeError;

/**
 * Author of a News Website logging into account
 *
 * The author class will be where all data will be kept about author.
 *
 * @author Ryan Torske <rtorske@cnm.edu>
 **/
class author {
use ValidateUuid;
use ValidateDate;

	/**
	 * Constructor for this author profile
	 *
	 * @param int $newAuthorId new author profile id
	 * @param string $newAuthorActivationToken
	 * @param int $newAuthorAvatarUrl
	 * @param string $newAuthorEmail
	 * @param string $newAuthorHash
	 * @param string $newAuthorUsername
	 * @throws InvalidArgumentException if data is put into system and is not valid or insecure
	 * @throws RangeException has too many characters in the allotted string
	 * @throws Exception an issue occurred with either string input
	 * @throws TypeError incorrect string entered, or incorrect email
	 **/
	public function __construct($newAuthorId, $newAuthorActivationToken, $newAuthorAvatarUrl, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		} catch(InvalidArgumentException $exception) {
			//rethrow to the caller
			throw(new InvalidArgumentException("Unable to construct profile", 0, $exception));
		}
	}
/**
 * id for the author and will act as primary key
 * @var $authorId
 */
private $authorId;

/**
 * a token that is used to verify the author profile is valid
 * @var $authorActivationToken
 */
private $authorActivationToken;

/**
 * url for the avatar or public photo of the author
 * @var $authorAvatarUrl
 */
private $authorAvatarUrl;

/**
 * email for the author profile
 * @var string $authorEmail
 */
private $authorEmail;

/**
 * password for the author login that will be hashed
 *@var string $authorHash
 */
private $authorHash;

/**
 * username for the author, normally used for a login form
 * @var $authorUsername
 */
private $authorUsername;


/**
 * accessor method for the author Id
 *
 * @return Uuid
 */
public function getAuthorID(): Uuid {
	return ($this->authorId);
}
/**
 * mutator method for author id use
 * @param Uuid / string $newAuthorId value of a new author id
 * @throws /RangeException if $newAuthorId is not positive
 * @throws /TypeError if the profile Id is not the uuid
 * @throws /InvalidArgumentException
 */
public function setAuthorId($newAuthorId): void {
	try {
		$uuid = self::validateUuid($newAuthorId);
	} catch(\InvalidArguementException | RangeException | Exception | TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// Store the author Id and convert from uuid
	$this->authorId = $uuid;
}
/**
 * accessor method for utilizing the author activation token
 * @return string value of the activation token
 */
public function getAuthorActivationToken() : string {
	return ($this->authorActivationToken);
}
/**
 * mutator method for the author activation token
 * @param string $newAuthorActivationToken
 * @throws /InvalidArgumentException if the token is not a string or is insecure
 * @throws /RangeException if the token is not exactly at 32 characters
 * @throws /TypeError if the activation token is not a complete string
 */

public function setAuthorActivationToken(?string $newAuthorActivationToken) : void {
	if($newAuthorActivationToken === null) {
		$this->authorActivationToken = null;
		return;
	}
	$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
	if(ctype_xdigit($newAuthorActivationToken) === false) {
		throw(newRangeException("Author Activation is Not Valid"));
	}
	//this will check and validate that the activation token is only 32 characters long
	if(strlen($newAuthorActivationToken)  !== 32) {
		throw(newRangeException("Author Activation Token Must Be 32 Characters"));
	}
	$this->authorActivationToken = $newAuthorActivationToken;
}
/**
 * accessor method for the author avatar url
 * @return string value of avatar url
 */
public function getAuthorAvatarUrl() : string {
	return ($this->authorAvatarUrl);
}
/**
 * mutator method for author avatar url
 * @param string $newAuthorAvatarUrl
 * @throws /RangeException if the author avatar url is too long
 */
public function setAuthorAvatarUrl(string $newAuthorAvatarUrl) : void {
	if ($newAuthorAvatarUrl === null) {
		$this->authorAvatarUrl = null;
		return;
	}
	if (strlen($newAuthorAvatarUrl) > 255) {
		throw (newRangeException("The Avatar URL can only be a max of 255 characters."));
	}
	$this->authorAvatarUrl = $newAuthorAvatarUrl;
}
/**
 * accessor method for author email
 * @returns string value of the authors email
 */
public function getAuthorEmail() : string {
	return ($this->authorEmail);
}
/**
 * mutator method for the author email
 * @param string $newAuthorEmail
 * @throws RangeException if the author email is too long or null
 * @throws \invalidArgumentException if $newAuthorEmail is not a valid email or insecure
 * @throws TypeError if $newAuthorEmail is not a string
 */
public function setAuthorEmail(string $newAuthorEmail) : void {
	$newAuthorEmail = trim($newAuthorEmail);
	$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
	if ($newAuthorEmail === null) {
		throw (new\InvalidArgumentException("Author Email is empty or not secure."));
	}
	if(strlen($newAuthorEmail) > 128) {
		throw (newRangeException("Author Email Can Be a Max of 128 Characters in Length"));
	}
	$this->authorEmail = $newAuthorEmail;
}
	/**
	 * accessor method for the author hash
	 * @return string value of hash
	 */
public function getAuthorHash(): string {
	return $this->authorHash;
	}
	/**
	 * mutator method for author hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if hash is not secure
	 * @throws RangeException if the hash is not 128 characters
	 * @throws TypeError if profile hash is not a string
	 */
	public function setAuthorHash(string $newAuthorHash) : void {
		//enforce the hash is really a hash
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true); {
			throw(new \InvalidArgumentException("Profile password hash is invalid or empty."));
		}
		//enforce the hash is a Argon hash
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("Profile hash is not a valid hash."));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("Profile hash must be 97 characters."));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	}
/**
 * accessor method for the author username
 * @returns string value of the authors username
 */
public function getAuthorUsername() : string {
	return($this->authorUsername);
}
/**
 * mutator method for the author username
 * @param string $newAuthorUsername
 * @throws /RangeException if the author username is too long
 */
public function setAuthorUsername(string $newAuthorUsername) : void {
	if ($newAuthorUsername === null) {
		throw (newRangeException("Author Needs to have a Username."));
	}
	if(strlen($newAuthorUsername) > 32) {
		throw (newRangeException("Author Username Can be a Max of 32 Characters in Length."));
	}
	$this->authorUsername = $newAuthorUsername;
}
}