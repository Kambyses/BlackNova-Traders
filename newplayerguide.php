<?php
include "config/config.php";
$title = "Blacknova Traders FAQ";
$body_class = 'faq';
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
include "header.php";
global $l; // The language object
?>
<table>
  <tbody>
  <tr>
    <td class=firstbar>BlackNova Traders New Players Guide</td></tr>
  <tr>
    <td class=secondbar>How to Play</td>
  </tr></tbody></table><br>
<table>
  <tbody>
  <tr>
    <td>
      <P>Welcome to the New Players Guide. You can always go back to the <A 
      href="faq.php">FAQ</A> if you came here by accident. Good luck in the game. 
</P></td></tr></tbody></table><br>
<table>
  <tbody>
  <tr>
    <td class=header>Introduction: </td></tr>
  <tr>
    <td>
      <P>Blacknova Traders is loosely based on the BBS game Tradewars. In this
      game, you are equipped with a basic ship with which you can trade goods between
      space ports to earn credits to upgrade your ship. Upgrades include larger cargo hulls
      so you can trade more in each turn (hence more money per turn), better weaponry, engines
      and sensors. You can also colonise planets, which will produce goods and money for you.
      <P>After the first fews days of trading, you need to decide on a strategy. Some general strategies are
      listed on the <A href="faq.php">FAQ</A> page. Its reccommended that you use the Trader up until about hull level 17 or so and then 
      switching over to the Builder. </P> 


      <P> Tradewars is a turn based game. Each action you take generally takes 1 turns. You start with an initial number of turns
       and get an extra turn every system update, which is dependant on the particular game you play. Generally its every 6 minutes,
       so roughly get 10 turns per hour.</P>
      <P> You navigate through the universe using either of 2 methods. The basic method is warp links. Warp links are like
       gateways between two different sectors in the universe. Regardless of the linear distance between 2 points, a 
       warp link will always only take 1 turn. Generally, consecutively numbered sectors will have a link between them,
       but this is not always the case. The second method is real space movement. Using real space, you use your ships engines
       to move between points in the universe. The bigger your engines, the faster you can go and so the quicker you can move
       between points in the universe and therefore the less turns you use. Initially, your engines will be low powered, so moving
       between sectors will take a huge number of turns, so it is not worth using real space movement early in the game.</P>
      <P>It's important to never take a link without making sure that 
      you can come back from the new sector, unless your realspace engines are big enough to get you back efficiently.
      There are a lot of one way links in this game. Try to stay away from them. Also, write down everywhere you go. 
      That way you can get back to sol when it's time to upgrade. 
      <OL>
        <LI>Special ports sell upgrades for your ships. Sector 0 is always a special port. Write down any other special ports you find.
        <LI>Different regions of the galaxy are governed by different rules. Federation space prevents any form of combat, so new players are safe in Federation space.
        You can tell what region you are in by looking in the top right corner of your screen.
        <LI>Try to find a goods or an ore port. Scan each sector from sol. If 
        there isn't one, move to sector 1 and keep trying. As soon as you find 
        an ore or a goods port, move there and trade. 
        <LI>Now try to find an opposing port adjacent to the port you are in. In 
        other words, if you first found a goods port, find an ore port next to 
        it. The important thing is to find two adjacent sectors with ore and 
        goods ports close to sol. This step may take anywhere from a couple to a 
        bunch of turns. I know that's vague, but the layout of the ports changes 
        every turn. The closer to sol you find the ports, the better. 
        <LI>Trade back and forth between these ports until you can afford an 
        upgrade. At this point, go back to sol and upgrade your hull. The bigger your hull, the more cargo you can carry and therefore the more money you can make in each turn. Go back to 
        the sectors you found and start trading again. 
        <LI>Keep doing this until you have a spare 100k credits. Use it to buy 
        an escape pod. Keep trading and upgrading your hull. 
        <LI>When you have a spare million, buy an Emergency Warp Device. Emergency Warp devices will move your ship to a random sector if you are attacked. Keep 
        upgrading your hull. You should be relatively unkillable at this point. Emergency warp devices become unreliable though when your hull reaches size 15.
        <LI>When you have the cash, buy more EWDs. For every EWD you buy, also 
        get a warp editor. That way, if you are attacked, you can create a one 
        way link back to sol (sector 0) and use it. You can't be stranded in the middle of 
        nowhere. This becomes un-necessary when your real space engines are large enough.
        <LI>Use traderoutes. Traderoutes help automate the task of trading. You can get your ship computer
        to move between 2 ports and trade the commodoties without you having to issue commands to move, trade etc. It still
        takes the same number of turns, but requires less work from you. Traderoutes can work on either real space or warp links. When you
        first start out, you will want to use warp links, so find sectors that are linked by warp links to trade between. Traderoutes can be one way
        or two ways. A two way traderoute means your ship will buy commodities from port A, sell them at port B, buy from port B then go back to port A and sell.
        <LI> Sector defences consist of mines and fighters. Mines are deployed torpedoes. Mines can only detect an incoming ship with a hull size greater than a certain level. Usually 8.
        Fighters can be set to one of two modes. Attack or Toll. In attack mode, they will attack any ship that does not belong to their owner or a member of their owners team. In toll mode,
        they will only let you enter the sector safely if you agree to pay a toll. Sector fighters require energy from a friendly planet to remain in the sector. If there is insufficient or no energy, they will slow
        break down. A defence against mines are mine deflectors. It is a good idea to carry a lot of these. They are cheap anyway. With fighters, you are given the options of fighting, retreating or using your ships cloaking
        device to try and sneak in to the sector. Sector fighters require energy from a friendly planet in the same sector, otherwise they begin to degrade. The default amount of energy required is 1 unit of energy per 10 ships. Energy can be taken from any of your planets or from a corporate planet from your team in that sector.
        <LI> Planets can created using a genesis torpedoe. Planets can produce commodoties and credits to fund your ship. The more colonists you have, the more they produce. You can use traderoutes to populate your planets from special ports.
        <LI>Now go to the regular <A 
        href="faq.php">FAQ</A> and pick 
        a strategy to follow. Or make up your own. </LI></OL>
      <P> Here's a list of things for new players NOT to do: 
      <OL>
        <LI>Don't scan people. Generally people scan others right before they attack.
        Don't scan their planets either. 
        <LI>Don't logout in a sector with other players or their planets. They 
        might assume you are scouting out locations for a bigger player and then 
        decide to kill you. 
        <LI>Don't attack anyone who is ranked higher than you. You will most 
        likely die in the attempt. </LI></OL>
