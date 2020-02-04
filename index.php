<?php
  $pdo = new PDO('sqlite:chinook.db');
  $sql = '
    SELECT Name As Playlist_Name, PlaylistId As Playlist_Id
    FROM playlists';
  $statement = $pdo->prepare($sql);
  $statement->execute();
  $playlists = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<table>
  <thead>
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($playlists as $playlist) : ?>
      <tr>
        <td>
          <a href="tracks.php?playlist=<?php echo $playlist->Playlist_Id ?>">
          <?php echo $playlist->Playlist_Name ?>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>