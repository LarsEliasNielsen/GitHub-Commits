<html>
<head>
  <title>GitHub Commit module</title>
  <link rel="stylesheet" href="css/main.style.css" />
</head>
<body>
  <?php
    /**
     * Gets the API (v3) from GitHub.com with cURL.
     *
     * @param string sshCloneUrl
     *  Copy the SSH Clone URL from GitHub
     * @param int numberOfCommits
     *  Number of commits you want to be shown
     * @return object result
     *  A JSON-object is returned from the API
     * 
     */
    function getGitHubApi($sshCloneUrl = 'https://github.com/octocat/Hello-World.git', $numberOfCommits = 5) {

      // Regex to filter the git clone url
      $userPattern = array('/^git@github.com:/', '/\/[A-Za-z0-9\_\-]+.git$/');
      $repoPattern = array('/^git@github.com:[A-Za-z0-9\_\-]+\//', '/.git$/');

      // User and repo from clone url
      $user = preg_replace($userPattern, '', $sshCloneUrl);
      $repo = preg_replace($repoPattern, '', $sshCloneUrl);

      // cURL the API
      // CURLOPT_USERPWN is used if repo is private, CAUTION
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://api.github.com/repos/'.$user.'/'.$repo.'/commits',
        CURLOPT_USERAGENT => $numberOfCommits.' latest commits',
        // CURLOPT_USERPWD => 'USER:PASS'
      ));
      
      $result = curl_exec($curl);

      // Call print function
      printCommits($result, $numberOfCommits);

      curl_close($curl);

    }

    /**
     *
     * Decodes and printes commit information
     *
     * @param object jsonResult
     *  JSON object returned from getGitHubApi()
     * @param int numberOfCommits
     *  Number of commits you want to be shown
     *
     */
    function printCommits($jsonResult, $numberOfCommits = 5) {
      // Decode JSON
      $json = json_decode($jsonResult, true);

      // Print entity for each commit
      for ($i = 0; $i < $numberOfCommits; $i ++) {

        // Private commit variables
        $committerAvatar = $json[$i]['author']['avatar_url'];
        $committerUsername = $json[$i]['author']['login'];
        $committerUrl = $json[$i]['author']['html_url'];
        $commitMessage = $json[$i]['commit']['message'];
        $commitRawDate = $json[$i]['commit']['author']['date'];
        $commitDate = date('d-m-Y H:i:s', strtotime($commitRawDate));
        $commitLink = $json[$i]['html_url'];

        /**
         * TODO: Redo print
         */
        // Simple print of entity
        if (isset($committerUsername) && isset($committerUrl) && isset($commitMessage) && isset($commitLink)) {
          echo '<div class="gitCommit">
            <div class="committerImage"><a href="'.$committerUrl.'"><img src="'.$committerAvatar.'" title="'.$committerUsername.'" /></a></div>
            <div class="gitDetails">
              <div class="commitMessage"><a href="'.$commitLink.'">'.$commitMessage.'</a></div>
              <div class="commitAuthor">Authored on '.$commitDate.' by <a href="'.$committerUrl.'">'.$committerUsername.'</a></div>
            </div>
            <div class="commitLink"><a href="'.$commitLink.'">Browse commit</a></div>
          </div>';
        } else {
          // If the API dosen't contain any of more commits
          echo '<div class="gitCommit">
            <div class="error">Sorry, no commit.</div>
          </div>';
        }
      }
    }

  ?>

  <?php
    
    // Simple test function call
    $returnedJSON = getGitHubApi('git@github.com:LarsEliasNielsen/GitHub-Commits.git', 20);

  ?>
</body>
</html>