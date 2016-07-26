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
// File: footer.php

global $sched_ticks, $footer_show_time, $footer_show_debug, $db, $l;
$res = $db->Execute("SELECT COUNT(*) AS loggedin FROM {$db->prefix}ships WHERE (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP({$db->prefix}ships.last_login)) / 60 <= 5 AND email NOT LIKE '%@xenobe'");
db_op_result ($db, $res, __LINE__, __FILE__);

$row = $res->fields;
$online = $row['loggedin'];

global $BenchmarkTimer;
if (is_object ($BenchmarkTimer) )
{
    $stoptime = $BenchmarkTimer->stop();
    $elapsed = $BenchmarkTimer->elapsed();
    $elapsed = substr ($elapsed, 0, 5);
}
else
{
    $elapsed = 999;
}

// Suppress the news ticker on the IGB and index pages
if (!(preg_match("/index.php/i", $_SERVER['PHP_SELF']) || preg_match("/igb.php/i", $_SERVER['PHP_SELF'])))
{
    echo "<p></p>\n";
    echo "<script src='backends/javascript/newsticker.js'></script>\n";
    echo "<div id='news_ticker' class='faderlines'></div>\n";
    include "fader.php";
}

?><br>
 <div style='clear:both'></div><div style="text-align:center">
<?php
// Update counter

$res = $db->Execute("SELECT last_run FROM {$db->prefix}scheduler LIMIT 1");
db_op_result ($db, $res, __LINE__, __FILE__);
$result = $res->fields;
$mySEC = ($sched_ticks * 60) - (TIME () - $result['last_run']);
echo "<script src='backends/javascript/updateticker.js.php?mySEC={$mySEC}&amp;sched_ticks={$sched_ticks}'></script>";
echo "  <strong><span id=myx>$mySEC</span></strong> " . $l->get('l_footer_until_update') . " <br>\n";
// End update counter

if ($online == 1)
{
    echo "  ";
    echo $l->get('l_footer_one_player_on');
}
else
{
    echo "  " . $l->get('l_footer_players_on_1') . " " . $online . " " . $l->get('l_footer_players_on_2');
}
?>
</div><br>
<?php

if ($footer_show_time == true) // Make the SF logo a little bit larger to balance the extra line from the benchmark for page generation
{
    $sf_logo_type = '14';
}
else
{
    $sf_logo_type = '11';
}

if (preg_match("/index.php/i", $_SERVER['PHP_SELF']) || preg_match("/igb.php/i", $_SERVER['PHP_SELF']))
{
    $sf_logo_type++; // Make the SF logo darker for all pages except login
}

if (!isset($_GET['lang']))
{
    $link = '';
}
else
{
    $link = "?lang=" . $_GET['lang'];
}

echo "<div style='position:absolute; float:left; text-align:left'><a href='http://www.sourceforge.net/projects/blacknova'><img style='border:0;' src='http://sflogo.sourceforge.net/sflogo.php?group_id=14248&amp;type=" . $sf_logo_type . "' alt='Blacknova Traders at SourceForge.net'></a></div>";
echo "<div style='font-size:smaller; text-align:right'><a class='new_link' href='news.php" . $link . "'>" . $l->get('l_local_news') . "</a></div>";
echo "<div style='font-size:smaller; text-align:right'>&copy;2000-2012 Ron Harwood &amp; the BNT Dev team</div>";
if ($footer_show_debug == true)
{
    echo "<div style='font-size:smaller; text-align:right'>" . number_format($elapsed,2) . " " . $l->get('l_seconds') . " " . $l->get('l_time_gen_page') ." / " . floor(memory_get_peak_usage() / 1024) . $l->get('l_peak_mem') . "</div>";
}
?>
</body>
</html>
<?php ob_end_flush();?>
