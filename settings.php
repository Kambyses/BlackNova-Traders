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
// File: settings.php

include "config/config.php";

if (!isset($_GET['lang']))
{
    $_GET['lang'] = null;
    $lang = $default_lang;
    $link = '';
}
else
{
    $lang = $_GET['lang'];
    $link = "?lang=" . $lang;
}

// New database driven language entries
load_languages($db, $lang, array('settings', 'common', 'global_includes', 'global_funcs', 'footer', 'news'), $langvars, $db_logging);

include "header.php";

$line_color = $color_line1;

function title($value, $align = "center")
{
    global $line_color, $color_line1, $color_line2;

    echo "<tr bgcolor=\"$line_color\"><td colspan=\"2\" style='text-align:{$align};'>{$value}</td></tr>\n";
    if ($line_color == $color_line1)
    {
        $line_color = $color_line2;
    }
    else
    {
        $line_color = $color_line1;
    }
}

function line($item, $value, $align = "left")
{
    global $line_color, $color_line1, $color_line2;

    echo "<tr bgcolor=\"$line_color\"><td>&nbsp;{$item}</td><td style='text-align:{$align};'>{$value}&nbsp;</td></tr>\n";
    if ($line_color == $color_line1)
    {
        $line_color = $color_line2;
    }
    else
    {
        $line_color = $color_line1;
    }
}

function line2($item, $value, $align = "left")
{
    global $line_color, $color_line1, $color_line2;

    echo "<tr bgcolor=\"$line_color\"><td style='border-left:1px #FFCC00 solid;'>&nbsp;{$item}</td><td style='text-align:{$align}; border-right:1px #FFCC00 solid;'>{$value}&nbsp;</td></tr>\n";
    if ($line_color == $color_line1)
    {
        $line_color = $color_line2;
    }
    else
    {
        $line_color = $color_line1;
    }
}

function line_a($value, $align = "left")
{
    global $line_color, $color_line1, $color_line2;

    echo "<tr bgcolor=\"#FFCC00\"><td colspan=\"2\" style='text-align:{$align};'>{$value}</td></tr>\n";
    if ($line_color == $color_line1)
    {
        $line_color = $color_line2;
    }
    else
    {
        $line_color = $color_line1;
    }
}

function line_spacer()
{
    global $line_color, $color_line1, $color_line2;

    echo "<tr><td colspan='2' style='height:2px; padding:0px;'></td></tr>\n";
    if ($line_color == $color_line1)
    {
        $line_color = $color_line2;
    }
    else
    {
        $line_color = $color_line1;
    }
}

/*
$title="Game Reset Information";
bigtitle();
echo "<table style='width:800px; font-size:14px; color:#fff; border:#fff 1px solid;' border='0' cellspacing='0' cellpadding='2'>";
line("Last Reset:","<span style='color:#ff0; font-size:14px;'>~ {$last_reset}</span>", "right");
line("Next Reset:","<span style='color:#ff0; font-size:14px;'>~ {$next_reset}</span>", "right");
line("Game Duration:", "<span style='color:#0f0; font-size:14px;'>$duration</span>", "right");
line("Game Status:", "<span style='color:#0f0; font-size:14px;'>". ucfirst($status['status']) ."</span>", "right");
line("Game Type:", "<span style='color:#0f0; font-size:14px;'>". ucfirst($status['type']) ."</span>", "right");
echo "</table>\n";
echo "<br>\n";
echo "<br>\n";
*/
$title="Game Administrators";
bigtitle();
$found_blues = 0;
foreach ($admin_list as $key => $admin)
{
    if ($admin['role'] === "developer" || $admin['role'] === "admin")
    {
        echo "<table style='width:800px; font-size:14px; color:#fff; border:#fff 1px solid;' border='0' cellspacing='0' cellpadding='2'>";
        line("Admin Name:",  "<span style='color:#ff0; font-size:14px;'>{$admin['name']}</span>", "right");
        line("Character:",  "<span style='color:#09f; font-size:14px;'>{$admin['character']}</span>", "right");
        line("Admin Level:", "<span style='color:#09f; font-size:14px;'>{$admin['level']}</span>", "right");
        line("Online:", "<span style='color:#99FF00; font-size:14px;'>Not Enabled</span>", "right");
        echo "</table>\n";
        echo "<br>\n";
        $found_blues +=1;
    }
}

