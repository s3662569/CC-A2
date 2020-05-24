<?php
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
$kind3 = 'user';

// array setup for songs
$sList = array();
$saList = array();
$lList = array();

// Loop through datastore and add elements to array
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

// Loop through datastore and add elements to array
for ($i = 1; $i < 11; ++$i) {
    $id = $datastore->key($kind2, 'a' . $i);
    $a = $datastore->lookup($id);

    $aArtist = $a['artist'];
    $aListen = $a['listened'];

    array_push($aList, $aArtist);
    array_push($alList, $aListen);
}

$uList = array();
$ulList = array();

for ($i = 1; $i < 11; ++$i) {
    $id = $datastore->key($kind3, 'u' . $i);
    $u = $datastore->lookup($id);

    $uUser = $u['username'];
    $uListen = $u['listens'];

    array_push($uList, $uUser);
    array_push($ulList, $uListen);
}
?>

<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Page</title>
    <link rel='stylesheet' type='text/css' href='/css/style.css'>

    <!-- Link to Google Charts: https://developers.google.com/chart/interactive/docs/quick_start -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {
            'packages': ['corechart']
        });

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawPieChart);
        google.charts.setOnLoadCallback(drawBarChart);
        google.charts.setOnLoadCallback(drawColumnChart);

        // PHP array to JS array
        var songs = <?php echo json_encode($sList); ?>;
        var artists = <?php echo json_encode($saList) ?>;
        var listens = <?php echo json_encode($lList); ?>;

        var artists2 = <?php echo json_encode($aList); ?>;
        var listens2 = <?php echo json_encode($alList); ?>;

        // make chart for users with the most listens
        var users = <?php echo json_encode($uList); ?>;
        var listens3 = <?php echo json_encode($ulList); ?>;


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
            var options = {
                'title': 'Top 10 Most Listened to Songs - ListenBrainz (2005 - 2018)',
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
            data.addColumn('string', 'Artists/Bands');
            data.addColumn('number', 'Listeners');
            var i;
            for (i = 0; i < 10; ++i) {
                data.addRows([
                    [artists2[i], listens2[i]],
                ])
            }

            // Set chart options
            var options = {
                'title': 'Top 10 Most Listened to Artists/Bands - ListenBrainz (2005 - 2018)',
                'width': 1000,
                'height': 650,
                'colors': [
                    '#ADD8E6',
                ]
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.BarChart(document.getElementById('barchart_div'));
            chart.draw(data, options);
        }

        function drawColumnChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();

            // set pie chart variables
            data.addColumn('string', 'Username');
            data.addColumn('number', 'Listens')
            var i;
            for (i = 0; i < 10; ++i) {
                data.addRows([
                    [users[i], listens3[i]],
                ])
            }

            // Set chart options
            var options = {
                'title': 'Top 10 Users based on Song Listenings - ListenBrainz (2005 - 2018)',
                'width': 1000,
                'height': 650,
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_div'));
            chart.draw(data, options);

        }
    </script>
</head>

<body>
    <ul>
        <li><a href="main.php">Home</a></li>
        <li><a>Data</a></li>
    </ul>

    <h1>ListenBrainz Analysis</h1>

    <table class="info">
        <tr>
            <td>
                <p>
                    Figure 1 displays the top 10 songs listened based on ListenBrainz's database (from years 2006-2018).
                    The top most listened song is actually a sound track from a game called
                    <a target="_blank" href="https://en.wikipedia.org/wiki/The_Legend_of_Zelda:_Ocarina_of_Time">Legend of Zelda: Ocarina of Time</a>, 
                    released back in 1998, composed by a Japanese musician named Koji Kondo which has been listened over the course of 12 years.
                    Similarly, in 2nd spot is another soundtrack composed by a musician for video games and from 3rd onwards are all Pop/Rock songs
                    by famous bands such as Nirvana and Led Zeppelin.
                </p>
            </td>
            <td>
                <p class="small">Table 1</p>
                <img src="https://storage.cloud.google.com/a2-s3721471-bucket/table_1.jpg" alt="table_1">
                <!-- Div that will hold the pie chart -->
                <p class="small">Figure 1</p>
                <div id="piechart_div"></div>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    For Figure 2, it displays the top 10 artists/bands that people of ListenBrainz listen to. Topping the leaderboard is Radiohead, and English rockband
                    with users listening to their tracks 582,658 times. Following close behind are The Beatles, another English rockband formed in the 1960s with 559,065 users
                    listening to their songs. They have always been widely regarded as some of the best rock bands during their time.
                </p>
            </td>
            <td>
                <p class="small">Table 2</p>
                <img src="https://storage.cloud.google.com/a2-s3721471-bucket/table_2.jpg" alt="table_2">
                <!-- Div that holds the bar chart -->
                <p class="small">Figure 2</p>
                <div id="barchart_div"></div>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    Figure 3 displays the top 10 users who have used this software the most based on the total number of songs they have listened to. The top user 'dak180' first
                    listened to a song back in 2005 - meaning their account was created during 2005 and has been using the software since until at least 2018 and on average, listened
                    to 92,676.5 songs per year from 2005 - 2018. User 'CatCat' comes in second place with 1,248,897 songs listened, only 48,574 songs less and averaging just under 90,000
                    songs per year from 2005-2018.
                </p>
            </td>
            <td>
                <p class="small">Table 3</p>
                <img src="https://storage.cloud.google.com/a2-s3721471-bucket/table_3.jpg" alt="table_3">
                <!-- Div that holds the column chart -->
                <p class="small">Figure 3</p>
                <div id="columnchart_div"></div>
            </td>
        </tr>
    </table>

</body>

</html>