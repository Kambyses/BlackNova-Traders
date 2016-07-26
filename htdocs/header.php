<?php
// Blacknova Traders - A web-based massively multiplayer space combat and trading game
// Copyright (C) 2001-2012 Ron Harwood and the BNT development team
//
//  This program is free software: you can redistribute it and/or modify
//  it under the terms of the GNU Affero General Public License as
//  published by the Free Software Foundation, either version 3 of the
//  License, or (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU Affero General Public License for more details.
//
//  You should have received a copy of the GNU Affero General Public License
//  along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
// File: header.php

header("Content-type: text/html; charset=utf-8");
header("X-UA-Compatible: IE=Edge, chrome=1");
header("Cache-Control: public"); // Tell the client (and any caches) that this information can be stored in public caches.
header("Connection: Keep-Alive"); // Tell the client to keep going until it gets all data, please.
header("Vary: Accept-Encoding, Accept-Language");
header("Keep-Alive: timeout=15, max=100");
if (!isset($body_class))
{
    $body_class = "bnt";
}

?>
<!DOCTYPE html>
<html lang="<?php echo $l->get('l_lang_attribute'); ?>">
<head>
<meta charset="utf-8">
<meta name="Description" content="A free online game - Open source, web game, with multiplayer space exploration">
<meta name="Keywords" content="Free, online, game, Open source, web game, multiplayer, space, exploration, blacknova, traders">
<meta name="Rating" content="General">
<link rel="shortcut icon" href="images/bntfavicon.ico">
<title><?php global $title; echo $title; ?></title>
<link rel='stylesheet' type='text/css' href='templates/classic/styles/main.css'>
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
</head>
<body class="<?php echo $body_class; ?>">
