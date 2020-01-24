<?php
/**
 * Author of a News Website
 *
 * The author class will be where all data will be kept about author.
 *
 * @author Ryan Torske <rtorske@cnm.edu
 **/
class author {
use ???;
/**
 * id for the author and will act as primary key
 */
private $authorId;
/**
 * a token that is used to verify the author profile is valid
 * @var $authorActivationToken
 */
private $authorActivationToken;
/**
 * url for the avatar of the author
 * @var $authorAvatarUrl
 */
private $authorAvatarUrl;
}