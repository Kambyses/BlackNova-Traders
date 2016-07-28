<?php

include_once __PUBLIC__ . "global_defines.php";
include_once __PUBLIC__ . "includes/timer.php";
include_once __PUBLIC__ . "includes/adminlog.php";
include_once __PUBLIC__ . "includes/bigtitle.php";
include_once __PUBLIC__ . "includes/bnt_autoload.php";
include_once __PUBLIC__ . "includes/calc_ownership.php";
include_once __PUBLIC__ . "includes/checklogin.php";
include_once __PUBLIC__ . "includes/collect_bounty.php";
include_once __PUBLIC__ . "includes/connectdb.php";
include_once __PUBLIC__ . "includes/db_kill_player.php";
include_once __PUBLIC__ . "includes/gen_score.php";
include_once __PUBLIC__ . "includes/get_avg_tech.php";
include_once __PUBLIC__ . "includes/load_languages.php";
include_once __PUBLIC__ . "includes/get_planet_owner.php";
include_once __PUBLIC__ . "includes/log_move.php";
include_once __PUBLIC__ . "includes/message_defence_owner.php";
include_once __PUBLIC__ . "includes/num_armor.php";
include_once __PUBLIC__ . "includes/num_beams.php";
include_once __PUBLIC__ . "includes/number.php";
include_once __PUBLIC__ . "includes/num_energy.php";
include_once __PUBLIC__ . "includes/num_fighters.php";
include_once __PUBLIC__ . "includes/num_holds.php";
include_once __PUBLIC__ . "includes/num_shields.php";
include_once __PUBLIC__ . "includes/num_torpedoes.php";
include_once __PUBLIC__ . "includes/player_insignia_name.php";
include_once __PUBLIC__ . "includes/playerlog.php";
include_once __PUBLIC__ . "includes/scan_error.php";
include_once __PUBLIC__ . "includes/scan_success.php";
include_once __PUBLIC__ . "includes/stripnum.php";
include_once __PUBLIC__ . "includes/text_gotologin.php";
include_once __PUBLIC__ . "includes/text_gotomain.php";
include_once __PUBLIC__ . "includes/t_port.php";
include_once __PUBLIC__ . "includes/updatecookie.php";
include_once __PUBLIC__ . "includes/db_op_result.php";

// Adodb handles database abstraction. We also use clob sessions, so that pgsql can be
// supported in the future, and cryptsessions, so the session data itself is encrypted.
require_once $ADOdbpath . "/adodb.inc.php";
include_once $ADOdbpath . "/adodb-perf.inc.php";
include_once $ADOdbpath . "/session/adodb-session.php";

spl_autoload_register('bnt_autoload');

require_once __PUBLIC__ . "global_cleanups.php";
