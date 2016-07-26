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
// File: main.php

include "config/config.php";

// New database driven language entries
load_languages($db, $lang, array('common', 'global_includes'), $langvars, $db_logging);

updatecookie();

if (checklogin())
{
    die();
}

$title = $l->get('l_main_title');
include "header.php";

$stylefontsize = "12Pt";
$picsperrow = 7;

$res = $db->Execute("SELECT * FROM {$db->prefix}ships WHERE email='$username'");
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);
$playerinfo = $res->fields;

if ($playerinfo['cleared_defences'] > ' ')
{
    echo $l->get('l_incompletemove') . " <br>";
    echo "<a href=$playerinfo[cleared_defences]>" . $l->get('l_clicktocontinue') . "</a>";
    die();
}

$res = $db->Execute("SELECT * FROM {$db->prefix}universe WHERE sector_id='$playerinfo[sector]'");
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);
$sectorinfo = $res->fields;

if ($playerinfo['on_planet'] == "Y")
{
    $res2 = $db->Execute("SELECT planet_id, owner FROM {$db->prefix}planets WHERE planet_id=$playerinfo[planet_id]");
    db_op_result ($db, $res2, __LINE__, __FILE__, $db_logging);
    if ($res2->RecordCount() != 0)
    {
        echo "<a href=planet.php?planet_id=$playerinfo[planet_id]>" . $l->get('l_clickme') . "</a> " . $l->get('l_toplanetmenu') . "    <br>";
        header("Location: planet.php?planet_id=" . $playerinfo['planet_id'] . "&id=" . $playerinfo['ship_id']);
        die();
    }
    else
    {
        $db->Execute("UPDATE {$db->prefix}ships SET on_planet='N' WHERE ship_id=$playerinfo[ship_id]");
        echo "<br>" . $l->get('l_nonexistant_pl') . "<br><br>";
    }
}

$res = $db->Execute("SELECT * FROM {$db->prefix}links WHERE link_start='$playerinfo[sector]' ORDER BY link_dest ASC");
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);

$i = 0;
if ($res != false)
{
    while (!$res->EOF)
    {
        $links[$i] = $res->fields['link_dest'];
        $i++;
        $res->MoveNext();
    }
}
$num_links = $i;

$res = $db->Execute("SELECT * FROM {$db->prefix}planets WHERE sector_id='$playerinfo[sector]'");
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);

$i = 0;
if ($res != false)
{
    while (!$res->EOF)
    {
        $planets[$i] = $res->fields;
        $i++;
        $res->MoveNext();
    }
}
$num_planets = $i;

$res = $db->Execute("SELECT * FROM {$db->prefix}sector_defence,{$db->prefix}ships WHERE {$db->prefix}sector_defence.sector_id='$playerinfo[sector]'
                                                    AND {$db->prefix}ships.ship_id = {$db->prefix}sector_defence.ship_id ");
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);

$i = 0;
if ($res != false)
{
    while (!$res->EOF)
    {
        $defences[$i] = $res->fields;
        $i++;
        $res->MoveNext();
    }
}
$num_defences = $i;

$res = $db->Execute("SELECT zone_id,zone_name FROM {$db->prefix}zones WHERE zone_id='$sectorinfo[zone_id]'");
db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);
$zoneinfo = $res->fields;

$shiptypes[0]= "tinyship.png";
$shiptypes[1]= "smallship.png";
$shiptypes[2]= "mediumship.png";
$shiptypes[3]= "largeship.png";
$shiptypes[4]= "hugeship.png";

$planettypes[0]= "tinyplanet.png";
$planettypes[1]= "smallplanet.png";
$planettypes[2]= "mediumplanet.png";
$planettypes[3]= "largeplanet.png";
$planettypes[4]= "hugeplanet.png";

$signame = player_insignia_name ($db, $username);
echo "<div style='width:90%; margin:auto; background-color:#400040; color:#C0C0C0; text-align:center; border:#fff 1px solid; padding:4px;'>\n";
echo "{$signame} <span style='color:#fff; font-weight:bold;'>{$playerinfo['character_name']}</span>{$l->get('l_aboard')} <span style='color:#fff; font-weight:bold;'><a class='new_link' style='font-size:14px;' href='report.php'>{$playerinfo['ship_name']}</a></span>\n";
echo "</div>\n";

$result = $db->Execute("SELECT * FROM {$db->prefix}messages WHERE recp_id=? AND notified=?;", array($playerinfo['ship_id'], "N") );
db_op_result ($db, $result, __LINE__, __FILE__, $db_logging);
if ($result->RecordCount() > 0)
{
    $alert_message = "{$l->get('l_youhave')} {$result->RecordCount()}{$l->get('l_messages_wait')}";
    echo "<script>\n";
    echo "  alert('{$alert_message}');\n";
    echo "</script>\n";

    $res = $db->Execute("UPDATE {$db->prefix}messages SET notified='Y' WHERE recp_id=?;", array($playerinfo['ship_id']));
    db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);
}

