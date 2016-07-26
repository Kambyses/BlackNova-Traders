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
// File: includes/message_defence_owner.php

if (preg_match("/message_defence_owner.php/i", $_SERVER['PHP_SELF'])) {
      echo "You can not access this file directly!";
      die();
}

function message_defence_owner ($db, $sector, $message)
{
    $result3 = $db->Execute ("SELECT * FROM {$db->prefix}sector_defence WHERE sector_id=?", array($sector));
    db_op_result ($db, $result3, __LINE__, __FILE__);

    if ($result3 instanceof ADORecordSet)
    {
        while (!$result3->EOF)
        {
            playerlog ($db, $result3->fields['ship_id'], LOG_RAW, $message);
            $result3->MoveNext();
         }
     }
}
?>
