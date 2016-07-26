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
// File: defence_report.php

include "config/config.php";
updatecookie();

// New database driven language entries
load_languages($db, $lang, array('defence_report', 'planet_report', 'main', 'device', 'port', 'modify_defences', 'common', 'global_includes', 'global_funcs', 'combat', 'footer', 'news'), $langvars, $db_logging);

$title = $l_sdf_title;
include "header.php";

if ( checklogin() )
{
    die ();
}

$res = $db->Execute("SELECT * FROM {$db->prefix}ships WHERE email='$username'");
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);
$playerinfo = $res->fields;

$query = "SELECT * FROM {$db->prefix}sector_defence WHERE ship_id=$playerinfo[ship_id]";
db_op_result ($db, $query, __LINE__, __FILE__, $db_logging);
if (!empty($sort))
{
    $query .= " ORDER BY";
    if ($sort == "quantity")
    {
        $query .= " quantity ASC";
    }
    elseif ($sort == "mode")
    {
        $query .= " fm_setting ASC";
    }
    elseif ($sort == "type")
    {
        $query .= " defence_type ASC";
    }
    else
    {
        $query .= " sector_id ASC";
    }
}

$res = $db->Execute($query);
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);

bigtitle ();

$i = 0;
if ($res)
{
    while (!$res->EOF)
    {
        $sector[$i] = $res->fields;
        $i++;
        $res->MoveNext();
    }
}

$num_sectors = $i;
if ($num_sectors < 1)
{
    echo "<br>" . $l_sdf_none;
}
else
{
    echo $l_pr_clicktosort . "<br><br>";
    echo "<table width=\"100%\" border=0 cellspacing=0 cellpadding=2>";
    echo "<tr bgcolor=\"$color_header\">";
    echo "<td><strong><a href=defence_report.php?sort=sector>$l_sector</a></strong></td>";
    echo "<td><strong><a href=defence_report.php?sort=quantity>$l_qty</a></strong></td>";
    echo "<td><strong><a href=defence_report.php?sort=type>$l_sdf_type</a></strong></td>";
    echo "<td><strong><a href=defence_report.php?sort=mode>$l_sdf_mode</a></strong></td>";
    echo "</tr>";
    $color = $color_line1;
    for ($i = 0; $i < $num_sectors; $i++)
    {
        echo "<tr bgcolor=\"$color\">";
        echo "<td><a href=rsmove.php?engage=1&destination=". $sector[$i]['sector_id'] . ">". $sector[$i]['sector_id'] ."</a></td>";
        echo "<td>" . NUMBER ($sector[$i]['quantity']) . "</td>";
        $defence_type = $sector[$i]['defence_type'] == 'F' ? $l_fighters : $l_mines;
        echo "<td> $defence_type </td>";
        $mode = $sector[$i]['defence_type'] == 'F' ? $sector[$i]['fm_setting'] : $l_n_a;
        if ($mode == 'attack')
        {
            $mode = $l_md_attack;
        }
        else
        {
            $mode = $l_md_toll;
        }

        echo "<td> " . $mode . " </td>";
        echo "</tr>";

        if ($color == $color_line1)
        {
            $color = $color_line2;
        }
        else
        {
            $color = $color_line1;
        }
    }
    echo "</table>";
}

echo "<br><br>";
TEXT_GOTOMAIN();
include "footer.php";
?>