$ply_turns        = NUMBER($playerinfo['turns']);
$ply_turnsused    = NUMBER($playerinfo['turns_used']);
$ply_score        = NUMBER($playerinfo['score']);
$ply_credits    = NUMBER($playerinfo['credits']);

echo "<table style='width:90%; margin:auto; text-align:center; border:0px;'>\n";
echo "  <tr>\n";
echo "    <td style='width:33%; text-align:left; color:#ccc; font-size:12px;'>&nbsp;{$l->get('l_turns_have')} <span style='color:#fff; font-weight:bold;'>{$ply_turns}</span></td>\n";
echo "    <td style='width:33%; text-align:center; color:#ccc; font-size:12px;'>{$l->get('l_turns_used')} <span style='color:#fff; font-weight:bold;'>{$ply_turnsused}</span></td>\n";
echo "    <td style='width:33%; text-align:right; color:#ccc; font-size:12px;'>{$l->get('l_score')} <span style='color:#fff; font-weight:bold;'>{$ply_score}&nbsp;</span></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td colspan='3' style='width:33%; text-align:right; color:#ccc; font-size:12px;'>&nbsp;{$l->get('l_credits')}: <span style='color:#fff; font-weight:bold;'>{$ply_credits}</span></td>\n";
echo "  </tr>\n";

echo "  <tr>\n";
echo "    <td style='text-align:left; color:#ccc; font-size:12px;'>&nbsp;{$l->get('l_sector')} <span style='color:#fff; font-weight:bold;'>{$playerinfo['sector']}</span></td>\n";
if (empty($sectorinfo['beacon']) || strlen(trim($sectorinfo['beacon'])) <=0)
{
    $sectorinfo['beacon'] = null;
}
echo "    <td style='text-align:center; color:#fff; font-size:12px; font-weight:bold;'>&nbsp;{$sectorinfo['beacon']}&nbsp;</td>\n";

if ($zoneinfo['zone_id'] < 5)
{
    $zonevar = "l_zname_" . $zoneinfo['zone_id'];
    $zoneinfo['zone_name'] = $$zonevar;
}

echo "    <td style='text-align:right; color:#ccc; font-size:12px; font-weight:bold;'><a class='new_link' href='zoneinfo.php?zone={$zoneinfo['zone_id']}'>{$zoneinfo['zone_name']}</a>&nbsp;</td>\n";
echo "  </tr>\n";
echo "</table>\n";

echo "<br>\n";

echo "<table style='width:90%; margin:auto; border:0px; border-spacing:0px;'>\n";
echo "  <tr>\n";
// Left Side.
echo "    <td style='width:200px; vertical-align:top; text-align:center;'>\n";

// Caption
echo "<table style='width:140px; border:0px; padding:0px; border-spacing:0px; margin-left:auto; margin-right:auto;'>\n";
echo "  <tr style='vertical-align:top'>\n";
echo "    <td style='padding:0px; width:8px;'><img style='border:0px; height:18px; width:8px; float:right;' src='images/lcorner.png' alt=''></td>\n";
echo "    <td style='padding:0px; white-space:nowrap; background-color:#400040; text-align:center; vertical-align:middle;'><strong style='font-size:0.75em; color:#fff;'>{$l->get('l_commands')}</strong></td>\n";
echo "    <td style='padding:0px; width:8px'><img style='border:0px; height:18px; width:8px; float:left;' src='images/rcorner.png' alt=''></td>\n";
echo "  </tr>\n";
echo "</table>\n";

// Menu
echo "<table style='width:150px; margin:auto; text-align:center; border:0px; padding:0px; border-spacing:0px'>\n";
echo "  <tr>\n";
echo "    <td style='white-space:nowrap; border:#fff 1px solid; background-color:#500050;'>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='device.php'>{$l->get('l_devices')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='planet_report.php'>{$l->get('l_planets')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='log.php'>{$l->get('l_log')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='defence_report.php'>{$l->get('l_sector_def')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='readmail.php'>{$l->get('l_read_msg')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='mailto2.php'>{$l->get('l_send_msg')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='ranking.php'>{$l->get('l_rankings')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='settings.php'>{$l->get('l_settings')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='teams.php'>{$l->get('l_teams')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='self_destruct.php'>{$l->get('l_ohno')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='options.php'>{$l->get('l_options')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='navcomp.php'>{$l->get('l_navcomp')}</a></div>\n";

