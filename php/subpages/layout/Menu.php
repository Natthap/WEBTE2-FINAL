<nav class="navbar navbar-expand-lg navbar-light col-md-8 offset-md-2">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link <?php if(isset($home)){ echo $home; }?>" href="Home.php">Úvod</a>
            <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="ActiveRoute.php">Aktívna trasa</a>
            <a class="nav-item nav-link <?php if(isset($addRoute)){ echo $addRoute; }?>" href="AddRoute.php">Pridanie trasy</a>
            <a class="nav-item nav-link <?php if(isset($history)){ echo $history; }?>" href="HistoryOfRoutes.php">História trás</a>
            <a class="nav-item nav-link <?php if(isset($recent)){ echo $recent; }?>" href="RecentActivity.php">Nedavna aktivita</a>
            <a class="nav-item nav-link <?php if(isset($profile)){ echo $profile; }?>" href="Profile.php">Profil</a>
            <?php if ($_SESSION['personType'] == 1) { ?>
                <a class="nav-item nav-link <?php if(isset($contact)){ echo $contact; }?>" href="Contact.php">Kontakt</a>
            <?php } ?>
            <?php if ($_SESSION['personType'] == 2) { ?>
                <a class="nav-item nav-link <?php if(isset($news)){ echo $news; }?>" href="News.php">Novinky</a>
                <a class="nav-item nav-link <?php if(isset($users)){ echo $users; }?>" href="Users.php">Všetci používatelia</a>
                <a class="nav-item nav-link <?php if(isset($team)){ echo $team; }?>" href="Teams.php">Tímy</a>
            <?php } ?>
            <a class="nav-item nav-link" href="Logout.php">Odhlásiť sa</a>
        </div>
    </div>
</nav>