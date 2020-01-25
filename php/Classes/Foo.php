<?php
/**
 * Author of a News Website logging into account
 *
 * The author class will be where all data will be kept about author.
 *
 * @author Ryan Torske <rtorske@cnm.edu
 **/
class author {
use ValidateUuid;
use ValidateDate;

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
 * @throws \RangeException if $newAuthorId is not positive
 * @throws \TypeError if the profile Id is not the uuid
 */
public function setAuthorId($newAuthorId): void {
	try {
		$uuid = self::validateUuid($newAuthorId);
	} catch(\InvalidArguementException | \RangeException | \Exception | \TypeError $exception) {
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
 * @throws \InvalidArgumentException if the token is not a string or is insecure
 * @throws \RangeException if the token is not exactly at 32 characters
 * @throws \TypeError if the activation token is not a complete string
 */

public function setAuthorActivationToken(string $newAuthorActivationToken) : void {
	if($newAuthorActivationToken === null) {
		$this->authorActivationToken = null;
		return;
	}
	$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
	if(ctype_xdigit($newAuthorActivationToken) === false) {
		throw(new\RangeException("Author Activation is Not Valid"));
	}
	//this will check and validate that the activation token is only 32 characters long
	if(strlen($newAuthorActivationToken)  !== 32) {
		throw(new\RangeException("Author Activation Token Must Be 32 Characters"));
	}
	$this->authorActivationToken = $newAuthorActivationToken;
}
/**
 * accessor method for the author avatar url
 * @return string value of avatar url
 */

}