if ($ksm_allowed == true)
{
    echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='galaxy.php'>{$l->get('l_map')}</a></div>\n";
}
echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td style='white-space:nowrap; height:2px; background-color:transparent;'></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td style='white-space:nowrap; border:#fff 1px solid; background-color:#500050;'>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='faq.php'>{$l->get('l_faq')}</a></div>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='feedback.php'>{$l->get('l_feedback')}</a></div>\n";
#echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='main.php' title='Not implemented'><span style='font-size:8px; color:#ff0; font-style:normal;'>NEW</span> Support</a></div>\n";
#echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='maint_info.php' title='This will display the Scheduled Maintenance information for this game or Core Code.'><span style='font-size:8px; color:#ff0; font-style:normal;'>NEW</span> Maint Info</a></div>\n";
#echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='rules.php' title='These are our Rules that you have agreed to.'><span style='font-size:8px; color:#ff0; font-style:normal;'>NEW</span> Our Rules</a></div>\n";
#echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='mail.php?mail={$username}' title='Request your login information to be emailed to you.'><span style='font-size:8px; color:#ff0; font-style:normal;'>TMP</span> REQ Password</a></div>\n";

if (!empty($link_forums))
{
    echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='{$link_forums}'>{$l->get('l_forums')}</a></div>\n";
}

echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td style='white-space:nowrap; height:2px; background-color:transparent;'></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td style='white-space:nowrap; border:#fff 1px solid; background-color:#500050;'>\n";
echo "      <div style='padding-left:4px; text-align:left;'><a class='mnu' href='logout.php'>{$l->get('l_logout')}</a></div>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br>\n";

// Caption
echo "<table style='width:140px; border:0px; padding:0px; border-spacing:0px; margin-left:auto; margin-right:auto;'>\n";
echo "  <tr style='vertical-align:top;'>\n";
echo "    <td style='padding:0px; width:8px;'><img style='width:8px; height:18px; border:0px; float:right;' src='images/lcorner.png' alt=''></td>\n";
echo "    <td style='padding:0px; white-space:nowrap; background-color:#400040; text-align:center; vertical-align:middle;'><strong style='font-size:0.75em; color:#fff;'>{$l->get('l_traderoutes')}</strong></td>\n";
echo "    <td style='padding:0px; width:8px;'><img style='width:8px; height:18px; border:0px; float:left;' src='images/rcorner.png' alt=''></td>\n";
echo "  </tr>\n";
echo "</table>\n";

// Menu
$i = 0;
$num_traderoutes = 0;

// Port querry
$query = $db->Execute("SELECT * FROM {$db->prefix}traderoutes WHERE source_type=? AND source_id=? AND owner=? ORDER BY dest_id ASC;", array("P", $playerinfo['sector'], $playerinfo['ship_id']) );
db_op_result ($db, $query, __LINE__, __FILE__, $db_logging);
while (!$query->EOF)
{
    $traderoutes[$i]=$query->fields;
    $i++;
    $num_traderoutes++;
    $query->MoveNext();
}

// Sector Defense Trade route query - this is still under developement
$query = $db->Execute("SELECT * FROM {$db->prefix}traderoutes WHERE source_type='D' AND source_id=$playerinfo[sector] AND owner=$playerinfo[ship_id] ORDER BY dest_id ASC");
db_op_result ($db, $query, __LINE__, __FILE__, $db_logging);
while (!$query->EOF)
{
    $traderoutes[$i]=$query->fields;
    $i++;
    $num_traderoutes++;
    $query->MoveNext();
}

// Personal planet traderoute type query
$query = $db->Execute("SELECT * FROM {$db->prefix}planets, {$db->prefix}traderoutes WHERE source_type='L' AND source_id={$db->prefix}planets.planet_id AND {$db->prefix}planets.sector_id=$playerinfo[sector] AND {$db->prefix}traderoutes.owner=$playerinfo[ship_id]");
db_op_result ($db, $query, __LINE__, __FILE__, $db_logging);
while (!$query->EOF)
{
    $traderoutes[$i]=$query->fields;
    $i++;
    $num_traderoutes++;
    $query->MoveNext();
}

// Team planet traderoute type query
$query = $db->Execute("SELECT * FROM {$db->prefix}planets, {$db->prefix}traderoutes WHERE source_type='C' AND source_id={$db->prefix}planets.planet_id AND {$db->prefix}planets.sector_id=$playerinfo[sector] AND {$db->prefix}traderoutes.owner=$playerinfo[ship_id]");
db_op_result ($db, $query, __LINE__, __FILE__, $db_logging);
while (!$query->EOF)
{
    $traderoutes[$i]=$query->fields;
    $i++;
    $num_traderoutes++;
    $query->MoveNext();
}

