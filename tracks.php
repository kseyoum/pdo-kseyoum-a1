<?php
 if (!isset($_GET['playlist'])) {
   header('Location: index.php');
   exit();
 }
$pdo = new PDO('sqlite:chinook.db');
$sql = 
  '
  SELECT playlists.PlaylistId AS Playlist_Id, playlists.Name AS Playlist_Name, tracks.Name AS Track_Name, albums.Title AS Album_Title, artists.Name AS Artist_Name, tracks.UnitPrice AS Price, media_types.Name AS Media_Type, genres.Name AS Genre
  FROM playlists
  INNER JOIN playlist_track 
      ON playlist_track.PlaylistId = playlists.PlaylistId
  INNER JOIN tracks
      ON tracks.TrackId = playlist_track.TrackId
  INNER JOIN albums 
      ON albums.AlbumId = tracks.AlbumId
  INNER JOIN artists
      ON artists.ArtistId = albums.ArtistId
  INNER JOIN media_types
      ON media_types.MediaTypeId = tracks.MediaTypeId
  INNER JOIN genres
      ON genres.GenreId = tracks.GenreId
  WHERE Playlist_Id = ?
  ';
$sqlName = 
  '
  SELECT playlists.PlaylistId AS Playlist_Id, playlists.Name AS Playlist_Name 
  FROM playlists
  WHERE Playlist_Id = ?
  ';

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $_GET['playlist']);
$statement->execute();
$playlistTracks = $statement->fetchAll(PDO::FETCH_OBJ);

$statementName = $pdo->prepare($sqlName);
$statementName->bindParam(1, $_GET['playlist']);
$statementName->execute();
$playlistName = $statementName->fetchAll(PDO::FETCH_OBJ);



  if (count($playlistTracks) == 0)
  {
     
    foreach ($playlistName as $name) :
    $pName = $name->Playlist_Name;
    endforeach;
    echo "No tracks found for $pName";

  }


?>



  <table>
  <thead>
    <th>Track Name</th>
    <th>Album Title</th>
    <th>Artist Name</th>
    <th>Price</th>
    <th>Media Type</th>
    <th>Genre</th>
  </thead>
  <tbody>
    <?php foreach($playlistTracks as $playlistTrack) : ?>
      <tr>
        <td><?php echo $playlistTrack->Track_Name ?></td>
        <td><?php echo $playlistTrack->Album_Title ?></td>
        <td><?php echo $playlistTrack->Artist_Name ?></td>
        <td><?php echo $playlistTrack->Price ?></td>
        <td><?php echo $playlistTrack->Media_Type ?></td>
        <td><?php echo $playlistTrack->Genre ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>




 