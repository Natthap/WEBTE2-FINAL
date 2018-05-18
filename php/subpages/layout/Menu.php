<nav class="navbar navbar-expand-lg navbar-light col-md-8 offset-md-2">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="Home.php">Úvod</a>
            <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="ActiveRoute.php">Aktívna trasa</a>
            <a class="nav-item nav-link <?php if(isset($addRoute)){ echo $addRoute; }?>" href="AddRoute.php">Pridanie trasy</a>
            <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="HistoryOfRoutes.php">História trás</a>
            <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="RecentActivity.php">Nedavna aktivita</a>
            <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="Profile.php">Profil</a>
            <?php if ($_SESSION['personType'] == 1) { ?>
                <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="Contact.php">Kontakt</a>
            <?php } ?>
            <?php if ($_SESSION['personType'] == 2) { ?>
                <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="News.php">Novinky</a>
                <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="Users.php">Všetci používatelia</a>
                <a class="nav-item nav-link <?php if(isset($active)){ echo $active; }?>" href="Teams.php">Tímy</a>
            <?php } ?>
        </div>
    </div>
</nav>