echo "<table style='width:150px; margin:auto; text-align:center; border:0px; padding:0px; border-spacing:0px;'>\n";
echo "  <tr>\n";
echo "    <td  style='white-space:nowrap; border:#fff 1px solid; background-color:#500050;'>\n";
if ($num_traderoutes == 0)
{
    echo "  <div style='text-align:center;'><a class='dis'>&nbsp;{$l->get('l_none')} &nbsp;</a></div>";
}
else
{
    $i=0;
    while ($i<$num_traderoutes)
    {
        echo "<div style='text-align:center;'>&nbsp;<a class=mnu href=traderoute.php?engage={$traderoutes[$i]['traderoute_id']}>";
        if ($traderoutes[$i]['source_type'] == 'P')
        {
            echo $l->get('l_port') . "&nbsp;";
        }
        elseif ($traderoutes[$i]['source_type'] == 'D')
        {
            echo "Def's ";
        }
        else
        {
            $query = $db->Execute("SELECT name FROM {$db->prefix}planets WHERE planet_id=?;", array($traderoutes[$i]['source_id']) );
            db_op_result ($db, $query, __LINE__, __FILE__, $db_logging);
            if (!$query || $query->RecordCount() == 0)
            {
                echo $l->get('l_unknown');
            }
            else
            {
                $planet = $query->fields;
                if ($planet['name'] == "")
                {
                    echo $l->get('l_unnamed') . " ";
                }
                else
                {
                    echo "$planet[name] ";
                }
            }
        }

        if ($traderoutes[$i]['circuit'] == '1')
        {
            echo "=&gt;&nbsp;";
        }
        else
        {
            echo "&lt;=&gt;&nbsp;";
        }

        if ($traderoutes[$i]['dest_type'] == 'P')
        {
            echo $traderoutes[$i]['dest_id'];
        }
        elseif ($traderoutes[$i]['dest_type'] == 'D')
        {
            echo "Def's in " .  $traderoutes[$i]['dest_id'] . "";
        }
        else
        {
            $query = $db->Execute("SELECT name FROM {$db->prefix}planets WHERE planet_id=" . $traderoutes[$i]['dest_id']);
            db_op_result ($db, $query, __LINE__, __FILE__, $db_logging);

            if (!$query || $query->RecordCount() == 0)
            {
                echo $l->get('l_unknown');
            }
            else
            {
                $planet = $query->fields;
                if ($planet['name'] == "")
                {
                    echo $l->get('l_unnamed');
                }
                else
                {
                    echo $planet['name'];
                }
            }
        }
        echo "</a>&nbsp;<br>";
        $i++;
        echo "</div>\n";
    }
}

echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td style='white-space:nowrap; height:2px; background-color:transparent;'></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td style='white-space:nowrap; border:#fff 1px solid; background-color:#500050;'>\n";
echo "      <div style='padding-left:4px; text-align:center;'><a class='mnu' href='traderoute.php'>{$l->get('l_trade_control')}</a></div>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br>\n";
echo "</td>\n";

echo "<td style='vertical-align:top;'>\n";
if ($sectorinfo['port_type'] != "none" && strlen($sectorinfo['port_type']) >0)
{
    echo "<div style='color:#fff; text-align:center; font-size:14px;'>\n";
    echo "{$l->get('l_tradingport')}:&nbsp;<span style='color:#0f0;'>". ucfirst(t_port($sectorinfo['port_type'])) ."</span>\n";
    echo "<br>\n";
    echo "<a class='new_link' style='font-size:14px;' href='port.php' title='Dock with Space Port'><img style='width:100px; height:70px;' class='mnu' src='images/space_station_port.png' alt='Space Station Port'></a>\n";
    echo "</div>\n";
}
else
{
    echo "<div style='color:#fff; text-align:center;'>{$l->get('l_tradingport')}&nbsp;{$l->get('l_none')}</div>\n";
}

echo "<br>\n";

// Put all the Planets into a div container and center it.
echo "<div style='margin-left:auto; margin-right:auto; text-align:center; border:transparent 1px solid;'>\n";
echo "<div style='text-align:center; font-size:12px; color:#fff; font-weight:bold;'>{$l->get('l_planet_in_sec')} {$sectorinfo['sector_id']}</div>\n";
echo "<table style='height:150px; text-align:center; margin:auto; border:0px'>\n";
echo "  <tr>\n";

