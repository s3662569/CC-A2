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
?>

<html>

<head>
  <meta charset="utf-8">
  <title>Main Page</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='stylesheet' type='text/css' href='/css/style.css'>
</head>

<body>
  <ul>
    <li><a>Home</a></li>
    <li><a href="data.php">Data</a></li>
  </ul>

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
      </td>
    </tr>
  </table>
</body>

</html>