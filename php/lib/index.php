<?php

namespace RyanTorske\ObjectOrientedPhase1;

require_once(dirname(__DIR__) . "/Classes/autoload.php");

$hash = password_hash("password", PASSWORD_ARGON2I, ["time_cost" => 7]);

$newAuthor = new Author("ced40596-0e9a-4048-bfcf-9efbc13b5926", "12345678912345678912345678912340", "mycodingprofile.com", "rtorske@cnm.edu", $hash, "RyanTorske");
var_dump($newAuthor);
echo ($newAuthor->getAuthorUsername());
echo ($newAuthor->getAuthorActivationToken());
echo ($newAuthor->getAuthorAvatarUrl());
echo ($newAuthor->getAuthorEmail());
echo ($newAuthor->getAuthorHash());
echo ($newAuthor->getAuthorID());