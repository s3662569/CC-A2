<?php
session_start();
putenv('My First Project-4ea46c8c82fe.json');

require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

# Your Google Cloud Platform project ID
$projectId = 's3721471-cc2020';

# Instantiates a client
$datastore = new DatastoreClient([
  'projectId' => $projectId
]);

$kind1 = 'song';
$kind2 = 'artist';

// array setup for songs
$sList = array();
$saList = array();
$lList = array();

for ($i = 1; $i < 11; ++$i) {
  $id = $datastore->key($kind1, 's' . $i);
  $s = $datastore->lookup($id);
  $sTitle = $s['title'];
  $sArtist = $s['artist'];
  $sListen = $s['listened'];
  array_push($sList, $sTitle);
  array_push($saList, $sArtist);
  array_push($lList, $sListen);
}

// array setup for artists
$aList = array();
$alList = array();

for ($i = 1; $i < 11; ++$i) {
  $id = $datastore->key($kind2, 'a' . $i);
  $a = $datastore->lookup($id);
  $aArtist = $a['artist'];
  $aListen = $a['listened'];
  array_push($aList, $aArtist);
  array_push($alList, $aListen);
}
?>

<html>

<head>
  <meta charset="utf-8">
  <title>Main Page</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='stylesheet' type='text/css' href='/css/style.css'>
</head>

<body>
  <h1>ListenBrainz Analysis</h1>

  <table class="info">
    <tr>
      <td rowspan="2">
        <img src="https://storage.cloud.google.com/a2-s3721471-bucket/listenbrainz_logo.jpg" alt="ListenBrainz Logo" width="250" height="300">
        <p>
          ListenBrainz is a open source project which publishes data publically for everyone to access.
          The purpose of all this is to allow developers like us to access data about what songs and artists
          people listen to whilst using this software. By collating and collecting this data into a public data set,
          it can become a reference point for developers who wish to create music recommendations for their users.
          In our case, we decided to create graphs to display ListenBrainz's collected data to gain a better understanding
          of the songs and artists their users have been listening to.
        </p>
        <p>
          The website is mainly an
          informative page of information such as popular songs
          and popular artists over the years. It provides users
          with data represented as graphs such as bar and pie charts
          for clarity to easily understand the relevant information.
          It utilises Google Cloud services such as BigQuery and Google Datastore
          to query (find) information from a public database and store it in a datastore.
          By gathering large portions of data and condensing it into smaller pieces of
          information to display allows quick and easy analysis for users to see.
        </p>
        <p>
          Moving along into the technological age, walkmans, vinyl disks are slowly
          becoming obsolete as music starts to shift towards online services where it is
          more accessible by everyone. Similarly, music is now being sold online through websites as well as being streamed online.
          This website can provide users with a quick analysis of the trending bands from the past few years based off of ListenBrainz data.
        </p>
        <br>
        <p>
          Figure 1 displays the top 10 songs listened based on ListenBrainz's database (from years 2006-2018).
          The top most listened song is actually a sound track from a game called
          <a target="_blank" href="https://en.wikipedia.org/wiki/The_Legend_of_Zelda:_Ocarina_of_Time">Legend of Zelda: Ocarina of Time</a>
          , released back in 1998, composed by a Japanese musician named Koji Kondo which has been listened over the course of 12 years. 
          Similarly, in 2nd spot is another soundtrack composed by a musician for video games and from 3rd onwards are all Pop/Rock songs 
          by famous bands such as Nirvana and Led Zeppelin.
        </p>
        <br>
        <p>
          For Figure 2, it displays the top 10 artists/bands that people of ListenBrainz listen to. Topping the leaderboard is Radiohead, and English rockband
          with users listening to their tracks 582,658 times. Following close behind are The Beatles, another English rockband formed in the 1960s with 559,065 users
          listening to their songs. They have always been widely regarded as some of the best rock bands during their time.
        </p>
        <br>
      </td>
      <td>
        <!--Div that will hold the pie chart-->
        <p class="small">Figure 1</p>
        <div id="piechart_div" style="border: 1px solid #ccc"></div>
        <p class="small">Figure 2</p>
        <div id="barchart_div" style="border: 1px solid #ccc"></div>
      </td>

  </table>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {
      'packages': ['corechart']
    });

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawPieChart);
    google.charts.setOnLoadCallback(drawBarChart);

    // PHP array to JS array
    var songs = <?php echo json_encode($sList); ?>;
    var artists = <?php echo json_encode($saList) ?>;
    var listens = <?php echo json_encode($lList); ?>;

    var artists2 = <?php echo json_encode($aList); ?>;
    var listens2 = <?php echo json_encode($alList); ?>;

    // Pie chart for top 10 listened songs
    function drawPieChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();

      // set pie chart variables
      data.addColumn('string', 'Song Title');
      data.addColumn('number', 'Listeners');

      var i;
      for (i = 0; i < 10; ++i) {
        data.addRows([
          [songs[i] + " - \n" + artists[i], listens[i]],
        ])
      }

      // Set chart options
      // as of 20/05/2020
      var options = {
        'title': 'Top 10 Most Listened to Songs - ListenBrainz (2006 - 2018)',
        'width': 1000,
        'height': 650,
        'legend': {
          textStyle: {
            fontSize: 12
          }
        }
      };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
      chart.draw(data, options);
    }

    // Bar graph for top 10 listened artists
    function drawBarChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();

      // set pie chart variables
      data.addColumn('string', 'Song Title');
      data.addColumn('number', 'Listeners');
      var i;
      for (i = 0; i < 10; ++i) {
        data.addRows([
          [artists2[i], listens2[i]],
        ])
      }

      // Set chart options
      // as of 20/05/2020
      var options = {
        'title': 'Top 10 Most Listened to Artists/Bands - ListenBrainz (2006 - 2018)',
        'width': 1000,
        'height': 650,
      };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.BarChart(document.getElementById('barchart_div'));
      chart.draw(data, options);
    }
  </script>

</body>

</html>