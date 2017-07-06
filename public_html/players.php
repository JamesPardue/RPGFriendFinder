<?php 
//header('Cache-Control: no cache'); //no cache
//session_cache_limiter('private_no_expire'); // works
session_start();

//session_unset();
?>

<!DOCTYPE html>
<html>
<head>
    
<?php include 'head.php' ?>
    
</head>
<body onload="GetSearchResults('')">

<?php include 'header.php' ?>

<!-- SEARCH START -->
<div class="playersearch">
    <div class="playersheader">
        <div class="playerstitletext">Player Search</div>
        <div class="criteriacontainer">
            <div class="criteriabutton" onclick="ToggleDistanceCriteria()">Distance</div>
            <div class="criteriabutton" onclick="ToggleAvailabilityCriteria()">Availability</div>
            <div class="criteriabutton" onclick="ToggleSystemCriteria()">System</div>
            <div class="criteriabutton" onclick="TogglePlayStyleCriteria()">Play Style</div>
            <div class="criteriabutton" onclick="ToggleOtherCriteria()">Other</div>
			<div class="criteriabutton" onclick="ToggleSortCriteria()">Sort Results</div>
            <div style="clear: both"></div>
        </div>
        <form method="post" action="searchplayers.php">
            <!-- DISTANCE -->
            <div class="playercriteriacontainer 
                <?php if(isset($_SESSION['searchtab'])&&$_SESSION['searchtab']==0); else echo("criteriainvisable"); ?>" id="ID_distance">
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Distance
                    </div>
                    <div class="playercriteriaoptions">
                        <div class="profileedittext">
                            Zip Code
                        </div>
                        <select class="profileselect" name="distance" onchange='GetDistanceSearchResults(this)'>
                            <option value="dist_10" 
                                <?php if((isset($_SESSION["searchdist"]) && $_SESSION["searchdist"] == 10)) 
                                    echo "selected='selected'"; ?>>
                                Within 10 Miles
                            </option>
                            <option value="dist_25"
                                <?php if(isset($_SESSION["searchdist"]) && $_SESSION["searchdist"] == 25) echo "selected='selected'"; ?>>
                                Within 25 Miles
                            </option>
                            <option value="dist_50" 
                                <?php if(isset($_SESSION["searchdist"]) && $_SESSION["searchdist"] == 50) echo "selected='selected'"; ?>>
                                Within 50 Miles
                            </option>
                            <option value="dist_100" 
                                <?php if(isset($_SESSION["searchdist"]) && $_SESSION["searchdist"] == 100) echo "selected='selected'"; ?>>
                                Within 100 Miles
                            </option>
                            <option value="dist_any" 
                                <?php if(!isset($_SESSION["searchdist"]) || isset($_SESSION["searchdist"]) && $_SESSION["searchdist"] == 0) echo "selected='selected'"; ?>>
                                Any Distance
                            </option>
                        </select>
                        <input class="profilecriteriainput" id="ID_zipcode" type="text" name="location" size="25" maxlength="5" onkeyup="UpdateZipcodeSearch(this)"
                            <?php if(isset($_SESSION['searchlocation'])): ?>
                                value="<?php echo $_SESSION['searchlocation']; ?>"
                            <?php elseif(isset($_SESSION['location'])): ?>
                                value="<?php echo $_SESSION['location']; ?>"
                            <?php else: ?>
                                value=""
                            <?php endif; ?>
                            >
                    </div>
                </div>
            </div>
            <!-- AVAILABILITY -->
            <div class="playercriteriacontainer 
                <?php if(isset($_SESSION['searchtab'])&&$_SESSION['searchtab']==1); else echo("criteriainvisable"); ?>" id="ID_availability">
                <div class="playercriteria" id="ID_gametypecriteria">
                    <div class="playercriteriatitle">Game Type</div>
                    <div class="playercriteriaoptions" id="ID_gametypeoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="gametype_InPerson" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['gametype']) || (isset($_SESSION['gametype']) && $_SESSION['gametype'][0]=="0")); 
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">In Person</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="gametype_OnlineWebcam" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['gametype']) || (isset($_SESSION['gametype']) && $_SESSION['gametype'][1]=="0")); 
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Online (Webcam)</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="gametype_OnlineAudio" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['gametype']) || (isset($_SESSION['gametype']) && $_SESSION['gametype'][2]=="0")); 
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Online (Audio)</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="gametype_OnlineTextOnly" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['gametype']) || (isset($_SESSION['gametype']) && $_SESSION['gametype'][3]=="0")); 
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Online (Text Only)</label>
                    </div>
                </div>
                <div class="playercriteria">
                    <div class="playercriteriatitle">Play Rate</div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="rate_MoreThanOnceAWeek" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['playrate']) || (isset($_SESSION['playrate']) && $_SESSION['playrate'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">More than Once a Week</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="rate_Weekly" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['playrate']) || (isset($_SESSION['playrate']) && $_SESSION['playrate'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Weekly</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="rate_EveryTwoWeeks" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['playrate']) || (isset($_SESSION['playrate']) && $_SESSION['playrate'][2]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Every Two Weeks</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="rate_Monthly" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['playrate']) || (isset($_SESSION['playrate']) && $_SESSION['playrate'][3]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Monthly</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="rate_OnceInAWhile" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['playrate']) || (isset($_SESSION['playrate']) && $_SESSION['playrate'][4]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Once In A While</label>
                    </div>
                </div>
                <div class="playercriteria">
                    <table class="profileavailability searchavailabilitytable" >
                        <tr>
                            <th class="searchavailabilityheadcol">Availability</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                            <th>Sun</th>
                        </tr>
                        <tr>
                            <td class="headcol">Morning</td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Mon_Early" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['early']) || (isset($_SESSION['early']) && $_SESSION['early'][0]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Tue_Early" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['early']) || (isset($_SESSION['early']) && $_SESSION['early'][1]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Wed_Early" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['early']) || (isset($_SESSION['early']) && $_SESSION['early'][2]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Thu_Early" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['early']) || (isset($_SESSION['early']) && $_SESSION['early'][3]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Fri_Early" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['early']) || (isset($_SESSION['early']) && $_SESSION['early'][4]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Sat_Early" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['early']) || (isset($_SESSION['early']) && $_SESSION['early'][5]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Sun_Early" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['early']) || (isset($_SESSION['early']) && $_SESSION['early'][6]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="headcol">Afternoon</td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Mon_Afternoon" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['afternoon']) || (isset($_SESSION['afternoon']) && $_SESSION['afternoon'][0]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Tue_Afternoon" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['afternoon']) || (isset($_SESSION['afternoon']) && $_SESSION['afternoon'][1]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Wed_Afternoon" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['afternoon']) || (isset($_SESSION['afternoon']) && $_SESSION['afternoon'][2]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Thu_Afternoon" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['afternoon']) || (isset($_SESSION['afternoon']) && $_SESSION['afternoon'][3]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Fri_Afternoon" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['afternoon']) || (isset($_SESSION['afternoon']) && $_SESSION['afternoon'][4]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Sat_Afternoon" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['afternoon']) || (isset($_SESSION['afternoon']) && $_SESSION['afternoon'][5]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Sun_Afternoon" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['afternoon']) || (isset($_SESSION['afternoon']) && $_SESSION['afternoon'][6]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="headcol">Evening</td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Mon_Evening" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['evening']) || (isset($_SESSION['evening']) && $_SESSION['evening'][0]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Tue_Evening" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['evening']) || (isset($_SESSION['evening']) && $_SESSION['evening'][1]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Wed_Evening" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['evening']) || (isset($_SESSION['evening']) && $_SESSION['evening'][2]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Thu_Evening" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['evening']) || (isset($_SESSION['evening']) && $_SESSION['evening'][3]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Fri_Evening" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['evening']) || (isset($_SESSION['evening']) && $_SESSION['evening'][4]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Sat_Evening" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['evening']) || (isset($_SESSION['evening']) && $_SESSION['evening'][5]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Sun_Evening" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['evening']) || (isset($_SESSION['evening']) && $_SESSION['evening'][6]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="headcol">Late Night</td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Mon_Night" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['night']) || (isset($_SESSION['night']) && $_SESSION['night'][0]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Tue_Night" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['night']) || (isset($_SESSION['night']) && $_SESSION['night'][1]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Wed_Night" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['night']) || (isset($_SESSION['night']) && $_SESSION['night'][2]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Thu_Night" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['night']) || (isset($_SESSION['night']) && $_SESSION['night'][3]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Fri_Night" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['night']) || (isset($_SESSION['night']) && $_SESSION['night'][4]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Sat_Night" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['night']) || (isset($_SESSION['night']) && $_SESSION['night'][5]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                            <td>
                                <input class="profileavailabilitycheckbox" type="checkbox" name="avail_Sun_Night" value="1" onChange='GetSearchResults(this)'
                                    <?php if(!isset($_SESSION['night']) || (isset($_SESSION['night']) && $_SESSION['night'][6]=="0"));
                                        else echo "checked"; ?>>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- SYSTEM -->
            <div class="playercriteriacontainer 
                <?php if(isset($_SESSION['searchtab'])&&$_SESSION['searchtab']==2); else echo("criteriainvisable"); ?>" id="ID_system">
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Systems
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="system_OldSchool" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Old School/Old School Revival</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="system_DD3" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">D&amp;D 3.X/Pathfinder</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="system_DD4" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][2]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">D&amp;D 4</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="system_DD5" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][3]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">D&amp;D 5</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="system_PbtA" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][4]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">PbtA (Apoclypse World, Dungeon World, ...)</label>
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="system_WoD" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][5]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">World of Darkness (Vampire, Werewolf, ...)</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="system_BurningWheel" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][6]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Burning Wheel (Mouse Guard, Torch Bearer, ...</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="system_Other" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][7]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Other (Savage Worlds, GURPS, FATE, ...)</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="system_Hombrew" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][8]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Homebrew</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="system_BoardGames" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['system']) || (isset($_SESSION['system']) && $_SESSION['system'][9]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Board Games/MtG/Other Tabletop</label>
                    </div>
                </div>
            </div>
            <!-- PLAY STYLE -->
            <div class="playercriteriacontainer 
                <?php if(isset($_SESSION['searchtab'])&&$_SESSION['searchtab']==3); else echo("criteriainvisable"); ?>" id="ID_playstyle">
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Play Type
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="play_WillingGM" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['play']) || (isset($_SESSION['play']) && $_SESSION['play'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Willing to GM</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="play_WillingPlay" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['play']) || (isset($_SESSION['play']) && $_SESSION['play'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Willing to Play</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="play_Hangout" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['play']) || (isset($_SESSION['play']) && $_SESSION['play'][2]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Willing to Hangout</label>
                    </div>
                </div>
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Rules
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="rules_Written" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['rules']) || (isset($_SESSION['rules']) && $_SESSION['rules'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Rules as Written</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="rules_Interpreted" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['rules']) || (isset($_SESSION['rules']) && $_SESSION['rules'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Rules as Interpreted</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="rules_Suggested" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['rules']) || (isset($_SESSION['rules']) && $_SESSION['rules'][2]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Rules as Suggested</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="rules_HouseRules" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['rules']) || (isset($_SESSION['rules']) && $_SESSION['rules'][3]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">House Rules</label>
                    </div>
                </div>
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Style
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="style_Serious" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['style']) || (isset($_SESSION['style']) && $_SESSION['style'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Serious Roleplay</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="style_Silly" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['style']) || (isset($_SESSION['style']) && $_SESSION['style'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Silly Roleplay</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="style_Casual" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['style']) || (isset($_SESSION['style']) && $_SESSION['style'][2]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Casual Game</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="style_Power" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['style']) || (isset($_SESSION['style']) && $_SESSION['style'][3]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Power Gaming</label>
                    </div>
                </div>
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Genre
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="genre_Fantasy" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['genre']) || (isset($_SESSION['genre']) && $_SESSION['genre'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Fantasy</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="genre_SciFi" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['genre']) || (isset($_SESSION['genre']) && $_SESSION['genre'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Sci-Fi</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="genre_Horror" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['genre']) || (isset($_SESSION['genre']) && $_SESSION['genre'][2]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Horror</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="genre_Modern" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['genre']) || (isset($_SESSION['genre']) && $_SESSION['genre'][3]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Modern</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="genre_Western" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['genre']) || (isset($_SESSION['genre']) && $_SESSION['genre'][4]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Western</label>
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="genre_Historical" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['genre']) || (isset($_SESSION['genre']) && $_SESSION['genre'][5]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Historical</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="genre_PostApocolypse" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['genre']) || (isset($_SESSION['genre']) && $_SESSION['genre'][6]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Post-Apocolypse</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="genre_Superhero" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['genre']) || (isset($_SESSION['genre']) && $_SESSION['genre'][7]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Superhero</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="genre_Steampunk" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['genre']) || (isset($_SESSION['genre']) && $_SESSION['genre'][8]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Steampunk</label>
                    </div>
                </div>
            </div>
            <!-- OTHER -->
            <div class="playercriteriacontainer 
                <?php if(isset($_SESSION['searchtab'])&&$_SESSION['searchtab']==4); else echo("criteriainvisable"); ?>" id="ID_other">
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Tone
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="tone_PG13" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['tone']) || (isset($_SESSION['tone']) && $_SESSION['tone'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">PG-13</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="tone_R" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['tone']) || (isset($_SESSION['tone']) && $_SESSION['tone'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">R</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="tone_M" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['tone']) || (isset($_SESSION['tone']) && $_SESSION['tone'][2]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">M</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="tone_XXX" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['tone']) || (isset($_SESSION['tone']) && $_SESSION['tone'][3]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">XXX</label>
                    </div>
                </div>
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Other
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="other_Food" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['other']) || (isset($_SESSION['other']) && $_SESSION['other'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Food</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="other_Alcohol" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['other']) || (isset($_SESSION['other']) && $_SESSION['other'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Alcohol</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="other_Smoking" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['other']) || (isset($_SESSION['other']) && $_SESSION['other'][2]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Smoking</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="other_Drugs" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['other']) || (isset($_SESSION['other']) && $_SESSION['other'][3]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Drugs</label>
                    </div>
                </div>
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Age
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="age_LessThan20" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['age']) || (isset($_SESSION['age']) && $_SESSION['age'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Less than 20</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="age_20to30" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['age']) || (isset($_SESSION['age']) && $_SESSION['age'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">20 to 30</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="age_30to40" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['age']) || (isset($_SESSION['age']) && $_SESSION['age'][2]=="0"));
                                else echo "age"; ?>>
                        <label class="playercriterialabel">30 to 40</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="age_40to50" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['age']) || (isset($_SESSION['age']) && $_SESSION['age'][3]=="0"));
                                else echo "age"; ?>>
                        <label class="playercriterialabel">40 to 50</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="age_50to60" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['age']) || (isset($_SESSION['age']) && $_SESSION['age'][4]=="0"));
                                else echo "age"; ?>>
                        <label class="playercriterialabel">50 to 60</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="age_Over60" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['age']) || (isset($_SESSION['age']) && $_SESSION['age'][5]=="0"));
                                else echo "age"; ?>>
                        <label class="playercriterialabel">Over 60</label>
                    </div>
                </div>
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Gender
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="checkbox" name="gender_Man" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['gender']) || (isset($_SESSION['gender']) && $_SESSION['gender'][0]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Man</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="gender_Woman" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['gender']) || (isset($_SESSION['gender']) && $_SESSION['gender'][1]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Woman</label>
                        <br>
                        <input class="playercriteriacheckbox" type="checkbox" name="gender_Other" value="1" onChange='GetSearchResults(this)'
                            <?php if(!isset($_SESSION['gender']) || (isset($_SESSION['gender']) && $_SESSION['gender'][2]=="0"));
                                else echo "checked"; ?>>
                        <label class="playercriterialabel">Other</label>
                    </div>
                </div>
            </div>
			<!-- SORT -->
            <div class="playercriteriacontainer 
                <?php if(isset($_SESSION['searchtab'])&&$_SESSION['searchtab']==5); else echo("criteriainvisable"); ?>" id="ID_sort">
                <div class="playercriteria">
                    <div class="playercriteriatitle">
                        Sort Results
                    </div>
                    <div class="playercriteriaoptions">
                        <input class="playercriteriacheckbox" type="radio" name="sort" value="random" onChange='SortResults(this)'
                            <?php if(!isset($_SESSION['sort']) || (isset($_SESSION['sort']) && $_SESSION['sort']=="random")) echo "checked"; ?>>
                        <label class="playercriterialabel">Random</label>
                        <br>
                        <input class="playercriteriacheckbox" type="radio" name="sort" value="distance" onChange='SortResults(this)'
                            <?php if(isset($_SESSION['sort']) && $_SESSION['sort']=="distance") echo "checked"; ?>>
                        <label class="playercriterialabel">By Distance</label>
                        <br>
                        <input class="playercriteriacheckbox" type="radio" name="sort" value="lastvisit" onChange='SortResults(this)'
                            <?php if(isset($_SESSION['sort']) && $_SESSION['sort']=="lastvisit") echo "checked"; ?>>
                        <label class="playercriterialabel">By Last Visit</label>
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </form>
    </div>
    <div class="playerssection" id='ID_playerresults'>
        No Results
    </div>
</div>
<!-- RESULTS END -->

<?php include 'footer.php' ?>

<?php include 'js.php' ?>

<script>

var loadinghtml = "<div class=loader></div>";
    
var searchresults = "";
	
window.onscroll = function(ev) 
{
    if ((window.innerHeight + window.scrollY + 180) >= document.body.scrollHeight)
	{
		// you're at the bottom of the page
		AppendSearchResults();
    }
};

function AppendSearchResults()
{
	var length = searchresults.length;
	if(length != 0)
	{
		var endpos = searchresults.indexOf("<>");
		if(endpos != -1)
		{
			var append = searchresults.slice(0, endpos);
			searchresults = searchresults.slice(endpos + 2, length);
			document.getElementById('ID_playerresults').innerHTML += append;
		}
	}
}
	
function UpdateZipcodeSearch(source)
{    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = 
        function()
        {
            if (this.readyState == 4 && this.status == 200)
            {
				searchresults = this.responseText;
				document.getElementById('ID_playerresults').innerHTML = "";
                AppendSearchResults();
            }
        };
    document.getElementById('ID_playerresults').innerHTML = loadinghtml;
	
    var searchquery = "";
    var updatesearchvariable = "";
    var updatesearchvalue = "";
    
    if(source.value.length > 2 && Number.isInteger(parseInt(source.value)) && parseInt(source.value) > 99)
        updatesearchvalue = parseInt(source.value);
    else
        updatesearchvalue = 0;
    updatesearchvariable = source.name;
    searchquery = updatesearchvariable + '=' + updatesearchvalue;
    
    xmlhttp.open("POST", "searchplayers.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(searchquery);
}
    
function GetDistanceSearchResults(source)
{    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = 
        function()
        {
            if (this.readyState == 4 && this.status == 200)
            {
				searchresults = this.responseText;
				document.getElementById('ID_playerresults').innerHTML = "";
                AppendSearchResults();
            }
        };
	document.getElementById('ID_playerresults').innerHTML = loadinghtml;
	
    var searchquery = "";
    var updatesearchvariable = "";
    var updatesearchvalue = "";
    updatesearchvariable = source.name;
    updatesearchvalue = source.options[ source.selectedIndex ].value;
    searchquery = updatesearchvariable + '=' + updatesearchvalue;

    xmlhttp.open("POST", "searchplayers.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(searchquery);
}
    
function GetSearchResults(source)
{    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = 
        function()
        {
            if (this.readyState == 4 && this.status == 200)
            {
				searchresults = this.responseText;
				document.getElementById('ID_playerresults').innerHTML = "";
                AppendSearchResults();
            }
        };
    document.getElementById('ID_playerresults').innerHTML = loadinghtml;
    
    var searchquery = "";
    var updatesearchvariable = "";
    var updatesearchvalue = "";
    updatesearchvariable = source.name;
    if(source.checked)
        updatesearchvalue = 1;
    else
        updatesearchvalue = 0;
    searchquery = updatesearchvariable + '=' + updatesearchvalue;

    xmlhttp.open("POST", "searchplayers.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(searchquery);
}

function SortResults(source)
{    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = 
        function()
        {
            if (this.readyState == 4 && this.status == 200)
            {
				searchresults = this.responseText;
				document.getElementById('ID_playerresults').innerHTML = "";
                AppendSearchResults();
            }
        };
    document.getElementById('ID_playerresults').innerHTML = loadinghtml;
    
    var searchquery = "";
    var updatesearchvariable = source.name;
    var updatesearchvalue = source.value;
    searchquery = updatesearchvariable + '=' + updatesearchvalue;

    xmlhttp.open("POST", "searchplayers.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(searchquery);
}

function KeepSearchInfo()
{
	//Get current name/comment
	var zipcode = document.getElementById("ID_zipcode").value;
	
	//Set data to keepsessioninfo.php
	var xhttp;
	xhttp = new XMLHttpRequest();	
	xhttp.open("POST", "keepsearchinfo.php?zip="+zipcode, true);
	xhttp.send();
}
    
function EnableGameType(source)
{
    if(source.checked)
    {
        document.getElementsByName('gametype_InPerson')[0].disabled = false;
        document.getElementsByName('gametype_OnlineWebcam')[0].disabled = false;
        document.getElementsByName('gametype_OnlineAudio')[0].disabled = false;
        document.getElementsByName('gametype_OnlineTextOnly')[0].disabled = false;
        document.getElementById('ID_gametypecriteria').classList.remove("criteriagrey");
        document.getElementById('ID_gametypeoptions').classList.remove("criteriaoptionsgrey");
    }
    else
    {
        document.getElementsByName('gametype_InPerson')[0].disabled = true;
        document.getElementsByName('gametype_OnlineWebcam')[0].disabled = true;
        document.getElementsByName('gametype_OnlineAudio')[0].disabled = true;
        document.getElementsByName('gametype_OnlineTextOnly')[0].disabled = true;
        document.getElementById('ID_gametypecriteria').classList.add("criteriagrey");
        document.getElementById('ID_gametypeoptions').classList.add("criteriaoptionsgrey");
    }
}
    
function ToggleDistanceInput(source)
{
    if(source.selectedIndex == 4)
        document.getElementById("ID_zipcode").disabled = true;
    else
        document.getElementById("ID_zipcode").disabled = false;
}
    
function ToggleDistanceCriteria()
{
    document.getElementById('ID_distance').classList.toggle("criteriainvisable");
    document.getElementById('ID_availability').classList.add("criteriainvisable");
    document.getElementById('ID_system').classList.add("criteriainvisable");
    document.getElementById('ID_playstyle').classList.add("criteriainvisable");
    document.getElementById('ID_other').classList.add("criteriainvisable");
	document.getElementById('ID_sort').classList.add("criteriainvisable");
    
    //Set data to keepsessioninfo.php
	var xhttp;
	xhttp = new XMLHttpRequest();	
	xhttp.open("POST", "keepsearchtab.php?q="+0, true);
	xhttp.send();
}
    
function ToggleAvailabilityCriteria()
{
    document.getElementById('ID_availability').classList.toggle("criteriainvisable");
    document.getElementById('ID_distance').classList.add("criteriainvisable");
    document.getElementById('ID_system').classList.add("criteriainvisable");
    document.getElementById('ID_playstyle').classList.add("criteriainvisable");
    document.getElementById('ID_other').classList.add("criteriainvisable");
	document.getElementById('ID_sort').classList.add("criteriainvisable");
    
    //Set data to keepsessioninfo.php
	var xhttp;
	xhttp = new XMLHttpRequest();	
	xhttp.open("POST", "keepsearchtab.php?q="+1, true);
	xhttp.send();
}

function ToggleSystemCriteria()
{
    document.getElementById('ID_system').classList.toggle("criteriainvisable");
    document.getElementById('ID_distance').classList.add("criteriainvisable");
    document.getElementById('ID_availability').classList.add("criteriainvisable");
    document.getElementById('ID_playstyle').classList.add("criteriainvisable");
    document.getElementById('ID_other').classList.add("criteriainvisable");
	document.getElementById('ID_sort').classList.add("criteriainvisable");
    
    //Set data to keepsessioninfo.php
	var xhttp;
	xhttp = new XMLHttpRequest();	
	xhttp.open("POST", "keepsearchtab.php?q="+2, true);
	xhttp.send();
}
    
function TogglePlayStyleCriteria()
{
    document.getElementById('ID_playstyle').classList.toggle("criteriainvisable");
    document.getElementById('ID_distance').classList.add("criteriainvisable");
    document.getElementById('ID_availability').classList.add("criteriainvisable");
    document.getElementById('ID_system').classList.add("criteriainvisable");
    document.getElementById('ID_other').classList.add("criteriainvisable");
	document.getElementById('ID_sort').classList.add("criteriainvisable");
    
    //Set data to keepsessioninfo.php
	var xhttp;
	xhttp = new XMLHttpRequest();	
	xhttp.open("POST", "keepsearchtab.php?q="+3, true);
	xhttp.send();
}
    
function ToggleOtherCriteria()
{
    document.getElementById('ID_other').classList.toggle("criteriainvisable");
    document.getElementById('ID_distance').classList.add("criteriainvisable");
    document.getElementById('ID_availability').classList.add("criteriainvisable");
    document.getElementById('ID_system').classList.add("criteriainvisable");
    document.getElementById('ID_playstyle').classList.add("criteriainvisable");
	document.getElementById('ID_sort').classList.add("criteriainvisable");
    
    //Set data to keepsessioninfo.php
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.open("POST", "keepsearchtab.php?q="+4, true);
	xhttp.send();
}

function ToggleSortCriteria()
{
	document.getElementById('ID_sort').classList.toggle("criteriainvisable");
    document.getElementById('ID_distance').classList.add("criteriainvisable");
    document.getElementById('ID_availability').classList.add("criteriainvisable");
    document.getElementById('ID_system').classList.add("criteriainvisable");
    document.getElementById('ID_playstyle').classList.add("criteriainvisable");
	document.getElementById('ID_other').classList.add("criteriainvisable");
    
    //Set data to keepsessioninfo.php
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.open("POST", "keepsearchtab.php?q="+5, true);
	xhttp.send();
}
    
</script>    
    
</body>
</html>