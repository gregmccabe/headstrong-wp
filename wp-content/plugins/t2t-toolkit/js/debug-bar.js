


<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# githubog: http://ogp.me/ns/fb/githubog#">
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>plugin-update-checker/js/debug-bar.js at master · YahnisElsts/plugin-update-checker</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub" />
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-144.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144.png" />
    <link rel="logo" type="image/svg" href="https://github-media-downloads.s3.amazonaws.com/github-logo.svg" />
    <meta property="og:image" content="https://github.global.ssl.fastly.net/images/modules/logos_page/Octocat.png">
    <meta name="hostname" content="github-fe120-cp1-prd.iad.github.net">
    <meta name="ruby" content="ruby 1.9.3p194-tcs-github-tcmalloc (2012-05-25, TCS patched 2012-05-27, GitHub v1.0.36) [x86_64-linux]">
    <link rel="assets" href="https://github.global.ssl.fastly.net/">
    <link rel="conduit-xhr" href="https://ghconduit.com:25035/">
    <link rel="xhr-socket" href="/_sockets" />
    


    <meta name="msapplication-TileImage" content="/windows-tile.png" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="selected-link" value="repo_source" data-pjax-transient />
    <meta content="collector.githubapp.com" name="octolytics-host" /><meta content="github" name="octolytics-app-id" /><meta content="4429CD1E:1FA7:12EA38B2:5256F9A9" name="octolytics-dimension-request_id" /><meta content="174744" name="octolytics-actor-id" /><meta content="abbottry" name="octolytics-actor-login" /><meta content="cd194094fae19e8f69232fc352ce1423793e28f40bf4e0b805ed07ad19b7d26a" name="octolytics-actor-hash" />
    

    
    
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />

    <meta content="authenticity_token" name="csrf-param" />
<meta content="vP7jOk7IaPkqXcInBLht8lkRALfDs9E/WpSe4opwVtw=" name="csrf-token" />

    <link href="https://github.global.ssl.fastly.net/assets/github-da610086a8ece032a05fc6706ebe8776de27cc3f.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://github.global.ssl.fastly.net/assets/github2-37420f3c36d08373f07e607c0e2fdc757c297f0b.css" media="all" rel="stylesheet" type="text/css" />
    

    

      <script src="https://github.global.ssl.fastly.net/assets/frameworks-2380aeb62de9a4760c888de666aabb294cccaae1.js" type="text/javascript"></script>
      <script src="https://github.global.ssl.fastly.net/assets/github-bf1e7dcc82851c512cd4afe48b28dc838a06daeb.js" type="text/javascript"></script>
      
      <meta http-equiv="x-pjax-version" content="406473791f52c341ca9525d43c9c5b9e">

        <link data-pjax-transient rel='permalink' href='/YahnisElsts/plugin-update-checker/blob/c3a8325c2d81be96c795aaf955aed44e1873f251/js/debug-bar.js'>
  <meta property="og:title" content="plugin-update-checker"/>
  <meta property="og:type" content="githubog:gitrepository"/>
  <meta property="og:url" content="https://github.com/YahnisElsts/plugin-update-checker"/>
  <meta property="og:image" content="https://github.global.ssl.fastly.net/images/gravatars/gravatar-user-420.png"/>
  <meta property="og:site_name" content="GitHub"/>
  <meta property="og:description" content="plugin-update-checker - A custom update checker for WordPress plugins. Ufseful if you can&#39;t or don&#39;t want to host your plugin in the official WP plugin repository, but would still like it to support automatic plugin updates."/>

  <meta name="description" content="plugin-update-checker - A custom update checker for WordPress plugins. Ufseful if you can&#39;t or don&#39;t want to host your plugin in the official WP plugin repository, but would still like it to support automatic plugin updates." />

  <meta content="2527434" name="octolytics-dimension-user_id" /><meta content="YahnisElsts" name="octolytics-dimension-user_login" /><meta content="6558262" name="octolytics-dimension-repository_id" /><meta content="YahnisElsts/plugin-update-checker" name="octolytics-dimension-repository_nwo" /><meta content="true" name="octolytics-dimension-repository_public" /><meta content="false" name="octolytics-dimension-repository_is_fork" /><meta content="6558262" name="octolytics-dimension-repository_network_root_id" /><meta content="YahnisElsts/plugin-update-checker" name="octolytics-dimension-repository_network_root_nwo" />
  <link href="https://github.com/YahnisElsts/plugin-update-checker/commits/master.atom" rel="alternate" title="Recent Commits to plugin-update-checker:master" type="application/atom+xml" />

  </head>


  <body class="logged_in  env-production macintosh vis-public  page-blob">
    <div class="wrapper">
      
      
      


      <div class="header header-logged-in true">
  <div class="container clearfix">

    <a class="header-logo-invertocat" href="https://github.com/">
  <span class="mega-octicon octicon-mark-github"></span>
</a>

    
    <a href="/notifications" class="notification-indicator tooltipped downwards" data-gotokey="n" title="You have unread notifications">
        <span class="mail-status unread"></span>
</a>

      <div class="command-bar js-command-bar  in-repository">
          <form accept-charset="UTF-8" action="/search" class="command-bar-form" id="top_search_form" method="get">

