<?php

header("X-Frame-Options: DENY");
header("X-Xss-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("permissions-policy: autoplay=()");
header("referrer-policy: strict-origin-when-cross-origin");
header("x-frame-options: sameorigin");
header("content-security-policy: default-src https://nflstats.slevin.org.uk:443; script-src 'unsafe-inline'");
header("strict-transport-security: max-age=31536000");

?>

<!doctype html>
<html lang="en-GB">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Noel's NFL Dashboard</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="custom.css?ver=20220919.1">
  </head>
  <body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="/">Noel's NFL Dashboard</a>
        <button type="button" class="btn btn-light" onclick="window.location.reload();">Refresh</button>
      </div>
    </nav>

    <div class="container my-3 text-center">

<?php

// Retrieve JSON file and convert to array
$jsonobject = file_get_contents('http://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard');
$jsonarray = json_decode($jsonobject, true);

// Count the number of rows to cycle through
$num = count($jsonarray['events']);

// Cycle through the games 
for ($x = 0; $x < $num; $x+=1) {

// Initialise variables
$gamejson = NULL;
$hometeam = NULL;
$roadteam = NULL;
$hometeamname = NULL;
$roadteamname = NULL;
$hometeamshortname = NULL;
$roadteamshortname = NULL;
$hometeamcode = NULL;
$roadteamcode = NULL;
$hometeamid = NULL;
$roadteamid = NULL;
$homescore = NULL;
$roadscore = NULL;
$redzone = NULL;
$possessionteam = NULL;
$possessionteamname = NULL;
$gamestatus = NULL;
$gamestate = NULL;
$gamepassleader = NULL;
$gamepassleaderstats = NULL;
$gamerushleader = NULL;
$gamerushleaderstats = NULL;
$gamereceivingleader = NULL;
$gamereceivingleaderstats = NULL;
$gamedownanddistance = NULL;
$roadq1score = NULL;
$roadq2score = NULL;
$roadq3score = NULL;
$roadq4score = NULL;
$homeq1score = NULL;
$homeq2score = NULL;
$homeq3score = NULL;
$homeq4score = NULL;
$hometeamrecord = NULL;
$roadteamrecord = NULL;
$roadotscore = NULL;
$homeotscore = NULL;

  // Create an array of data for each game
  $gamejson = $jsonarray['events'][$x];

  // Find which team is home/road
  switch ($$gamejson['competitions'][0]['competitors'][0]['homeAway']) {
    case "home":
      $hometeam = 0;
      $roadteam = 1;
      break;
    case "away":
      $hometeam = 1;
      $roadteam = 0;
      break;
    // TODO: Throw exception in the default block
    default:
      $hometeam = 0;
      $roadteam = 1;
    }
  
  // Update the variables created earlier in the script
  $hometeamname = $gamejson['competitions'][0]['competitors'][$hometeam]['team']['name'];
  $roadteamname = $gamejson['competitions'][0]['competitors'][$roadteam]['team']['name'];
  $hometeamshortname = strtolower($gamejson['competitions'][0]['competitors'][$hometeam]['team']['name']);
  $roadteamshortname = strtolower($gamejson['competitions'][0]['competitors'][$roadteam]['team']['name']);
  $hometeamcode = $gamejson['competitions'][0]['competitors'][$hometeam]['team']['abbreviation'];
  $roadteamcode = $gamejson['competitions'][0]['competitors'][$roadteam]['team']['abbreviation'];
  $hometeamid = $gamejson['competitions'][0]['competitors'][$hometeam]['team']['id'];
  $roadteamid = $gamejson['competitions'][0]['competitors'][$roadteam]['team']['id'];
  $homescore = $gamejson['competitions'][0]['competitors'][$hometeam]['score'];
  $roadscore = $gamejson['competitions'][0]['competitors'][$roadteam]['score'];
  if ($gamejson['competitions'][0]['situation']['isRedZone'] == 'true') {
      $redzone = 1;
  }
  else {
      $redzone = 0;
  }
  $possessionteam = $gamejson['competitions'][0]['situation']['possession'];
  if ($possessionteam == $hometeamid) {
    $possessionteamname = $hometeamname;
  }
  elseif ($possessionteam == $roadteamid) {
    $possessionteamname = $roadteamname;
  }
  $gamestatus = $gamejson['status']['type']['detail'];
  $gamestate = $gamejson['status']['type']['state'];
  $gamepassleader = $gamejson['competitions'][0]['leaders'][0]['leaders'][0]['athlete']['fullName'];
  $gamepassleaderstats = $gamejson['competitions'][0]['leaders'][0]['leaders'][0]['displayValue'];
  $gamerushleader = $gamejson['competitions'][0]['leaders'][1]['leaders'][0]['athlete']['fullName'];
  $gamerushleaderstats = $gamejson['competitions'][0]['leaders'][1]['leaders'][0]['displayValue'];
  $gamereceivingleader = $gamejson['competitions'][0]['leaders'][2]['leaders'][0]['athlete']['fullName'];
  $gamereceivingleaderstats = $gamejson['competitions'][0]['leaders'][2]['leaders'][0]['displayValue'];
  $gamedownanddistance = $gamejson['competitions'][0]['situation']['downDistanceText'];
  $roadq1score = $gamejson['competitions'][0]['competitors'][$roadteam]['linescores'][0]['value'];
  $roadq2score = $gamejson['competitions'][0]['competitors'][$roadteam]['linescores'][1]['value'];
  $roadq3score = $gamejson['competitions'][0]['competitors'][$roadteam]['linescores'][2]['value'];
  $roadq4score = $gamejson['competitions'][0]['competitors'][$roadteam]['linescores'][3]['value'];
  $roadotscore = $gamejson['competitions'][0]['competitors'][$roadteam]['linescores'][4]['value'];
  $homeq1score = $gamejson['competitions'][0]['competitors'][$hometeam]['linescores'][0]['value'];
  $homeq2score = $gamejson['competitions'][0]['competitors'][$hometeam]['linescores'][1]['value'];
  $homeq3score = $gamejson['competitions'][0]['competitors'][$hometeam]['linescores'][2]['value'];
  $homeq4score = $gamejson['competitions'][0]['competitors'][$hometeam]['linescores'][3]['value'];
  $homeotscore = $gamejson['competitions'][0]['competitors'][$hometeam]['linescores'][4]['value'];
  $hometeamrecord = $gamejson['competitions'][0]['competitors'][$hometeam]['records'][0]['summary'];
  $roadteamrecord = $gamejson['competitions'][0]['competitors'][$roadteam]['records'][0]['summary'];


?>

      <div class="row border my-3 bg-white shadow py-3">
        <div class="col-lg-4">
        <table class="table table-borderless">
            <tr>
              <td class="bg-dark text-white"><strong><?php echo $gamestatus; ?></strong></td>
            </tr>
          </table>
          <table class="table table-borderless">
            <tr>
              <td width="25%"><img class="logo" src="/images/logos/<?php echo $roadteamshortname; ?>.png"></td>
              <td width="40%" class="align-middle text-start"><h3><?php echo $roadteamcode; ?></h3></td>
              <td width="20%" class="align-middle"><h3><?php echo $roadscore; ?></h3></td>
              <td width="15%" class="align-middle"><h3><?php if ($possessionteam == $roadteamid) { echo "🏈"; } ?></h3></td>
            </tr>
            <tr>
              <td><img class="logo" src="/images/logos/<?php echo $hometeamshortname; ?>.png"></td>
              <td class="align-middle text-start"><h3><?php echo $hometeamcode; ?></h3></td>
              <td class="align-middle"><h3><?php echo $homescore; ?></h3></td>
              <td><h3><?php if ($possessionteam == $hometeamid) { echo "🏈"; } ?></h3></td>
            </tr>
          </table>
          <?php if ($redzone == 1) { echo '<div class="bg-danger text-white py-2 my-2">Redzone</div>'; } ?>
        </div>
        <div class="col-lg-4">
        <table class="table table-borderless">
          <tr>
            <td class="bg-dark text-white"><strong>Game Summary</strong></td>
          </tr>
        </table>
        <?php if ($gamestate == "pre") {
          echo '<p class="text-start m-2">Information will appear when the game starts.</p>';
        } 
          echo '<div class="text-start m-2">';
          echo "<p>";
          if (isset($possessionteamname)) {
            echo "$possessionteamname have the ball, ";
          }
          echo "$gamedownanddistance</p>";
          if (isset($gamepassleader) && $gamestate != "pre") {
            echo "<strong>$gamepassleader:</strong> $gamepassleaderstats<br>";
          }
          if (isset($gamerushleader) && $gamestate != "pre") {
            echo "<strong>$gamerushleader:</strong> $gamerushleaderstats<br>";
          }
          if (isset($gamereceivingleader) && $gamestate != "pre") {
            echo "<strong>$gamereceivingleader:</strong> $gamereceivingleaderstats";
          }
          echo '</div>';
          ?>
        </div>
        <div class="col-lg-4">
        <table class="table table-borderless">
          <tr>
            <td class="bg-dark text-white"><strong>Team Stats</strong></td>
          </tr>
        </table>
        <table class="table">
          <tr>
            <th class="text-start">Team</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>OT</th>
            <th></th>
          </tr>
          <tr>
            <td class="text-start"><strong><?php echo $roadteamcode; ?></strong> (<?php echo $roadteamrecord; ?>)</td>
            <td><?php echo $roadq1score; ?></td>
            <td><?php echo $roadq2score; ?></td>
            <td><?php echo $roadq3score; ?></td>
            <td><?php echo $roadq4score; ?></td>
            <td><?php echo $roadotscore; ?></td>
            <td><strong><?php echo $roadscore; ?></strong></td>
          </tr>
          <tr>
            <td class="text-start"><strong><?php echo $hometeamcode; ?></strong> (<?php echo $hometeamrecord; ?>)</td>
            <td><?php echo $homeq1score; ?></td>
            <td><?php echo $homeq2score; ?></td>
            <td><?php echo $homeq3score; ?></td>
            <td><?php echo $homeq4score; ?></td>
            <td><?php echo $homeotscore; ?></td>
            <td><strong><?php echo $homescore; ?></strong></td>
          </tr>
        </table>
        </div>
      </div>

<?php

}

?>

    </div>
  </body>
</html>