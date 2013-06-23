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

  echo '<style>
    div.gitCommit { border: 1px solid #333333; background: #F6F6F6; padding: 5px; margin: 5px; min-height: 30px; font-size: 12px; font-family: Helvetica, Verdana, Arial, sans-serif; }
    div.gitCommit:hover { background: #E8E8E8; }
    div.committerImage { float: left; width: 30px; height: 30px; }
    div.committerImage img { width: 30px; height: 30px; }
    div.gitDetails { float: left; margin-left: 5px; }
    div.commitMessage a { font-size: 14px; font-weight: bold; color: #333333; text-decoration: none; }
    div.commitAuthor { color: #999999; font-size: 10px; }
    div.commitAuthor a { color: #990100; text-decoration: none; }
    div.commitAuthor a:hover { color: #B90504; text-decoration: underline; }
    div.commitLink { float: right; margin-top: 10px; }
    div.commitLink a { background: #990100; color: #F6F6F6; text-decoration: none; padding: 3px 5px; }
    div.commitLink a:hover { background: #B90504; text-decoration: underline; }
  </style>';

?>