<input type="text" data-hotkey="/ s" name="q" id="js-command-bar-field" placeholder="Search or type a command" tabindex="1" autocapitalize="off"
    
    data-username="abbottry"
      data-repo="YahnisElsts/plugin-update-checker"
      data-branch="master"
      data-sha="932360174392cb61e1e89f1b75bcda6091864a4d"
  >

    <input type="hidden" name="nwo" value="YahnisElsts/plugin-update-checker" />

    <div class="select-menu js-menu-container js-select-menu search-context-select-menu">
      <span class="minibutton select-menu-button js-menu-target">
        <span class="js-select-button">This repository</span>
      </span>

      <div class="select-menu-modal-holder js-menu-content js-navigation-container">
        <div class="select-menu-modal">

          <div class="select-menu-item js-navigation-item js-this-repository-navigation-item selected">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" class="js-search-this-repository" name="search_target" value="repository" checked="checked" />
            <div class="select-menu-item-text js-select-button-text">This repository</div>
          </div> <!-- /.select-menu-item -->

          <div class="select-menu-item js-navigation-item js-all-repositories-navigation-item">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" name="search_target" value="global" />
            <div class="select-menu-item-text js-select-button-text">All repositories</div>
          </div> <!-- /.select-menu-item -->

        </div>
      </div>
    </div>

  <span class="octicon help tooltipped downwards" title="Show command bar help">
    <span class="octicon octicon-question"></span>
  </span>


  <input type="hidden" name="ref" value="cmdform">

</form>
        <ul class="top-nav">
          <li class="explore"><a href="/explore">Explore</a></li>
            <li><a href="https://gist.github.com">Gist</a></li>
            <li><a href="/blog">Blog</a></li>
          <li><a href="https://help.github.com">Help</a></li>
        </ul>
      </div>

    


  <ul id="user-links">
    <li>
      <a href="/abbottry" class="name">
        <img height="20" src="https://0.gravatar.com/avatar/6e560f7f9ffb7ec8fcb6382ecf5d83f2?d=https%3A%2F%2Fidenticons.github.com%2F8e6b024a041cef87f9dfa6d030ef051f.png&amp;s=140" width="20" /> abbottry
      </a>
    </li>

      <li>
        <a href="/new" id="new_repo" class="tooltipped downwards" title="Create a new repo" aria-label="Create a new repo">
          <span class="octicon octicon-repo-create"></span>
        </a>
      </li>

      <li>
        <a href="/settings/profile" id="account_settings"
          class="tooltipped downwards"
          aria-label="Account settings "
          title="Account settings ">
          <span class="octicon octicon-tools"></span>
        </a>
      </li>
      <li>
        <a class="tooltipped downwards" href="/logout" data-method="post" id="logout" title="Sign out" aria-label="Sign out">
          <span class="octicon octicon-log-out"></span>
        </a>
      </li>

  </ul>

<div class="js-new-dropdown-contents hidden">
  

<ul class="dropdown-menu">
  <li>
    <a href="/new"><span class="octicon octicon-repo-create"></span> New repository</a>
  </li>
  <li>
    <a href="/organizations/new"><span class="octicon octicon-organization"></span> New organization</a>
  </li>



    <li class="section-title">
      <span title="YahnisElsts/plugin-update-checker">This repository</span>
    </li>
    <li>
      <a href="/YahnisElsts/plugin-update-checker/issues/new"><span class="octicon octicon-issue-opened"></span> New issue</a>
    </li>
</ul>

</div>


    
  </div>
</div>

      

      




          <div class="site" itemscope itemtype="http://schema.org/WebPage">
    
    <div class="pagehead repohead instapaper_ignore readability-menu">
      <div class="container">
        