if ($found_blues === 0)
{
    echo "<div style='width:798px; font-size:14px; color:#fff; background-color:#500050; padding-top:2px; padding-bottom:2px; border:#fff 1px solid;'>&nbsp;No Admins or Developers Found.</div>\n";
}
echo "<br>\n";

$title="Loaded Plugins";
bigtitle();

if (count($plugin_config) <=0)
{
    echo "<div style='width:798px; font-size:14px; color:#fff; background-color:#500050; padding-top:2px; padding-bottom:2px; border:#fff 1px solid;'>&nbsp;No Plugins enabled.</div>\n";
    echo "<br>\n";
}
else
{
   $plugin_id = 0;
   foreach ($plugin_config as $plugin_name => $plugin_switches)
   {
       if ($plugin_config[$plugin_name]['enabled'] == true && (isset($plugin_config[$plugin_name]['has_settings']) && $plugin_config[$plugin_name]['has_settings'] == true))
       {
           if (is_callable(array($$plugin_name, 'getPluginInfo')))
           {
               $plugin_id ++;
               $pluginInfo = call_user_func( array($$plugin_name, 'getPluginInfo') );
#              $pluginInfo = $$plugin_name->getPluginInfo();
               $pluginCount = count($pluginInfo['modules']);

               $plugin['id']            = "0x". str_pad($plugin_id, 4, "0", STR_PAD_LEFT);
               $plugin['type']            = $plugin_config[$plugin_name]['plugin_type'];

               $plugin['name']            = $pluginInfo['name'];
               $plugin['version']        = $pluginInfo['version'];
               $plugin['author']        = $pluginInfo['author'];

               if (isset($pluginInfo['isDisabled']) && $pluginInfo['isDisabled'] == true)
               {
                   $plugin['name'] .= " (<span style='color:#f00;'>Diasbled</span>)";
               }

               echo "<table style='width:800px; font-size:14px; color:#fff; border:#fff 1px solid;' border='0' cellspacing='0' cellpadding='2'>";
               $line_color = "#500050";
#              title("Plugin Type: {$plugin['title']}");
               line("ID:","<span style='color:#ff0; font-size:14px;'>{$plugin['id']}</span>", "right");
               line("Name:","<span style='color:#ff0; font-size:14px;'>{$plugin['name']}</span>", "right");
               line("Version:","<span style='color:#ff0; font-size:14px;'>v{$plugin['version']}</span>", "right");
               line("Author:", "<span style='color:#0f0; font-size:14px;'>{$plugin['author']}</span>", "right");
               line("Type:","<span style='color:#fff; font-size:14px;'>{$plugin['type']}</span>", "right");

               if ($pluginCount >0)
               {
                   line_spacer();$line_color = "#C0C0C0";
                   line_a("<span style='color:#000; font-size:10px; height:10px; padding:0px;'>Loaded {$pluginCount} Modules</span>", "center");
                   foreach ($pluginInfo['modules'] as $module_name => $module)
                   {
                       if (class_exists($module_name))
                       {
                           $module_disabled = null;
                           if (isset($module['isDisabled']) && $module['isDisabled'] == true)
                           {
                               $module_disabled = " (<span style='color:#f00;'>Diasbled</span>)";
                           }

                           $module_stage = null;
                           if (isset($module['stage']))
                           {
                               $module_stage = " [<span style='color:#ff0;'>{$module['stage']}</span>]";
                           }

                           line2("<span style='font-size:12px;'>{$module['AppName']}{$module_disabled}{$module_stage}</span>","<span style='color:#ff0; font-size:12px;'>v{$module['Version']} <span style='color:#fff;'>[<span style='color:#0f0;'>{$module['Author']}</span>]</span></span>", "right");
                       }
                   }
                   echo "<tr><td colspan=\"2\" style='height:1px; padding:0px; background-color:#FFCC00;'></td></tr>\n";
               }
           }
           echo "</table>\n";
           echo "<br>\n";
       }
   }
}

$title="Game Settings";
bigtitle();
echo "<table style='width:800px; font-size:14px; color:#fff; border:#fff 1px solid;' border='0' cellspacing='0' cellpadding='2'>";
line("Game version:",$release_version, "right");
line("Game name:",$game_name, "right");
line("Average tech level needed to hit mines",$mine_hullsize, "right");
line("Averaged Tech level When Emergency Warp Degrades",$ewd_maxhullsize, "right");

$num = NUMBER($sector_max);
line("Number of Sectors",$num, "right");
line("Maximum Links per sector",$link_max, "right");
line("Maximum average tech level for Federation Sectors",$fed_max_hull, "right");

