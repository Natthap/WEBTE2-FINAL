<nav class="navbar navbar-expand-lg navbar-light col-md-8 offset-md-2">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="Home.php">Úvod</a>
            <a class="nav-item nav-link" href="ActiveRoute.php">Aktívna trasa</a>
            <a class="nav-item nav-link" href="AddRoute.php">Pridanie trasy</a>
            <a class="nav-item nav-link" href="HistoryOfRoutes.php">História trás</a>
            <a class="nav-item nav-link" href="RecentActivity.php">Aktivita používateľa</a>
            <a class="nav-item nav-link" href="Profile.php">Profil</a>
            <?php if ($_SESSION['personType'] == 1) { ?>
                <a class="nav-item nav-link" href="Contact.php">Kontakt</a>
            <?php } ?>
            <?php if ($_SESSION['personType'] == 2) { ?>
                <a class="nav-item nav-link" href="Users.php">Všetci používatelia</a>
                <a class="nav-item nav-link" href="Teams.php">Tímy</a>
            <?php } ?>
        </div>
    </div>
</nav>