if ($num_planets > 0)
{
    $totalcount=0;
    $curcount=0;
    $i=0;

    while ($i < $num_planets)
    {
        if ($planets[$i]['owner'] != 0)
        {
            $result5 = $db->Execute("SELECT * FROM {$db->prefix}ships WHERE ship_id=?;", array($planets[$i]['owner']) );
            db_op_result ($db, $result5, __LINE__, __FILE__, $db_logging);
            $planet_owner = $result5->fields;
            $planetavg = get_avg_tech($planet_owner, "planet");

            if ($planetavg < 8)
            {
                $planetlevel = 0;
            }
            else if ($planetavg < 12)
            {
                $planetlevel = 1;
            }
            else if ($planetavg < 16)
            {
                $planetlevel = 2;
            }
            else if ($planetavg < 20)
            {
                $planetlevel = 3;
            }
            else
            {
                $planetlevel = 4;
            }
        }
        else
        {
            $planetlevel=0;
        }

        echo "<td style='margin-left:auto; margin-right:auto; vertical-align:top; width:79px; height:90px; padding:4px;'>";
        echo "<a href='planet.php?planet_id={$planets[$i]['planet_id']}'>";
        echo "<img class='mnu' title='Interact with Planet' src=\"images/$planettypes[$planetlevel]\" style='width:79px; height:90px; border:0' alt=\"planet\"></a><br><span style='font-size:10px; color:#fff;'>";

        if (empty($planets[$i]['name']))
        {
            echo $l->get('l_unnamed');
        }
        else
        {
            echo $planets[$i]['name'];
        }

        if ($planets[$i]['owner'] == 0)
        {
            echo "<br>(" . $l->get('l_unowned') . ")";
        }
        else
        {
            echo "<br>($planet_owner[character_name])";
        }
        echo "</span></td>";

        $totalcount++;
        if ($curcount == $picsperrow - 1)
        {
            echo "</tr><tr>";
            $curcount=0;
        }
        else
        {
            $curcount++;
        }
        $i++;
    }
}
else
{
    echo "<td style='margin-left:auto; margin-right:auto; vertical-align:top'>";
    echo "<br><span style='color:white; size:1.25em'>" . $l->get('l_none') . "</span><br><br>";
}

echo "</tr>\n";
echo "</table>\n";
echo "</div>\n";

// Put all the Planets into a div container and center it.
echo "<div style='text-align:center; border:transparent 1px solid;'>\n";
echo "<div style='text-align:center; font-size:12px; color:#fff; font-weight:bold;'>{$l->get('l_ships_in_sec')} {$sectorinfo['sector_id']}</div>\n";

if ($playerinfo['sector'] != 0)
{
    $sql  = null;
    $sql .= "SELECT {$db->prefix}ships.*, {$db->prefix}teams.team_name, {$db->prefix}teams.id ";
    $sql .= "FROM {$db->prefix}ships LEFT OUTER JOIN {$db->prefix}teams ON {$db->prefix}ships.team = {$db->prefix}teams.id ";
    $sql .= "WHERE {$db->prefix}ships.ship_id<>$playerinfo[ship_id] AND {$db->prefix}ships.sector=$playerinfo[sector] AND {$db->prefix}ships.on_planet='N' ";
#    $sql .= "WHERE {$db->prefix}ships.sector=$playerinfo[sector] AND {$db->prefix}ships.on_planet='N' ";
    $sql .= "ORDER BY RAND();";
    $result4 = $db->Execute($sql);
    db_op_result ($db, $result4, __LINE__, __FILE__, $db_logging);

    if ($result4 != false )
    {
        $ships_detected = 0;
        $ship_detected = null;
        while (!$result4->EOF)
        {
            $row=$result4->fields;
            $success = SCAN_SUCCESS($playerinfo['sensors'], $row['cloak']);
            if ($success < 5)
            {
                $success = 5;
            }
            if ($success > 95)
            {
                $success = 95;
            }
            $roll = mt_rand(1, 100);

            if ($roll < $success)
            {
                $shipavg = get_avg_tech($row, "ship");

                if ($shipavg < 8)
                {
                    $shiplevel = 0;
                }
                else if ($shipavg < 12)
                {
                    $shiplevel = 1;
                }
                else if ($shipavg < 16)
                {
                    $shiplevel = 2;
                }
                else if ($shipavg < 20)
                {
                    $shiplevel = 3;
                }
                else
                {
                    $shiplevel = 4;
                }

                $row['shiplevel'] = $shiplevel;
                $ship_detected[] = $row;
                $ships_detected ++;
            }
            $result4->MoveNext();
        }
        if ($ships_detected <= 0)
        {
            echo "<div style='color:#fff;'>{$l->get('l_none')}</div>\n";
        }
        else
        {
            echo "<div style='padding-top:4px; padding-bottom:4px; width:500px; margin:auto; background-color:#303030;'>" . $l->get('l_main_ships_detected') . "</div>\n";
            echo "<div style='width:498px; margin:auto; overflow:auto; height:145px; scrollbar-base-color: #303030; scrollbar-arrow-color: #fff; padding:0px;'>\n";
            echo "<table style='padding:0px; border-spacing:1px;'>\n";
            echo "  <tr>\n";

            for ($iPlayer=0; $iPlayer < count($ship_detected); $iPlayer++)
            {
                echo "<td style='text-align:center; vertical-align:top; padding:1px;'>\n";
                echo "<div style='width:160px; height:120px; background: URL(images/bg_alpha.png) repeat; padding:1px;'>\n";
                echo "<a href=ship.php?ship_id={$ship_detected[$iPlayer]['ship_id']}>\n";
                echo "  <img class='mnu' title='Interact with Ship' src=\"images/", $shiptypes[$ship_detected[$iPlayer]['shiplevel']],"\" style='width:80px; height:60px; border:0px'>\n";
                echo "</a>\n";
                echo "<div style='font-size:12px; color:#fff; white-space:nowrap;'>{$ship_detected[$iPlayer]['ship_name']}<br>\n";
                echo "(<span style='color:#ff0; white-space:nowrap;'>{$ship_detected[$iPlayer]['character_name']}</span>)<br>\n";
                if ($ship_detected[$iPlayer]['team_name'])
                {
                    echo "(<span style='color:#0f0; white-space:nowrap;'>{$ship_detected[$iPlayer]['team_name']}</span>)\n";
                }
                echo "</div>\n";

                echo "</div>\n";
                echo "</td>\n";
            }
            echo "  </tr>\n";
            echo "</table>\n";
            echo "</div>\n";
        }
    }
    else
    {
        echo "<div style='color:#fff;'>{$l->get('l_none')}</div>\n";
    }
}
else
{
        echo "<div style='color:#fff;'>{$l->get('l_sector_0')}</div>\n";
}
echo "</div>";