<ul class="pagehead-actions">

    <li class="subscription">
      <form accept-charset="UTF-8" action="/notifications/subscribe" class="js-social-container" data-autosubmit="true" data-remote="true" method="post"><div style="margin:0;padding:0;display:inline"><input name="authenticity_token" type="hidden" value="vP7jOk7IaPkqXcInBLht8lkRALfDs9E/WpSe4opwVtw=" /></div>  <input id="repository_id" name="repository_id" type="hidden" value="6558262" />

    <div class="select-menu js-menu-container js-select-menu">
      <a class="social-count js-social-count" href="/YahnisElsts/plugin-update-checker/watchers">
        13
      </a>
      <span class="minibutton select-menu-button with-count js-menu-target" role="button" tabindex="0">
        <span class="js-select-button">
          <span class="octicon octicon-eye-watch"></span>
          Watch
        </span>
      </span>

      <div class="select-menu-modal-holder">
        <div class="select-menu-modal subscription-menu-modal js-menu-content">
          <div class="select-menu-header">
            <span class="select-menu-title">Notification status</span>
            <span class="octicon octicon-remove-close js-menu-close"></span>
          </div> <!-- /.select-menu-header -->

          <div class="select-menu-list js-navigation-container" role="menu">

            <div class="select-menu-item js-navigation-item selected" role="menuitem" tabindex="0">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <div class="select-menu-item-text">
                <input checked="checked" id="do_included" name="do" type="radio" value="included" />
                <h4>Not watching</h4>
                <span class="description">You only receive notifications for discussions in which you participate or are @mentioned.</span>
                <span class="js-select-button-text hidden-select-button-text">
                  <span class="octicon octicon-eye-watch"></span>
                  Watch
                </span>
              </div>
            </div> <!-- /.select-menu-item -->

            <div class="select-menu-item js-navigation-item " role="menuitem" tabindex="0">
              <span class="select-menu-item-icon octicon octicon octicon-check"></span>
              <div class="select-menu-item-text">
                <input id="do_subscribed" name="do" type="radio" value="subscribed" />
                <h4>Watching</h4>
                <span class="description">You receive notifications for all discussions in this repository.</span>
                <span class="js-select-button-text hidden-select-button-text">
                  <span class="octicon octicon-eye-unwatch"></span>
                  Unwatch
                </span>
              </div>
            </div> <!-- /.select-menu-item -->

            <div class="select-menu-item js-navigation-item " role="menuitem" tabindex="0">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <div class="select-menu-item-text">
                <input id="do_ignore" name="do" type="radio" value="ignore" />
                <h4>Ignoring</h4>
                <span class="description">You do not receive any notifications for discussions in this repository.</span>
                <span class="js-select-button-text hidden-select-button-text">
                  <span class="octicon octicon-mute"></span>
                  Stop ignoring
                </span>
              </div>
            </div> <!-- /.select-menu-item -->

          </div> <!-- /.select-menu-list -->

        </div> <!-- /.select-menu-modal -->
      </div> <!-- /.select-menu-modal-holder -->
    </div> <!-- /.select-menu -->

</form>
    </li>

  <li>
  
<div class="js-toggler-container js-social-container starring-container ">
  <a href="/YahnisElsts/plugin-update-checker/unstar" class="minibutton with-count js-toggler-target star-button starred upwards" title="Unstar this repo" data-remote="true" data-method="post" rel="nofollow">
    <span class="octicon octicon-star-delete"></span><span class="text">Unstar</span>
  </a>
  <a href="/YahnisElsts/plugin-update-checker/star" class="minibutton with-count js-toggler-target star-button unstarred upwards" title="Star this repo" data-remote="true" data-method="post" rel="nofollow">
    <span class="octicon octicon-star"></span><span class="text">Star</span>
  </a>
  <a class="social-count js-social-count" href="/YahnisElsts/plugin-update-checker/stargazers">73</a>
</div>

  </li>


        <li>
          <a href="/YahnisElsts/plugin-update-checker/fork" class="minibutton with-count js-toggler-target fork-button lighter upwards" title="Fork this repo" rel="facebox nofollow">
            <span class="octicon octicon-git-branch-create"></span><span class="text">Fork</span>
          </a>
          <a href="/YahnisElsts/plugin-update-checker/network" class="social-count">15</a>
        </li>


</ul>

        <h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="entry-title public">
          <span class="repo-label"><span>public</span></span>
          <span class="mega-octicon octicon-repo"></span>
          <span class="author">
            <a href="/YahnisElsts" class="url fn" itemprop="url" rel="author"><span itemprop="title">YahnisElsts</span></a></span
          ><span class="repohead-name-divider">/</span><strong
          ><a href="/YahnisElsts/plugin-update-checker" class="js-current-repository js-repo-home-link">plugin-update-checker</a></strong>

          <span class="page-context-loader">
            <img alt="Octocat-spinner-32" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
          </span>

        </h1>
      </div><!-- /.container -->
    </div><!-- /.repohead -->

    <div class="container">

      <div class="repository-with-sidebar repo-container ">

        <div class="repository-sidebar">
            

<div class="repo-nav repo-nav-full js-repository-container-pjax js-octicon-loaders">
  <div class="repo-nav-contents">
    <ul class="repo-menu">
      <li class="tooltipped leftwards" title="Code">
        <a href="/YahnisElsts/plugin-update-checker" aria-label="Code" class="js-selected-navigation-item selected" data-gotokey="c" data-pjax="true" data-selected-links="repo_source repo_downloads repo_commits repo_tags repo_branches /YahnisElsts/plugin-update-checker">
          <span class="octicon octicon-code"></span> <span class="full-word">Code</span>
          <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

        <li class="tooltipped leftwards" title="Issues">
          <a href="/YahnisElsts/plugin-update-checker/issues" aria-label="Issues" class="js-selected-navigation-item js-disable-pjax" data-gotokey="i" data-selected-links="repo_issues /YahnisElsts/plugin-update-checker/issues">
            <span class="octicon octicon-issue-opened"></span> <span class="full-word">Issues</span>
            <span class='counter'>1</span>
            <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>        </li>

      <li class="tooltipped leftwards" title="Pull Requests"><a href="/YahnisElsts/plugin-update-checker/pulls" aria-label="Pull Requests" class="js-selected-navigation-item js-disable-pjax" data-gotokey="p" data-selected-links="repo_pulls /YahnisElsts/plugin-update-checker/pulls">
            <span class="octicon octicon-git-pull-request"></span> <span class="full-word">Pull Requests</span>
            <span class='counter'>0</span>
            <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>


        <li class="tooltipped leftwards" title="Wiki">
          <a href="/YahnisElsts/plugin-update-checker/wiki" aria-label="Wiki" class="js-selected-navigation-item " data-pjax="true" data-selected-links="repo_wiki /YahnisElsts/plugin-update-checker/wiki">
            <span class="octicon octicon-book"></span> <span class="full-word">Wiki</span>
            <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>        </li>
    </ul>
    <div class="repo-menu-separator"></div>
    <ul class="repo-menu">

      <li class="tooltipped leftwards" title="Pulse">
        <a href="/YahnisElsts/plugin-update-checker/pulse" aria-label="Pulse" class="js-selected-navigation-item " data-pjax="true" data-selected-links="pulse /YahnisElsts/plugin-update-checker/pulse">
          <span class="octicon octicon-pulse"></span> <span class="full-word">Pulse</span>
          <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

      <li class="tooltipped leftwards" title="Graphs">
        <a href="/YahnisElsts/plugin-update-checker/graphs" aria-label="Graphs" class="js-selected-navigation-item " data-pjax="true" data-selected-links="repo_graphs repo_contributors /YahnisElsts/plugin-update-checker/graphs">
          <span class="octicon octicon-graph"></span> <span class="full-word">Graphs</span>
          <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

      <li class="tooltipped leftwards" title="Network">
        <a href="/YahnisElsts/plugin-update-checker/network" aria-label="Network" class="js-selected-navigation-item js-disable-pjax" data-selected-links="repo_network /YahnisElsts/plugin-update-checker/network">
          <span class="octicon octicon-git-branch"></span> <span class="full-word">Network</span>
          <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>
    </ul>


  </div>