$bank_enabled = $allow_ibank ? "Yes" : "No";
line("Intergalactic Bank Enabled",$bank_enabled, "right");

if ($allow_ibank)
{
    $rate = $ibank_interest * 100;
    line("IGB Interest rate per update",$rate, "right");

    $rate = $ibank_loaninterest * 100;
    line("IGB Loan rate per update",$rate, "right");
}
line("Tech Level upgrade for Bases",$basedefense, "right");

$num = NUMBER($colonist_limit);
line("Colonists Limit",$num, "right");

$num = NUMBER($max_turns);
line("Maximum number of accumulated turns",$num, "right");
line("Maximum number of planets per sector",$max_planets_sector, "right");
line("Maximum number of traderoutes per player",$max_traderoutes_player, "right");
line("Colonist Production Rate",$colonist_production_rate, "right");
line("Unit of Energy used per sector fighter",$energy_per_fighter, "right");

$rate = $defence_degrade_rate * 100;
line("Sector fighter degradation percentage rate",$rate, "right");
line("Number of planets with bases need for sector ownership&nbsp;",$min_bases_to_own, "right");

$rate = NUMBER(($interest_rate - 1) * 100 , 3);
line("Planet interest rate",$rate, "right");

$rate = 1 / $colonist_production_rate;

$num = NUMBER($rate/$fighter_prate);
line("Colonists needed to produce 1 Fighter each turn",$num, "right");

$num = NUMBER($rate/$torpedo_prate);
line("Colonists needed to produce 1 Torpedo each turn",$num, "right");

$num = NUMBER($rate/$ore_prate);
line("Colonists needed to produce 1 Ore each turn",$num, "right");

$num = NUMBER($rate/$organics_prate);
line("Colonists needed to produce 1 Organics each turn",$num, "right");

$num = NUMBER($rate/$goods_prate);
line("Colonists needed to produce 1 Goods each turn",$num, "right");

$num = NUMBER($rate/$energy_prate);
line("Colonists needed to produce 1 Energy each turn",$num, "right");

$num = NUMBER($rate/$credits_prate);
line("Colonists needed to produce 1 Credits each turn",$num, "right");
echo "</table>\n";
echo "<br>\n";
echo "<br>\n";

$title="Game Scheduler Settings";
bigtitle();

$line_color = $color_line1;

echo "<table style='width:800px; font-size:14px; color:#fff; border:#fff 1px solid;' border='0' cellspacing='0' cellpadding='2'>";
line("Ticks happen every","{$sched_ticks} minutes", "right");
line("{$turns_per_tick} Turns will happen every","{$sched_turns} minutes", "right");
line("Defenses will be checked every","{$sched_turns} minutes", "right");
line("Xenobes will play every","{$sched_turns} minutes", "right");

if ($allow_ibank)
{
    line("Interests on IGB accounts will be accumulated every&nbsp;", "{$sched_igb} minutes", "right");
}

line("News will be generated every","{$sched_news} minutes", "right");
line("Planets will generate production every","{$sched_planets} minutes", "right");
$use_new_sched_planet = true; // We merged this change in, so all new versions use this
line(" -> Using new Planet Update Code",($use_new_sched_planet?"<span style='color:#0f0;'>Yes</span>":"<span style='color:#ff0;'>No</span>"), "right");
line(" -> Limit captured planets Max Credits to {$max_credits_without_base}",($sched_planet_valid_credits?"<span style='color:#0f0;'>Yes</span>":"<span style='color:#ff0;'>No</span>"), "right");
line("Ports will regenerate x {$port_regenrate} every","{$sched_ports} minutes", "right");
line("Ships will be towed from fed sectors every","{$sched_turns} minutes", "right");
line("Rankings will be generated every","{$sched_ranking} minutes", "right");
line("Sector Defences will degrade every","{$sched_degrade} minutes", "right");
line("The planetary apocalypse will occur every&nbsp;","{$sched_apocalypse} minutes", "right");

echo "</table>";
echo "<br>\n";
echo "<br>\n";

if (empty($username))
{
    echo str_replace("[here]", "<a href='index.php" . $link . "'>" . $l->get('l_here') . "</a>", $l->get('l_global_mlogin'));
}
else
{
    echo str_replace("[here]", "<a href='main.php" . $link . "'>" . $l->get('l_here') . "</a>", $l->get('l_global_mmenu'));
}

include "footer.php";

?>
