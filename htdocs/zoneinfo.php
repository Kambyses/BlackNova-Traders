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
// File: zoneinfo.php

include "config/config.php";
updatecookie ();

// New database driven language entries
load_languages($db, $lang, array('port', 'main', 'attack', 'zoneinfo', 'report', 'common', 'global_includes', 'global_funcs', 'footer', 'modify_defences'), $langvars, $db_logging);

$body_class = 'zoneinfo';
$title = $l_zi_title;
include "header.php";

if (checklogin () )
{
    die ();
}

bigtitle ();

$res = $db->Execute("SELECT * FROM {$db->prefix}ships WHERE email='$username'");
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);
$playerinfo = $res->fields;

$res = $db->Execute("SELECT * FROM {$db->prefix}zones WHERE zone_id='$zone'");
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);
$zoneinfo = $res->fields;

if ($res->EOF)
{
    echo $l_zi_nexist;
}
else
{
    $row = $res->fields;

    if ($zoneinfo['zone_id'] < 5)
    {
        $zonevar = "l_zname_" . $zoneinfo['zone_id'];
        $zoneinfo['zone_name'] = $$zonevar;
    }

    if ($row['zone_id'] == '2')
    {
        $ownername = $l_zi_feds;
    }
    elseif ($row['zone_id'] == '3')
    {
        $ownername = $l_zi_traders;
    }
    elseif ($row['zone_id'] == '1')
    {
        $ownername = $l_zi_nobody;
    }
    elseif ($row['zone_id'] == '4')
    {
        $ownername = $l_zi_war;
    }
    else
    {
        if ($row['corp_zone'] == 'N')
        {
            $result = $db->Execute("SELECT ship_id, character_name FROM {$db->prefix}ships WHERE ship_id=$row[owner]");
            db_op_result ($db, $result, __LINE__, __FILE__, $db_logging);
            $ownerinfo = $result->fields;
            $ownername = $ownerinfo['character_name'];
        }
        else
        {
            $result = $db->Execute("SELECT team_name, creator, id FROM {$db->prefix}teams WHERE id=$row[owner]");
            db_op_result ($db, $result, __LINE__, __FILE__, $db_logging);
            $ownerinfo = $result->fields;
            $ownername = $ownerinfo['team_name'];
        }
    }

    if ($row['allow_beacon'] == 'Y')
    {
        $beacon = $l_zi_allow;
    }
    elseif ($row['allow_beacon'] == 'N')
    {
        $beacon = $l_zi_notallow;
    }
    else
    {
        $beacon = $l_zi_limit;
    }

    if ($row['allow_attack'] == 'Y')
    {
        $attack = $l_zi_allow;
    }
    else
    {
        $attack = $l_zi_notallow;
    }

    if ($row['allow_defenses'] == 'Y')
    {
        $defense = $l_zi_allow;
    }
    elseif ($row['allow_defenses'] == 'N')
    {
        $defense = $l_zi_notallow;
    }
    else
    {
        $defense = $l_zi_limit;
    }

    if ($row['allow_warpedit'] == 'Y')
    {
        $warpedit = $l_zi_allow;
    }
    elseif ($row['allow_warpedit'] == 'N')
    {
        $warpedit = $l_zi_notallow;
    }
    else
    {
        $warpedit = $l_zi_limit;
    }

    if ($row['allow_planet'] == 'Y')
    {
        $planet = $l_zi_allow;
    }
    elseif ($row['allow_planet'] == 'N')
    {
        $planet = $l_zi_notallow;
    }
    else
    {
        $planet = $l_zi_limit;
    }

    if ($row['allow_trade'] == 'Y')
    {
        $trade = $l_zi_allow;
    }
    elseif ($row['allow_trade'] == 'N')
    {
        $trade = $l_zi_notallow;
    }
    else
    {
        $trade = $l_zi_limit;
    }

    if ($row['max_hull'] == 0)
    {
        $hull = $l_zi_ul;
    }
    else
    {
        $hull = $row['max_hull'];
    }

    if (($row['corp_zone'] == 'N' && $row['owner'] == $playerinfo['ship_id']) || ($row['corp_zone'] == 'Y' && $row['owner'] == $playerinfo['team'] && $playerinfo['ship_id'] == $ownerinfo['creator']))
    {
        echo "<center>$l_zi_control. <a href=zoneedit.php?zone=$zone>$l_clickme</a> $l_zi_tochange</center><p>";
    }

    echo "<table class=\"top\">\n" .
         "<tr><td class=\"zonename\"><strong>$row[zone_name]</strong></td></tr></table>\n" .
         "<table class=\"bottom\">\n" .
         "<tr><td class=\"name\">&nbsp;$l_zi_owner</td><td class=\"value\">$ownername&nbsp;</td></tr>\n" .
         "<tr><td>&nbsp;$l_beacons</td><td>$beacon&nbsp;</td></tr>\n" .
         "<tr><td>&nbsp;$l_att_att</td><td>$attack&nbsp;</td></tr>\n" .
         "<tr><td>&nbsp;$l_md_title</td><td>$defense&nbsp;</td></tr>\n" .
         "<tr><td>&nbsp;$l_warpedit</td><td>$warpedit&nbsp;</td></tr>\n" .
         "<tr><td>&nbsp;$l_planets</td><td>$planet&nbsp;</td></tr>\n" .
         "<tr><td>&nbsp;$l_title_port</td><td>$trade&nbsp;</td></tr>\n" .
         "<tr><td>&nbsp;$l_zi_maxhull</td><td>$hull&nbsp;</td></tr>\n" .
         "</table>\n";
}
echo "<br><br>";

TEXT_GOTOMAIN();
include "footer.php";
?>