if ($num_defences>0)
{
            echo "<div style='padding-top:4px; padding-bottom:4px; width:500px; margin:auto; background-color:#303030; text-align:center;'>" . $l->get('l_sector_def') . "</div>\n";
            echo "<div style='width:498px; margin:auto; overflow:auto; height:125px; scrollbar-base-color: #303030; scrollbar-arrow-color: #fff; padding:0px; text-align:center;'>\n";
}
?>
<table>
<tr>
<?php
if ($num_defences > 0)
{
    $totalcount=0;
    $curcount=0;
    $i=0;
    while ($i < $num_defences)
    {
        $defence_id = $defences[$i]['defence_id'];
        echo "<td style='vertical-align:top; background: URL(images/bg_alpha.png) repeat;'><div style=' width:160px; font-size:12px; '>";
        if ($defences[$i]['defence_type'] == 'F')
        {
            echo "<a class='new_link' href='modify_defences.php?defence_id=$defence_id'><img class='mnu' src=\"images/fighters.png\" style='border:0px' alt='Fighters'></a>\n";
            $def_type = $l->get('l_fighters');
            $mode = $defences[$i]['fm_setting'];
            if ($mode == 'attack')
            {
                $mode = $l->get('l_md_attack');
            }
            else
            {
                $mode = $l->get('l_md_toll');
            }
            $def_type .= $mode;
        }
        elseif ($defences[$i]['defence_type'] == 'M')
        {
            echo "<div><a href='modify_defences.php?defence_id=$defence_id'><img src=\"images/mines.png\" style='border:0px' alt='Mines'></a></div>\n";
            $def_type = $l->get('l_mines');
        }

        $char_name = $defences[$i]['character_name'];
        $qty = $defences[$i]['quantity'];
        echo "<div style='font-size:1em; color:#fff;'>$char_name<br>( $qty $def_type )</div>\n";
		echo "</div></td>";

        $totalcount++;
        if ($curcount == $picsperrow - 1)
        {
            echo "</tr><tr>";
            $curcount=0;
        }
        else
        {
            $curcount++;
        }
        $i++;
    }
    echo "</tr></table>";
echo "</div>\n";
}
else
{
    echo "<td style='vertical-align:top; text-align:center;'>";
    echo "</td></tr></table>";
}
?>
<br>
<td style='width:200px; vertical-align:top;'>

