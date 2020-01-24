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
}