<html>
<head>
  <title>GitHub Commit module</title>
  <link rel="stylesheet" href="css/main.style.css" />
</head>
<body>
  <?php

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => 'https://api.github.com/repos/LarsEliasNielsen/GitHub-Commits/commits',
      CURLOPT_USERAGENT => '5 latest commits',
      // CURLOPT_USERPWD => 'USER:PASS'
    ));
    
    $result = curl_exec($curl);

    curl_close($curl);


    $json = json_decode($result, true);
    
    for ($i = 0; $i < 5; $i ++) {

      $committerAvatar = $json[$i]['author']['avatar_url'];
      $committerUsername = $json[$i]['author']['login'];
      $committerUrl = $json[$i]['author']['html_url'];
      $commitMessage = $json[$i]['commit']['message'];

      $commitRawDate = $json[$i]['commit']['author']['date'];
      $commitDate = date('d-m-Y H:i:s', strtotime($commitRawDate));

      $commitLink = $json[$i]['html_url'];

      echo '<div class="gitCommit">
        <div class="committerImage"><a href="'.$committerUrl.'"><img src="'.$committerAvatar.'" title="'.$committerUsername.'" /></a></div>
        <div class="gitDetails">
          <div class="commitMessage"><a href="'.$commitLink.'">'.$commitMessage.'</a></div>
          <div class="commitAuthor">Authored on '.$commitDate.' by <a href="'.$committerUrl.'">'.$committerUsername.'</a></div>
        </div>
        <div class="commitLink"><a href="'.$commitLink.'">Browse commit</a></div>
      </div>';
    }

  ?>
</body>
</html>