<?php
echo "<table style='width:140px; border:0; padding:0px; border-spacing:0px; margin-left:auto; margin-right:auto;'>\n";
echo "  <tr style='vertical-align:top'>\n";
echo "    <td style='padding:0px; width:8px; text-align:right;'><img style='width:8px; height:18px; border:0px; float:right;' src='images/lcorner.png' alt=''></td>\n";
echo "    <td style='padding:0px; white-space:nowrap; background-color:#400040; text-align:center; vertical-align:middle;'><span style='font-size:0.75em; color:#fff;'><strong>" . $l->get('l_cargo') . "</strong></span></td>\n";
echo "    <td style='padding:0px; width:8px; text-align:left;'><img style='width:8px; height:18px; border:0px; float:right;' src='images/rcorner.png' alt=''></td>\n";
echo "  </tr>\n";
echo "</table>\n";
?>

<table style='width:150px; border:0px; padding:0px; border-spacing:0px; margin-left:auto; margin-right:auto;'>
  <tr>
    <td style='white-space:nowrap; border:#fff 1px solid; background-color:#500050; padding:0px;'>
      <table style='width:100%; border:0px; background-color:#500050; padding:1px; border-spacing:0px; margin-left:auto; margin-right:auto;'>
        <tr>
          <td style='vertical-align:middle; white-space:nowrap; text-align:left;' >&nbsp;<img style='height:12px; width:12px;' alt="<?php echo $l->get('l_ore'); ?>" src="images/ore.png">&nbsp;<?php echo $l->get('l_ore'); ?>&nbsp;</td>
        </tr>
        <tr>
          <td style='vertical-align:middle; white-space:nowrap; text-align:right;'><span class=mnu>&nbsp;<?php echo NUMBER($playerinfo['ship_ore']); ?>&nbsp;</span></td>
        </tr>
        <tr>
          <td style='white-space:nowrap; text-align:left'>&nbsp;<img style='height:12px; width:12px;' alt="<?php echo $l->get('l_organics'); ?>" src="images/organics.png">&nbsp;<?php echo $l->get('l_organics'); ?>&nbsp;</td>
        </tr>
        <tr>
          <td style='white-space:nowrap; text-align:right'><span class=mnu>&nbsp;<?php echo NUMBER($playerinfo['ship_organics']); ?>&nbsp;</span></td>
        </tr>
        <tr>
          <td style='white-space:nowrap; text-align:left'>&nbsp;<img style='height:12px; width:12px;' alt="<?php echo $l->get('l_goods'); ?>" src="images/goods.png">&nbsp;<?php echo $l->get('l_goods'); ?>&nbsp;</td>
        </tr>
        <tr>
          <td style='white-space:nowrap; text-align:right'><span class=mnu>&nbsp;<?php echo NUMBER($playerinfo['ship_goods']); ?>&nbsp;</span></td>
        </tr>
        <tr>
          <td style='white-space:nowrap; text-align:left'>&nbsp;<img style='height:12px; width:12px;' alt="<?php echo $l->get('l_energy'); ?>" src="images/energy.png">&nbsp;<?php echo $l->get('l_energy'); ?>&nbsp;</td>
        </tr>
        <tr>
          <td style='white-space:nowrap; text-align:right;'><span class=mnu>&nbsp;<?php echo NUMBER($playerinfo['ship_energy']); ?>&nbsp;</span></td>
        </tr>
        <tr>
          <td style='white-space:nowrap; text-align:left;'>&nbsp;<img style='height:12px; width:12px;' alt="<?php echo $l->get('l_colonists'); ?>" src="images/colonists.png">&nbsp;<?php echo $l->get('l_colonists'); ?>&nbsp;</td>
        </tr>
        <tr>
          <td style='white-space:nowrap; text-align:right;'><span class=mnu>&nbsp;<?php echo NUMBER($playerinfo['ship_colonists']); ?>&nbsp;</span></td>
        </tr>
      </table>
    </td>
   </tr>
</table>
<br>

<?php
echo "<table style='width:140px; border:0px; padding:0px; border-spacing:0px; margin-left:auto; margin-right:auto;'>\n";
echo "  <tr style='vertical-align:top'>\n";
echo "    <td style='padding:0px; width:8px; text-align:right'><img style='width:8px; height:18px; border:0px; float:right;' src='images/lcorner.png' alt=''></td>\n";
echo "    <td style='padding:0px; white-space:nowrap; background-color:#400040; text-align:center; vertical-align:middle;'><span style='font-size:0.75em; color:#fff'><strong>" . $l->get('l_realspace') . "</strong></span></td>\n";
echo "    <td style='padding:0px; width:8px; text-align:left'><img style='width:8px; height:18px; border:0px; float:left;' src='images/rcorner.png' alt=''></td>\n";
echo "  </tr>\n";
echo "</table>\n";
?>

<table style='width:150px; border:0px; padding:0px; border-spacing:0px; margin-left:auto; margin-right:auto;'>
<tr><td  style='white-space:nowrap; border:#fff 1px solid; background-color:#500050; padding:0px;'>

