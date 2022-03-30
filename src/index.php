<?php
use base\API;

$API = new API();

$API->register("/register", "POST", "Actions\\register\\POST"); // register new users
$API->register("/token", "GET", "Actions\\token\\GET"); // request token

$API->register("/user", "GET", "Actions\\user\\GET"); // get information about user
$API->register("/user/account", "GET", "Actions\\user\\account\\GET"); // get account information
$API->register("/user", "DELETE", "Actions\\user\\DELETE"); // delete single user
$API->register("/user/password", "POST", "Actions\\user\\password\\POST"); // change password of user
$API->register("/user/name", "POST", "Actions\\user\\name\\POST"); // change name of user
$API->register("/user/email", "POST", "Actions\\user\\email\\POST"); // change email of user
$API->register("/user/github", "POST", "Actions\\user\\github\\POST"); // change github name of user
$API->register("/user/permission", "POST", "Actions\\user\\permission\\POST"); // make user an admin
$API->register("/user/permission", "DELETE", "Actions\\user\\permission\\DELETE"); // make user an user
$API->register("/user/all", "GET", "Actions\\user\\all\\GET"); // get list of users

$API->register("/user/recovery", "POST", "Actions\\user\\recovery\\POST"); // Account recovery

$API->register("/idea", "DELETE", "Actions\\idea\\DELETE"); // delete single idea
$API->register("/idea", "POST", "Actions\\idea\\POST"); // add/update idea
$API->register("/idea", "GET", "Actions\\idea\\GET"); // get single idea
$API->register("/idea/top", "GET", "Actions\\idea\\top\\GET"); // list top ideas
$API->register("/idea/recent", "GET", "Actions\\idea\\recent\\GET"); // list recent ideas
$API->register("/idea/user", "GET", "Actions\\idea\\user\\GET"); // list all ideas of given user
$API->register("/idea/like", "GET", "Actions\\idea\\like\\GET"); // get all liked ideas of user
$API->register("/idea/save", "GET", "Actions\\idea\\save\\GET"); // get all saved ideas of user
$API->register("/idea/search", "GET", "Actions\\idea\\search\\GET"); // search for ideas
$API->register("/idea/following", "GET", "Actions\\idea\\following\\GET"); // get lates ideas of followers

$API->register("/idea/like", "POST", "Actions\\idea\\like\\POST"); // like an idea
$API->register("/idea/like", "DELETE", "Actions\\idea\\like\\DELETE"); // unlike an idea

$API->register("/idea/save", "POST", "Actions\\idea\\save\\POST"); // save an idea
$API->register("/idea/save", "DELETE", "Actions\\idea\save\\DELETE"); // unsave an idea

$API->register("/comment", "DELETE", "Actions\\comment\\DELETE"); // delete comment
$API->register("/comment", "POST", "Actions\\comment\\POST"); // add/update comment
$API->register("/idea/comments", "GET", "Actions\\idea\\comments\\GET"); // get comments for idea

$API->register("/comment/like", "POST", "Actions\\comment\\like\\POST"); // like a comment
$API->register("/comment/like", "DELETE", "Actions\\comment\\like\\DELETE"); // unlike a comment

$API->register("/user/follow", "POST", "Actions\\user\\follow\\POST"); // follow a user
$API->register("/user/follow", "DELETE", "Actions\\user\\follow\\DELETE"); // unfollow a user

$API->register("/info/tags", "GET", "Actions\\info\\tags\\GET"); // get list of all used tags
$API->register("/info/ideas", "GET", "Actions\\info\\ideas\\GET"); // get count of all ideas
$API->execute();