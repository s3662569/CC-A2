<?php
session_start();
putenv('TuteLab2-v1-65ee09f177f1.json');
#
#
#
#CHANGE THIS to TuteLab2-v1-65ee09f177f1.json
#
#


require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

# Your Google Cloud Platform project ID
$projectId = 'tutelab2-v1';
#
#
#CHANGE THIS TO CC-A2-b49a7a02359f.json
#
#

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

  	
</head>



<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel='stylesheet' type='text/css' href='/css/style.css'>
<!-- <style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style> -->




<body>
  <h1>ListenBrainz Analysis</h1>

  <?php
  echo "things are working yes";
  ?>

  <div name='main'>
    <p>Songs</p>
  </div>

  <!--Div that will hold the pie chart-->
<!-- <div class="content" >

  <div id="piechart_div" style="border: 1px solid #ccc"></div>

  </div> -->

<div class="info">
<p class="info">
The website is mainly an 
informative page of information such as popular songs 
and popular artists over the years. It provides users 
with data represented as graphs such as bar and pie charts 
for clarity to easily understand the relevant information. 
It utilises Google Cloud services such as BigQuery and Google Datastore
 to query (find) information from a public database and store it in a datastore.
  By gathering large portions of data and condensing it into smaller pieces of
   information to display allows quick and easy analysis for users to see.
<br>

Moving along into the technological age, walkmans, vinyl disks are slowly 
becoming obsolete as music starts to shift towards online services where it is 
more accessible by everyone. Similarly, music is now being sold online through websites as well as being streamed online. This website can provide users with a quick analysis of the trending bands from the past few years based off of ListenBrainz data.

  </p>



  <div>

<!-- <div class="inlineBoxWithBorder" positio>
  <table class="content">
    <tr>
      <td>
        <div class="content" id="piechart_div" style="border: 1px solid #ccc"></div>
        <div id="barchart_div" style="border: 1px solid #ccc"></div>
      </td>
    </tr>
  </table>

  </div> -->

<div class="info">

  <!-- "class="inlineBoxWithBorder"  -->

        <div style="display: block">


           <div class="content" id="piechart_div"></div> 

        </div> 

       <div style="display: block">


       <div id="barchart_div"></div> 


        </div>


 </div>



  <!--Load the AJAX API-->
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
        'title': 'Top 10 Most Listened to Songs - ListenBrainz (2017 - 2018)',
        'width': 1000,
        'height': 650,
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
        'title': 'Top 10 Most Listened to Artists/Bands - ListenBrainz (2017 - 2018)',
        'width': 800,
        'height': 500,
      };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.BarChart(document.getElementById('barchart_div'));
      chart.draw(data, options);
    }
  </script>

</body>

</html>