<table style="width:100%;">
<tr>
  <td style="text-align:left;"><a class=mnu href="rsmove.php?engage=1&amp;destination=<?php echo $playerinfo['preset1']; ?>">=&gt;&nbsp;<?php echo $playerinfo['preset1']; ?></a></td>
  <td style="text-align:right;">[<a class=mnu href=preset.php><?php echo ucwords($l->get('l_set')); ?></a>]</td>
</tr>
<tr>
  <td style="text-align:left;"><a class=mnu href="rsmove.php?engage=1&amp;destination=<?php echo $playerinfo['preset2']; ?>">=&gt;&nbsp;<?php echo $playerinfo['preset2']; ?></a></td>
  <td style="text-align:right;">[<a class=mnu href=preset.php><?php echo ucwords($l->get('l_set')); ?></a>]</td>
</tr>
<tr>
  <td style="text-align:left;"><a class=mnu href="rsmove.php?engage=1&amp;destination=<?php echo $playerinfo['preset3']; ?>">=&gt;&nbsp;<?php echo $playerinfo['preset3']; ?></a></td>
  <td style="text-align:right;">[<a class=mnu href=preset.php><?php echo ucwords($l->get('l_set')); ?></a>]</td>
</tr>
</table>
</td></tr>
<?php
echo "  <tr>\n";
echo "    <td style='white-space:nowrap; height:2px; background-color:transparent;'></td>\n";
echo "  </tr>\n";
?>
<tr><td  style='white-space:nowrap; border:#fff 1px solid; background-color:#500050;'>
&nbsp;<a class=mnu href="rsmove.php">=&gt;&nbsp;<?php echo $l->get('l_main_other');?></a>&nbsp;<br>
</td></tr>
</table>
<br>

<?php
echo "<table style='width:140px; border:0px; padding:0px; border-spacing:0px;margin-left:auto; margin-right:auto;'>\n";
echo "  <tr style='vertical-align:top'>\n";
echo "    <td style='padding:0px; width:8px; float:right;'><img style='width:8px; height:18px; border:0px; float:right' src='images/lcorner.png' alt=''></td>\n";
echo "    <td style='padding:0px; white-space:nowrap; background-color:#400040; text-align:center; vertical-align:middle;'><span style='font-size:0.75em; color:#fff;'><strong>" . $l->get('l_main_warpto') . "</strong></span></td>\n";
echo "    <td style='padding:0px; width:8px; float:left;'><img style='width:8px; height:18px; border:0px; float:left;' src='images/rcorner.png' alt=''></td>\n";
echo "  </tr>\n";
echo "</table>\n";
?>

<table style='width:150px; border:0px; padding:0px; border-spacing:0px; margin-left:auto; margin-right:auto;'>
<tr><td style='white-space:nowrap; border:#fff 1px solid; background-color:#500050; text-align:center; padding:0px;'>
<div class=mnu>

<?php

if (!$num_links)
{
    echo "&nbsp;<a class=dis>" . $l->get('l_no_warplink') . "</a>&nbsp;<br>";
}
else
{
    echo "<table style='width:100%;'>\n";
    for ($i = 0; $i < $num_links; $i++)
    {
#        echo "&nbsp;<a class=\"mnu\" href=\"move.php?sector=$links[$i]\">=&gt;&nbsp;$links[$i]</a>&nbsp;<a class=dis href=\"lrscan.php?sector=$links[$i]\">[" . $l->get('l_scan') . "]</a>&nbsp;<br>";

        echo "<tr>\n";
        echo "  <td style='text-align:left;'><a class='mnu' href='move.php?sector={$links[$i]}'>=&gt;&nbsp;$links[$i]</a></td>\n";
        echo "  <td style='text-align:right;'>[<a class='mnu' href='lrscan.php?sector={$links[$i]}'>" . $l->get('l_scan') . "</a>]</td>\n";
        echo "</tr>\n";
    }
    echo "</table>\n";
}
echo "</div>";
echo "</td></tr>";
echo "  <tr>\n";
echo "    <td style='white-space:nowrap; height:2px; background-color:transparent;'></td>\n";
echo "  </tr>\n";
echo "<tr><td style='white-space:nowrap; border:#fff 1px solid; background-color:#500050; text-align:center;'>";
echo "<div class=mnu>";
echo "&nbsp;<a class=dis href=\"lrscan.php?sector=*\">[" . $l->get('l_fullscan') . "]</a>&nbsp;<br>";
?>

</div>
</td></tr>
</table>
</td>
</tr>
</table>

<?php

include "footer.php";
?>