</div>

            <div class="only-with-full-nav">
              

  

<div class="clone-url open"
  data-protocol-type="http"
  data-url="/users/set_protocol?protocol_selector=http&amp;protocol_type=clone">
  <h3><strong>HTTPS</strong> clone URL</h3>
  <div class="clone-url-box">
    <input type="text" class="clone js-url-field"
           value="https://github.com/YahnisElsts/plugin-update-checker.git" readonly="readonly">

    <span class="js-zeroclipboard url-box-clippy minibutton zeroclipboard-button" data-clipboard-text="https://github.com/YahnisElsts/plugin-update-checker.git" data-copied-hint="copied!" title="copy to clipboard"><span class="octicon octicon-clippy"></span></span>
  </div>
</div>

  

<div class="clone-url "
  data-protocol-type="ssh"
  data-url="/users/set_protocol?protocol_selector=ssh&amp;protocol_type=clone">
  <h3><strong>SSH</strong> clone URL</h3>
  <div class="clone-url-box">
    <input type="text" class="clone js-url-field"
           value="git@github.com:YahnisElsts/plugin-update-checker.git" readonly="readonly">

    <span class="js-zeroclipboard url-box-clippy minibutton zeroclipboard-button" data-clipboard-text="git@github.com:YahnisElsts/plugin-update-checker.git" data-copied-hint="copied!" title="copy to clipboard"><span class="octicon octicon-clippy"></span></span>
  </div>
</div>

  

<div class="clone-url "
  data-protocol-type="subversion"
  data-url="/users/set_protocol?protocol_selector=subversion&amp;protocol_type=clone">
  <h3><strong>Subversion</strong> checkout URL</h3>
  <div class="clone-url-box">
    <input type="text" class="clone js-url-field"
           value="https://github.com/YahnisElsts/plugin-update-checker" readonly="readonly">

    <span class="js-zeroclipboard url-box-clippy minibutton zeroclipboard-button" data-clipboard-text="https://github.com/YahnisElsts/plugin-update-checker" data-copied-hint="copied!" title="copy to clipboard"><span class="octicon octicon-clippy"></span></span>
  </div>
</div>


<p class="clone-options">You can clone with
      <a href="#" class="js-clone-selector" data-protocol="http">HTTPS</a>,
      <a href="#" class="js-clone-selector" data-protocol="ssh">SSH</a>,
      or <a href="#" class="js-clone-selector" data-protocol="subversion">Subversion</a>.
  <span class="octicon help tooltipped upwards" title="Get help on which URL is right for you.">
    <a href="https://help.github.com/articles/which-remote-url-should-i-use">
    <span class="octicon octicon-question"></span>
    </a>
  </span>
</p>

  <a href="github-mac://openRepo/https://github.com/YahnisElsts/plugin-update-checker" data-url="github-mac://openRepo/https://github.com/YahnisElsts/plugin-update-checker" class="minibutton sidebar-button js-conduit-rewrite-url">
    <span class="octicon octicon-device-desktop"></span>
    Clone in Desktop
  </a>


              <a href="/YahnisElsts/plugin-update-checker/archive/master.zip"
                 class="minibutton sidebar-button"
                 title="Download this repository as a zip file"
                 rel="nofollow">
                <span class="octicon octicon-cloud-download"></span>
                Download ZIP
              </a>
            </div>
        </div><!-- /.repository-sidebar -->

        <div id="js-repo-pjax-container" class="repository-content context-loader-container" data-pjax-container>
          


<!-- blob contrib key: blob_contributors:v21:e73ee26359712b499c95f27bb9f93761 -->

<p title="This is a placeholder element" class="js-history-link-replace hidden"></p>

