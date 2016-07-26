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
// File: device.php

include "config/config.php";
updatecookie ();

// New database driven language entries
load_languages($db, $lang, array('device', 'common', 'global_includes', 'global_funcs', 'report', 'footer'), $langvars, $db_logging);

$title = $l_device_title;
$body_class = 'device';
include "header.php";

if ( checklogin () )
{
    die ();
}

$res = $db->Execute("SELECT * FROM {$db->prefix}ships WHERE email='$username'");
$playerinfo = $res->fields;

bigtitle ();

echo $l_device_expl . "<br><br>";
echo "<table style=\"width:33%\">";
echo "<tr><th style=\"text-align:left;\">$l_device</th><th>$l_qty</th><th>$l_usage</th></tr>";
echo "<tr>";
echo "<td><a href='beacon.php'>$l_beacons</A></td><td>" . NUMBER($playerinfo['dev_beacon']) . "</td><td>$l_manual</td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='warpedit.php'>$l_warpedit</A></td><td>" . NUMBER($playerinfo['dev_warpedit']) . "</td><td>$l_manual</td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='genesis.php'>$l_genesis</A></td><td>" . NUMBER($playerinfo['dev_genesis']) . "</td><td>$l_manual</td>";
echo "</tr>";
echo "<tr>";
echo "<td>$l_deflect</td><td>" . NUMBER($playerinfo['dev_minedeflector']) . "</td><td>$l_automatic</td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='mines.php?op=1'>$l_mines</A></td><td>" . NUMBER($playerinfo['torps']) . "</td><td>$l_manual</td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='mines.php?op=2'>$l_fighters</A></td><td>" . NUMBER($playerinfo['ship_fighters']) . "</td><td>$l_manual</td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='emerwarp.php'>$l_ewd</A></td><td>" . NUMBER($playerinfo['dev_emerwarp']) . "</td><td>$l_manual/$l_automatic</td>";
echo "</tr>";
echo "<tr>";
echo "<td>$l_escape_pod</td><td>" . (($playerinfo['dev_escapepod'] == 'Y') ? $l_yes : $l_no) . "</td><td>$l_automatic</td>";
echo "</tr>";
echo "<tr>";
echo "<td>$l_fuel_scoop</td><td>" . (($playerinfo['dev_fuelscoop'] == 'Y') ? $l_yes : $l_no) . "</td><td>$l_automatic</td>";
echo "</tr>";
echo "<tr>";
echo "<td>$l_lssd</td><td>" . (($playerinfo['dev_lssd'] == 'Y') ? $l_yes : $l_no) . "</td><td>$l_automatic</td>";
echo "</tr>";
echo "</table>";
echo "<br>";

TEXT_GOTOMAIN ();
include "footer.php";
?>