</td></tr></tbody></table><br>
<table>
  <tbody>
  <tr>
    <td class=header>Some helpful hints: </td></tr>
  <tr>
    <td>
      <P>This is just a random listing of helpful hints. Most of them come from 
      the forums or the other top players. 
      <OL>
        <LI>Whenever you are choosing between two sectors, such as if you're in 
        a goods port sector and it connects to two different ore port sectors, 
        always choose the one that has more links. That way you'll have more 
        options on where to go next. 
        <LI>The game sets up all links in order plus random links. This means 
        that sector 152 has a link to sectors 151 and 153. If you find a sector 
        that is out of sequence, ie. you're in sector 456 and there's a link to 
        455 but not 457, it means that some player has purposefully destroyed 
        that link with a warp editor. Usually, but not always, something good is 
        hidden in or near that sector. 
        <LI>When you create a planet, use warp editors to destroy all of the 
        links heading into and out of the sector. Then make a one way link back 
        to the closest special. That way if people who can't realspace happen 
        into your sector they will be able to get out again. 
        <LI>When you create a planet, don't bother to name it. People are more 
        likely to assume that a planet named "unnamed" is actually empty. I tend 
        to name my smaller planets and leave the larger ones unnamed. It has 
        always worked out well for me. 
        <LI>Try to make friends with someone in the top 10. That way, if you are 
        attacked and defeated, chances are your new friend can exact 
        retribution. 
        <LI>If you don't use a utility to map where you've been, write down all 
        specials, planets and who own them, goods ports, and ore ports you run 
        across. It's nice to know where a new ore port.
</LI></OL></td></tr></tbody></table><br>
<table>
  <tbody>
  <tr>
    <td class=header>Glossary: </td></tr>
  <tr>
    <td>
      <P>
      <OL>
        <LI><B>creds</B>- short for credits. 
        <LI><B>EWD</B>- this is short for emergency warp device. 
        <LI><B>EWB burn</B>- when a player attacks another player specifically 
        to activate and EWD he is doing a "burn". 
        <LI><B>fits/torps</B>- short for fighters and torpedos. You see this 
        abbreviation in the forums all the time. 
        <LI><B>M or B or G</B>- M(mega) stands for a million. B(billion) and 
        G(giga, means billion) both mean a billion. In other words 4G creds 
        means you have 4 billion credits. 
        <LI><B>rs move</B>- this is just short for realspace move. It means 
        using your engines to move. 
        <LI><B>sol bump</B>- when you're above a certain level you automatically 
        get kicked out of federation space. People call this a sol bump. 
    </LI></OL></td></tr></tbody></table>

<?php
if (empty($username))
{
    echo str_replace("[here]", "<a href='index.php" . $link . "'>" . $l->get('l_here') . "</a>", $l->get('l_global_mlogin'));
}
else
{
    echo str_replace("[here]", "<a href='main.php" . $link . "'>" . $l->get('l_here') . "</a>", $l->get('l_global_mmenu'));
}
include "footer.php"; ?>