<a href="/YahnisElsts/plugin-update-checker/find/master" data-pjax data-hotkey="t" class="js-show-file-finder" style="display:none">Show File Finder</a>

<div class="file-navigation">
  
  

<div class="select-menu js-menu-container js-select-menu" >
  <span class="minibutton select-menu-button js-menu-target" data-hotkey="w"
    data-master-branch="master"
    data-ref="master"
    role="button" aria-label="Switch branches or tags" tabindex="0">
    <span class="octicon octicon-git-branch"></span>
    <i>branch:</i>
    <span class="js-select-button">master</span>
  </span>

  <div class="select-menu-modal-holder js-menu-content js-navigation-container" data-pjax>

    <div class="select-menu-modal">
      <div class="select-menu-header">
        <span class="select-menu-title">Switch branches/tags</span>
        <span class="octicon octicon-remove-close js-menu-close"></span>
      </div> <!-- /.select-menu-header -->

      <div class="select-menu-filters">
        <div class="select-menu-text-filter">
          <input type="text" aria-label="Filter branches/tags" id="context-commitish-filter-field" class="js-filterable-field js-navigation-enable" placeholder="Filter branches/tags">
        </div>
        <div class="select-menu-tabs">
          <ul>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="branches" class="js-select-menu-tab">Branches</a>
            </li>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="tags" class="js-select-menu-tab">Tags</a>
            </li>
          </ul>
        </div><!-- /.select-menu-tabs -->
      </div><!-- /.select-menu-filters -->

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="branches">

        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


            <div class="select-menu-item js-navigation-item selected">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/YahnisElsts/plugin-update-checker/blob/master/js/debug-bar.js"
                 data-name="master"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target"
                 title="master">master</a>
            </div> <!-- /.select-menu-item -->
        </div>

          <div class="select-menu-no-results">Nothing to show</div>
      </div> <!-- /.select-menu-list -->

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="tags">
        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/YahnisElsts/plugin-update-checker/tree/v1.3/js/debug-bar.js"
                 data-name="v1.3"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target"
                 title="v1.3">v1.3</a>
            </div> <!-- /.select-menu-item -->
        </div>

        <div class="select-menu-no-results">Nothing to show</div>
      </div> <!-- /.select-menu-list -->

    </div> <!-- /.select-menu-modal -->
  </div> <!-- /.select-menu-modal-holder -->
</div> <!-- /.select-menu -->

  <div class="breadcrumb">
    <span class='repo-root js-repo-root'><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/YahnisElsts/plugin-update-checker" data-branch="master" data-direction="back" data-pjax="true" itemscope="url"><span itemprop="title">plugin-update-checker</span></a></span></span><span class="separator"> / </span><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/YahnisElsts/plugin-update-checker/tree/master/js" data-branch="master" data-direction="back" data-pjax="true" itemscope="url"><span itemprop="title">js</span></a></span><span class="separator"> / </span><strong class="final-path">debug-bar.js</strong> <span class="js-zeroclipboard minibutton zeroclipboard-button" data-clipboard-text="js/debug-bar.js" data-copied-hint="copied!" title="copy to clipboard"><span class="octicon octicon-clippy"></span></span>
  </div>
</div>



  <div class="commit file-history-tease">
      <img class="main-avatar" height="24" src="https://0.gravatar.com/avatar/9de2919e66bdb845db55df54d7028402?d=https%3A%2F%2Fidenticons.github.com%2F4be74a45f70a279c513c25cb0e7aa09e.png&amp;s=140" width="24" />
      <span class="author"><a href="/YahnisElsts" rel="author">YahnisElsts</a></span>
      <time class="js-relative-date" datetime="2012-10-27T05:30:35-07:00" title="2012-10-27 05:30:35">October 27, 2012</time>
      <div class="commit-title">
          <a href="/YahnisElsts/plugin-update-checker/commit/ae084bd3be802a5e5461b7158309806a8edd3035" class="message" data-pjax="true" title="Actually, lets prefix our custom Debug Bar IDs with &quot;puc&quot; to be complete...

...ly sure we&#39;ll avoid name collisions.">Actually, lets prefix our custom Debug Bar IDs with "puc" to be compl…</a>
      </div>

      <div class="participation">
        <p class="quickstat"><a href="#blob_contributors_box" rel="facebox"><strong>1</strong> contributor</a></p>
        
      </div>
      <div id="blob_contributors_box" style="display:none">
        <h2 class="facebox-header">Users who have contributed to this file</h2>
        <ul class="facebox-user-list">
          <li class="facebox-user-list-item">
            <img height="24" src="https://0.gravatar.com/avatar/9de2919e66bdb845db55df54d7028402?d=https%3A%2F%2Fidenticons.github.com%2F4be74a45f70a279c513c25cb0e7aa09e.png&amp;s=140" width="24" />
            <a href="/YahnisElsts">YahnisElsts</a>
          </li>
        </ul>
      </div>
  </div>

