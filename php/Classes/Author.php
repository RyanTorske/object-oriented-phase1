<?php

namespace RyanTorske\ObjectOrientedPhase1;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/Classes/autoload.php");


use Ramsey\Uuid\Uuid;


/**
 * Author of a News Website logging into account
 *
 * The author class will be where all data will be kept about author.
 *
 * @author Ryan Torske <rtorske@cnm.edu>
 **/
class Author implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;

	/**
	 * Constructor for this author profile
	 *
	 * @param string|Uuid $newAuthorId new author profile id
	 * @param string $newAuthorActivationToken
	 * @param string $newAuthorAvatarUrl
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
	 * @var Uuid $authorId
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
	 * @var string $authorHash
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
	 * @param Uuid|string $newAuthorId value of a new author id
	 * @throws /RangeException if $newAuthorId is not positive
	 * @throws /TypeError if the profile Id is not the uuid
	 * @throws /InvalidArgumentException
	 */
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// Store the author Id and convert from uuid
		$this->authorId = $uuid;
	}


		//$this -> authorId = $newAuthorId; Orignial Code

	/**
	 * accessor method for utilizing the author activation token
	 * @return string value of the activation token
	 */
	public function getAuthorActivationToken(): string {
		return ($this->authorActivationToken);
	}

	/**
	 * mutator method for the author activation token
	 * @param string $newAuthorActivationToken
	 * @throws /InvalidArgumentException if the token is not a string or is insecure
	 * @throws /RangeException if the token is not exactly at 32 characters
	 * @throws /TypeError if the activation token is not a complete string
	 */

	public function setAuthorActivationToken(string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("Author Activation is Not Valid"));
		}
		//this will check and validate that the activation token is only 32 characters long
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new\RangeException("Author Activation Token Must Be 32 Characters"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 * accessor method for the author avatar url
	 * @return string value of avatar url
	 */
	public function getAuthorAvatarUrl(): string {
		return ($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author avatar url
	 * @param string $newAuthorAvatarUrl
	 * @throws /RangeException if the author avatar url is too long
	 */
	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
		if($newAuthorAvatarUrl === null) {
			$this->authorAvatarUrl = null;
			return;
		}
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw (new \RangeException("The Avatar URL can only be a max of 255 characters."));
		}
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * accessor method for author email
	 * @returns string value of the authors email
	 */
	public function getAuthorEmail(): string {
		return ($this->authorEmail);
	}

	/**
	 * mutator method for the author email
	 * @param string $newAuthorEmail
	 * @throws \RangeException if the author email is too long or null
	 * @throws \invalidArgumentException if $newAuthorEmail is not a valid email or insecure
	 * @throws \TypeError if $newAuthorEmail is not a string
	 */
	public function setAuthorEmail(string $newAuthorEmail): void {
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if($newAuthorEmail === null) {
			throw (new\InvalidArgumentException("Author Email is empty or not secure."));
		}
		if(strlen($newAuthorEmail) > 128) {
			throw (new RangeException("Author Email Can Be a Max of 128 Characters in Length"));
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
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setAuthorHash(string $newAuthorHash): void {
		//enforce the hash is really a hash
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true)
		{
			throw(new \InvalidArgumentException("Profile password hash is invalid or empty."));
		}
		//enforce the hash is a Argon hash
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("Profile hash is not a valid hash."));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !==96) {
			throw(new\RangeException("Profile hash must be 96 characters."));
		}
		//store the hash
		$this -> authorHash = $newAuthorHash;
	}

	/**
	 * accessor method for the author username
	 * @returns string value of the authors username
	 */
	public function getAuthorUsername(): string {
		return ($this->authorUsername);
	}

	/**
	 * mutator method for the author username
	 * @param string $newAuthorUsername
	 * @throws \RangeException if the author username is too long
	 */
	public function setAuthorUsername(string $newAuthorUsername): void {
		if($newAuthorUsername === null) {
			throw (new\RangeException("Author Needs to have a Username."));
		}
		if(strlen($newAuthorUsername) > 32) {
			throw (new\RangeException("Author Username Can be a Max of 32 Characters in Length."));
		}
		$this->authorUsername = $newAuthorUsername;
	}


	/*
	 * Starting part 2 of OOP, INSERT,DELETE,UPDATE Form.
	 *
	 * Inserts this Author into author class for MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when SQL error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 */

	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO Author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl->getBytes(), "authorEmail" => $this->authorEmail->getBytes(), "authorHash" => $this->authorHash->getBytes(), "authorUsername" => $this->authorUsername->getBytes()];
		$statement->execute($parameters);
	}

	/*
	 * Updates Author in MySQL database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when SQL error occurs
	 * @throws \TypeError if $pdo iis not a PDO connection object
	 */
	public function update(\PDO $pdo) : void {
		//create a query template
		$query = "UPDATE Author SET authorId = :authorId, authorActivationToken = :authorActivationToken, authorAvatarUrl = :authorAvatarUrl, authorEmail = :authorEmail, authorHash = :authorHash, authorUserName = :authorUserName";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl->getBytes(), "authorEmail" => $this->authorEmail->getBytes(), "authorHash" => $this->authorHash->getBytes(), "authorUserName" => $this->authorUserName->getBytes()];
		$statement->execute($parameters);
	}

	/*
	 * deletes a author form MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) : void {
		//create a query template
		$query = "DELETE FROM Author WHERE authorID = :authorId";
		$statement = $pdo->prepare($query);

		//remove existing authorId from variables in template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/*
	 * gets the Author by Author username.
	 *
	 * @param  \PDO $pdo PDO connection object
	 * @param string $authorUsername author Id to search for
	 * @return \SplFixedArray SplFixedArray of Authors found
	 * @throws \TypeError if author id is an incorrect data type
	 * @throws \PDOException when MySQL error occurs
	 */

	public static function getAuthorByAuthorUsername(\PDO $pdo, string $authorUsername) : \SPLFixedArray {
		// sanitize the description before searching
		$authorUsername = trim($authorUsername);
		$authorUsername = filter_var($authorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//escape any MySQL wild cards
		$result = str_replace("%", "\\%", $authorUsername);
		$authorUsername = str_replace("_", "\\_", $result);

		//create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM Author WHERE authorUsername LIKE :authorUsername";
		$statement = $pdo->prepare($query);

		//bind author username to the place holder in the template
		$authorUsername = "%$authorUsername%";
		$parameters = ["authorUsername" => $authorUsername];
		$statement->execute($parameters);

		//build an array of authors
		$authorArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				$authorArray[$authorArray->key()] = $author;
				$authorArray->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($authorArray);
	}


	/**
	 *gets the Author by authorId
	 *
	 *@param \PDO $pdo PDO connection object
	 *@param Uuid|string $authorId author id to search for
	 *@return Author|null Author found or null if not found
	 *@throws \PDOException when MySQL related errors occur
	 *@throws \TypeError when a variable is not the correct data type
	 **/
	public static funtion getAuthorbyAuthorId(\PDO $pdo, $authorId) : ?Author {
		//sanitize the authorId before searching
	try {
		$authorId = self::ValidateUuid($authorId);
	} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(), 0. $exception));
}
	//create query template
	$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM Author WHERE authorId = :authorId"
	$statement = $pdo->prepare($query);

	//bind the author id to the place holder in template
	$parameters = ["authorId" => $authorId->getBytes()];
	$statement->execute($parameters);

	
}

	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["authorId"] = $this->authorId->toString();
		return ($fields);
	}
	// TODO: Implement jsonSerialize() method.}
}