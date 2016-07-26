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
// File: report.php

include "config/config.php";
updatecookie();

// New database driven language entries
load_languages($db, $lang, array('main', 'report', 'device', 'common', 'global_includes', 'global_funcs', 'footer'), $langvars, $db_logging);

$title = $l_report_title;
include "header.php";

if (checklogin())
{
    die();
}

$result = $db->Execute("SELECT * FROM {$db->prefix}ships WHERE email='$username'");
db_op_result ($db, $result, __LINE__, __FILE__, $db_logging);

$playerinfo=$result->fields;

$shiptypes[0]= "tinyship.png";
$shiptypes[1]= "smallship.png";
$shiptypes[2]= "mediumship.png";
$shiptypes[3]= "largeship.png";
$shiptypes[4]= "hugeship.png";

$shipavg = get_avg_tech($playerinfo, "ship");

if ($shipavg < 8)
   $shiplevel = 0;
elseif ($shipavg < 12)
   $shiplevel = 1;
elseif ($shipavg < 16)
   $shiplevel = 2;
elseif ($shipavg < 20)
   $shiplevel = 3;
else
   $shiplevel = 4;

bigtitle();

echo "<div style='width:90%; margin:auto; font-size:14px;'>\n";
echo "<table border=0 cellspacing=0 cellpadding=0 width='100%'>";
echo "<tr bgcolor=\"$color_header\"><td><strong>$l_player: $playerinfo[character_name]</strong></td><td align=center><strong>$l_ship: $playerinfo[ship_name]</strong></td><td align=right><strong>$l_credits: " . NUMBER($playerinfo['credits']) . "</strong></td></tr>";
echo "</table>";
echo "<br>";
echo "<table border=0 cellspacing=5 cellpadding=0  width='100%'>";
echo "<tr><td>";
echo "<table border=0 cellspacing=0 cellpadding=0 width=\"100%\">";
echo "<tr bgcolor=\"$color_header\"><td><strong>$l_ship_levels</strong></td><td></td></tr>";
echo "<tr bgcolor=\"$color_line1\" style='font-style:italic;'><td> $l_hull</td><td style='text-align:right;'>$l_level $playerinfo[hull]</td></tr>";
echo "<tr bgcolor=\"$color_line2\" style='font-style:italic;'><td> $l_engines</td><td style='text-align:right;'>$l_level $playerinfo[engines]</td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_power</td><td style='text-align:right;'>$l_level $playerinfo[power]</td></tr>";
echo "<tr bgcolor=\"$color_line2\" style='font-style:italic;'><td> $l_computer</td><td style='text-align:right;'>$l_level $playerinfo[computer]</td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_sensors</td><td style='text-align:right;'>$l_level $playerinfo[sensors]</td></tr>";
echo "<tr bgcolor=\"$color_line2\" style='font-style:italic;'><td> $l_armor</td><td style='text-align:right;'>$l_level $playerinfo[armor]</td></tr>";
echo "<tr bgcolor=\"$color_line1\" style='font-style:italic;'><td> $l_shields</td><td style='text-align:right;'>$l_level $playerinfo[shields]</td></tr>";
echo "<tr bgcolor=\"$color_line2\" style='font-style:italic;'><td> $l_beams</td><td style='text-align:right;'>$l_level $playerinfo[beams]</td></tr>";
echo "<tr bgcolor=\"$color_line1\" style='font-style:italic;'><td>$l_torp_launch</td><td style='text-align:right;'>$l_level $playerinfo[torp_launchers]</td></tr>";
echo "<tr bgcolor=\"$color_line2\"><td>$l_cloak</td><td style='text-align:right;'>$l_level $playerinfo[cloak]</td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td><i>$l_shipavg</i></td><td style='text-align:right;'>$l_level " . NUMBER($shipavg, 2) . "</td></tr>";
echo "</table>";
echo "</td><td Valign=TOP>";
echo "<table border=0 cellspacing=0 cellpadding=0 width=\"100%\">";
$holds_used = $playerinfo['ship_ore'] + $playerinfo['ship_organics'] + $playerinfo['ship_goods'] + $playerinfo['ship_colonists'];
$holds_max = NUM_HOLDS($playerinfo['hull']);
echo "<tr bgcolor=\"$color_header\"><td><strong>$l_holds</strong></td><td align=right><strong>" . NUMBER($holds_used) . " / " . NUMBER($holds_max) . "</strong></td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_ore</td><td align=right>" . NUMBER($playerinfo['ship_ore']) . "</td></tr>";
echo "<tr bgcolor=\"$color_line2\"><td>$l_organics</td><td align=right>" . NUMBER($playerinfo['ship_organics']) . "</td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_goods</td><td align=right>" . NUMBER($playerinfo['ship_goods']) . "</td></tr>";
echo "<tr bgcolor=\"$color_line2\"><td>$l_colonists</td><td align=right>" . NUMBER($playerinfo['ship_colonists']) . "</td></tr>";
echo "<tr><td>&nbsp;</td></tr>";
$armor_pts_max = NUM_ARMOR($playerinfo['armor']);
$ship_fighters_max = NUM_FIGHTERS($playerinfo['computer']);
$torps_max = NUM_TORPEDOES($playerinfo['torp_launchers']);
echo "<tr bgcolor=\"$color_header\"><td><strong>$l_arm_weap</strong></td><td></td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_armorpts</td><td align=right>" . NUMBER($playerinfo['armor_pts']) . " / " . NUMBER($armor_pts_max) . "</td></tr>";
echo "<tr bgcolor=\"$color_line2\"><td>$l_fighters</td><td align=right>" . NUMBER($playerinfo['ship_fighters']) . " / " . NUMBER($ship_fighters_max) . "</td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_torps</td><td align=right>" . NUMBER($playerinfo['torps']) . " / " . NUMBER($torps_max) . "</td></tr>";
echo "</table>";
echo "</td><td Valign=TOP>";
echo "<table border=0 cellspacing=0 cellpadding=0 width=\"100%\">";
$energy_max = NUM_ENERGY($playerinfo['power']);
echo "<tr bgcolor=\"$color_header\"><td><strong>$l_energy</strong></td><td align=right><strong>" . NUMBER($playerinfo['ship_energy']) . " / " . NUMBER($energy_max) . "</strong></td></tr>";
echo "<tr><td>&nbsp;</td></tr>";
echo "<tr bgcolor=\"$color_header\"><td><strong>$l_devices</strong></td><td></strong></td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_beacons</td><td align=right>$playerinfo[dev_beacon]</td></tr>";
echo "<tr bgcolor=\"$color_line2\"><td>$l_warpedit</td><td align=right>$playerinfo[dev_warpedit]</td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_genesis</td><td align=right>$playerinfo[dev_genesis]</td></tr>";
echo "<tr bgcolor=\"$color_line2\"><td>$l_deflect</td><td align=right>$playerinfo[dev_minedeflector]</td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_ewd</td><td align=right>$playerinfo[dev_emerwarp]</td></tr>";
$escape_pod = ($playerinfo['dev_escapepod'] == 'Y') ? $l_yes : $l_no;
$fuel_scoop = ($playerinfo['dev_fuelscoop'] == 'Y') ? $l_yes : $l_no;
$lssd = ($playerinfo['dev_lssd'] == 'Y') ? $l_yes : $l_no;
echo "<tr bgcolor=\"$color_line2\"><td>$l_escape_pod</td><td align=right>$escape_pod</td></tr>";
echo "<tr bgcolor=\"$color_line1\"><td>$l_fuel_scoop</td><td align=right>$fuel_scoop</td></tr>";
echo "<tr bgcolor=\"$color_line2\"><td>$l_lssd</td><td align=right>$lssd</td></tr>";
echo "</table>";
echo "</td></tr>";
echo "</table>";
echo "</div>\n";
echo "<p align=center>";
echo "<img src=\"images/$shiptypes[$shiplevel]\" border=0></p>";

TEXT_GOTOMAIN();
include "footer.php";
?>