<div id="files" class="bubble">
  <div class="file">
    <div class="meta">
      <div class="info">
        <span class="icon"><b class="octicon octicon-file-text"></b></span>
        <span class="mode" title="File Mode">file</span>
          <span>52 lines (44 sloc)</span>
        <span>1.556 kb</span>
      </div>
      <div class="actions">
        <div class="button-group">
            <a class="minibutton tooltipped leftwards js-conduit-mac-openfile-check"
               href="github-mac://openRepo/https://github.com/YahnisElsts/plugin-update-checker?branch=master&amp;filepath=js%2Fdebug-bar.js"
               data-url="github-mac://openRepo/https://github.com/YahnisElsts/plugin-update-checker?branch=master&amp;filepath=js%2Fdebug-bar.js"
               title="Open this file in GitHub for Mac">
                <span class="octicon octicon-device-desktop"></span> Open
            </a>
                <a class="minibutton tooltipped upwards"
                   title="Clicking this button will automatically fork this project so you can edit the file"
                   href="/YahnisElsts/plugin-update-checker/edit/master/js/debug-bar.js"
                   data-method="post" rel="nofollow">Edit</a>
          <a href="/YahnisElsts/plugin-update-checker/raw/master/js/debug-bar.js" class="button minibutton " id="raw-url">Raw</a>
            <a href="/YahnisElsts/plugin-update-checker/blame/master/js/debug-bar.js" class="button minibutton ">Blame</a>
          <a href="/YahnisElsts/plugin-update-checker/commits/master/js/debug-bar.js" class="button minibutton " rel="nofollow">History</a>
        </div><!-- /.button-group -->
          <a class="minibutton danger empty-icon tooltipped downwards"
             href="/YahnisElsts/plugin-update-checker/delete/master/js/debug-bar.js"
             title="Fork this project and delete file"
             data-method="post" data-test-id="delete-blob-file" rel="nofollow">
          Delete
        </a>
      </div><!-- /.actions -->

    </div>
        <div class="blob-wrapper data type-javascript js-blob-data">
        <table class="file-code file-diff">
          <tr class="file-code-line">
            <td class="blob-line-nums">
              <span id="L1" rel="#L1">1</span>
<span id="L2" rel="#L2">2</span>
<span id="L3" rel="#L3">3</span>
<span id="L4" rel="#L4">4</span>
<span id="L5" rel="#L5">5</span>
<span id="L6" rel="#L6">6</span>
<span id="L7" rel="#L7">7</span>
<span id="L8" rel="#L8">8</span>
<span id="L9" rel="#L9">9</span>
<span id="L10" rel="#L10">10</span>
<span id="L11" rel="#L11">11</span>
<span id="L12" rel="#L12">12</span>
<span id="L13" rel="#L13">13</span>
<span id="L14" rel="#L14">14</span>
<span id="L15" rel="#L15">15</span>
<span id="L16" rel="#L16">16</span>
<span id="L17" rel="#L17">17</span>
<span id="L18" rel="#L18">18</span>
<span id="L19" rel="#L19">19</span>
<span id="L20" rel="#L20">20</span>
<span id="L21" rel="#L21">21</span>
<span id="L22" rel="#L22">22</span>
<span id="L23" rel="#L23">23</span>
<span id="L24" rel="#L24">24</span>
<span id="L25" rel="#L25">25</span>
<span id="L26" rel="#L26">26</span>
<span id="L27" rel="#L27">27</span>
<span id="L28" rel="#L28">28</span>
<span id="L29" rel="#L29">29</span>
<span id="L30" rel="#L30">30</span>
<span id="L31" rel="#L31">31</span>
<span id="L32" rel="#L32">32</span>
<span id="L33" rel="#L33">33</span>
<span id="L34" rel="#L34">34</span>
<span id="L35" rel="#L35">35</span>
<span id="L36" rel="#L36">36</span>
<span id="L37" rel="#L37">37</span>
<span id="L38" rel="#L38">38</span>
<span id="L39" rel="#L39">39</span>
<span id="L40" rel="#L40">40</span>
<span id="L41" rel="#L41">41</span>
<span id="L42" rel="#L42">42</span>
<span id="L43" rel="#L43">43</span>
<span id="L44" rel="#L44">44</span>
<span id="L45" rel="#L45">45</span>
<span id="L46" rel="#L46">46</span>
<span id="L47" rel="#L47">47</span>
<span id="L48" rel="#L48">48</span>
<span id="L49" rel="#L49">49</span>
<span id="L50" rel="#L50">50</span>
<span id="L51" rel="#L51">51</span>
<span id="L52" rel="#L52">52</span>

            </td>
            <td class="blob-line-code">
                    <div class="highlight"><pre><div class='line' id='LC1'><span class="nx">jQuery</span><span class="p">(</span><span class="kd">function</span><span class="p">(</span><span class="nx">$</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC2'><br/></div><div class='line' id='LC3'>	<span class="kd">function</span> <span class="nx">runAjaxAction</span><span class="p">(</span><span class="nx">button</span><span class="p">,</span> <span class="nx">action</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC4'>		<span class="nx">button</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="nx">button</span><span class="p">);</span></div><div class='line' id='LC5'>		<span class="kd">var</span> <span class="nx">panel</span> <span class="o">=</span> <span class="nx">button</span><span class="p">.</span><span class="nx">closest</span><span class="p">(</span><span class="s1">&#39;.puc-debug-bar-panel&#39;</span><span class="p">);</span></div><div class='line' id='LC6'>		<span class="kd">var</span> <span class="nx">responseBox</span> <span class="o">=</span> <span class="nx">button</span><span class="p">.</span><span class="nx">closest</span><span class="p">(</span><span class="s1">&#39;td&#39;</span><span class="p">).</span><span class="nx">find</span><span class="p">(</span><span class="s1">&#39;.puc-ajax-response&#39;</span><span class="p">);</span></div><div class='line' id='LC7'><br/></div><div class='line' id='LC8'>		<span class="nx">responseBox</span><span class="p">.</span><span class="nx">text</span><span class="p">(</span><span class="s1">&#39;Processing...&#39;</span><span class="p">).</span><span class="nx">show</span><span class="p">();</span></div><div class='line' id='LC9'>		<span class="nx">$</span><span class="p">.</span><span class="nx">post</span><span class="p">(</span></div><div class='line' id='LC10'>			<span class="nx">ajaxurl</span><span class="p">,</span></div><div class='line' id='LC11'>			<span class="p">{</span></div><div class='line' id='LC12'>				<span class="nx">action</span>  <span class="o">:</span> <span class="nx">action</span><span class="p">,</span></div><div class='line' id='LC13'>				<span class="nx">slug</span>    <span class="o">:</span> <span class="nx">panel</span><span class="p">.</span><span class="nx">data</span><span class="p">(</span><span class="s1">&#39;slug&#39;</span><span class="p">),</span></div><div class='line' id='LC14'>				<span class="nx">_wpnonce</span><span class="o">:</span> <span class="nx">panel</span><span class="p">.</span><span class="nx">data</span><span class="p">(</span><span class="s1">&#39;nonce&#39;</span><span class="p">)</span></div><div class='line' id='LC15'>			<span class="p">},</span></div><div class='line' id='LC16'>			<span class="kd">function</span><span class="p">(</span><span class="nx">data</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC17'>				<span class="nx">responseBox</span><span class="p">.</span><span class="nx">html</span><span class="p">(</span><span class="nx">data</span><span class="p">);</span></div><div class='line' id='LC18'>			<span class="p">},</span></div><div class='line' id='LC19'>			<span class="s1">&#39;html&#39;</span></div><div class='line' id='LC20'>		<span class="p">);</span></div><div class='line' id='LC21'>	<span class="p">}</span></div><div class='line' id='LC22'><br/></div><div class='line' id='LC23'>	<span class="nx">$</span><span class="p">(</span><span class="s1">&#39;.puc-debug-bar-panel input[name=&quot;puc-check-now-button&quot;]&#39;</span><span class="p">).</span><span class="nx">click</span><span class="p">(</span><span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC24'>		<span class="nx">runAjaxAction</span><span class="p">(</span><span class="k">this</span><span class="p">,</span> <span class="s1">&#39;puc_debug_check_now&#39;</span><span class="p">);</span></div><div class='line' id='LC25'>		<span class="k">return</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC26'>	<span class="p">});</span></div><div class='line' id='LC27'><br/></div><div class='line' id='LC28'>	<span class="nx">$</span><span class="p">(</span><span class="s1">&#39;.puc-debug-bar-panel input[name=&quot;puc-request-info-button&quot;]&#39;</span><span class="p">).</span><span class="nx">click</span><span class="p">(</span><span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC29'>		<span class="nx">runAjaxAction</span><span class="p">(</span><span class="k">this</span><span class="p">,</span> <span class="s1">&#39;puc_debug_request_info&#39;</span><span class="p">);</span></div><div class='line' id='LC30'>		<span class="k">return</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC31'>	<span class="p">});</span></div><div class='line' id='LC32'><br/></div><div class='line' id='LC33'><br/></div><div class='line' id='LC34'>	<span class="c1">// Debug Bar uses the panel class name as part of its link and container IDs. This means we can</span></div><div class='line' id='LC35'>	<span class="c1">// end up with multiple identical IDs if more than one plugin uses the update checker library.</span></div><div class='line' id='LC36'>	<span class="c1">// Fix it by replacing the class name with the plugin slug.</span></div><div class='line' id='LC37'>	<span class="kd">var</span> <span class="nx">panels</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="s1">&#39;#debug-menu-targets&#39;</span><span class="p">).</span><span class="nx">find</span><span class="p">(</span><span class="s1">&#39;.puc-debug-bar-panel&#39;</span><span class="p">);</span></div><div class='line' id='LC38'>	<span class="nx">panels</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span><span class="kd">function</span><span class="p">(</span><span class="nx">index</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC39'>		<span class="kd">var</span> <span class="nx">panel</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">);</span></div><div class='line' id='LC40'>		<span class="kd">var</span> <span class="nx">slug</span> <span class="o">=</span> <span class="nx">panel</span><span class="p">.</span><span class="nx">data</span><span class="p">(</span><span class="s1">&#39;slug&#39;</span><span class="p">);</span></div><div class='line' id='LC41'>		<span class="kd">var</span> <span class="nx">target</span> <span class="o">=</span> <span class="nx">panel</span><span class="p">.</span><span class="nx">closest</span><span class="p">(</span><span class="s1">&#39;.debug-menu-target&#39;</span><span class="p">);</span></div><div class='line' id='LC42'><br/></div><div class='line' id='LC43'>		<span class="c1">//Change the panel wrapper ID.</span></div><div class='line' id='LC44'>		<span class="nx">target</span><span class="p">.</span><span class="nx">attr</span><span class="p">(</span><span class="s1">&#39;id&#39;</span><span class="p">,</span> <span class="s1">&#39;debug-menu-target-puc-&#39;</span> <span class="o">+</span> <span class="nx">slug</span><span class="p">);</span></div><div class='line' id='LC45'><br/></div><div class='line' id='LC46'>		<span class="c1">//Change the menu link ID as well and point it at the new target ID.</span></div><div class='line' id='LC47'>		<span class="nx">$</span><span class="p">(</span><span class="s1">&#39;#puc-debug-menu-link-&#39;</span> <span class="o">+</span> <span class="nx">panel</span><span class="p">.</span><span class="nx">data</span><span class="p">(</span><span class="s1">&#39;slug&#39;</span><span class="p">))</span></div><div class='line' id='LC48'>			<span class="p">.</span><span class="nx">closest</span><span class="p">(</span><span class="s1">&#39;.debug-menu-link&#39;</span><span class="p">)</span></div><div class='line' id='LC49'>			<span class="p">.</span><span class="nx">attr</span><span class="p">(</span><span class="s1">&#39;id&#39;</span><span class="p">,</span> <span class="s1">&#39;debug-menu-link-puc-&#39;</span> <span class="o">+</span> <span class="nx">slug</span><span class="p">)</span></div><div class='line' id='LC50'>			<span class="p">.</span><span class="nx">attr</span><span class="p">(</span><span class="s1">&#39;href&#39;</span><span class="p">,</span> <span class="s1">&#39;#&#39;</span> <span class="o">+</span> <span class="nx">target</span><span class="p">.</span><span class="nx">attr</span><span class="p">(</span><span class="s1">&#39;id&#39;</span><span class="p">));</span></div><div class='line' id='LC51'>	<span class="p">});</span></div><div class='line' id='LC52'><span class="p">});</span></div></pre></div>
            </td>
          </tr>
        </table>
  </div>

  </div>
</div>

<a href="#jump-to-line" rel="facebox[.linejump]" data-hotkey="l" class="js-jump-to-line" style="display:none">Jump to Line</a>
<div id="jump-to-line" style="display:none">
  <form accept-charset="UTF-8" class="js-jump-to-line-form">
    <input class="linejump-input js-jump-to-line-field" type="text" placeholder="Jump to line&hellip;" autofocus>
    <button type="submit" class="button">Go</button>
  </form>
</div>

        </div>

      </div><!-- /.repo-container -->
      <div class="modal-backdrop"></div>
    </div><!-- /.container -->
  </div><!-- /.site -->


    </div><!-- /.wrapper -->

      <div class="container">
  <div class="site-footer">
    <ul class="site-footer-links right">
      <li><a href="https://status.github.com/">Status</a></li>
      <li><a href="http://developer.github.com">API</a></li>
      <li><a href="http://training.github.com">Training</a></li>
      <li><a href="http://shop.github.com">Shop</a></li>
      <li><a href="/blog">Blog</a></li>
      <li><a href="/about">About</a></li>

    </ul>

    <a href="/">
      <span class="mega-octicon octicon-mark-github"></span>
    </a>

    <ul class="site-footer-links">
      <li>&copy; 2013 <span title="0.05276s from github-fe120-cp1-prd.iad.github.net">GitHub</span>, Inc.</li>
        <li><a href="/site/terms">Terms</a></li>
        <li><a href="/site/privacy">Privacy</a></li>
        <li><a href="/security">Security</a></li>
        <li><a href="/contact">Contact</a></li>
    </ul>
  </div><!-- /.site-footer -->
</div><!-- /.container -->


    <div class="fullscreen-overlay js-fullscreen-overlay" id="fullscreen_overlay">
  <div class="fullscreen-container js-fullscreen-container">
    <div class="textarea-wrap">
      <textarea name="fullscreen-contents" id="fullscreen-contents" class="js-fullscreen-contents" placeholder="" data-suggester="fullscreen_suggester"></textarea>
          <div class="suggester-container">
              <div class="suggester fullscreen-suggester js-navigation-container" id="fullscreen_suggester"
                 data-url="/YahnisElsts/plugin-update-checker/suggestions/commit">
              </div>
          </div>
    </div>
  </div>
  <div class="fullscreen-sidebar">
    <a href="#" class="exit-fullscreen js-exit-fullscreen tooltipped leftwards" title="Exit Zen Mode">
      <span class="mega-octicon octicon-screen-normal"></span>
    </a>
    <a href="#" class="theme-switcher js-theme-switcher tooltipped leftwards"
      title="Switch themes">
      <span class="octicon octicon-color-mode"></span>
    </a>
  </div>
</div>



    <div id="ajax-error-message" class="flash flash-error">
      <span class="octicon octicon-alert"></span>
      <a href="#" class="octicon octicon-remove-close close ajax-error-dismiss"></a>
      Something went wrong with that request. Please try again.
    </div>

  </body>
</html>

