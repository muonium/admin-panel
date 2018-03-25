<?php
if(empty($_SESSION["connected"])) {
    $html = '<a href="./login.php" class="login" title="Login"><i class="fas fa-sign-in-alt fa-2x"></i></a>';
} else {
    if($_SESSION["connected"]) {
        $html = '<a href="./logout.php" class="logout" title="Logout"><i class="fas fa-times fa-2x"></i></a>';
    } else {
        $html = '<a href="./login.php" class="login" title="Login"><i class="fas fa-sign-in-alt fa-2x"></i></a>';
    }
}
    
if($_SESSION["design"] == "dark") {
    ?>
    <header>
        <div id="logo">
            <a href="./index.html"><img src="./assets/img/logos/logo.png" title="Accueil" alt="Accueil"></a>
        </div>
        <div class="iconRight">
            <a href="./changeDesign.php" id="switchDesign" title="Design"><i id="designLogo" class="far fa-lightbulb fa-2x"></i></a>
            <a href="https://github.com/muonium/core" class="github" title="GitHub"><i class="fab fa-github fa-2x"></i></a>
            <?php echo $html; ?>
        </div>
    </header>
    <?php
} else {
    ?>
    <header>
        <div id="logo">
            <a href="./index.html"><img src="./assets/img/logos/logo.png" title="Accueil" alt="Accueil"></a>
        </div>
        <div class="iconRight">
            <a href="./changeDesign.php" id="switchDesign" title="Design"><i id="designLogo" class="fas fa-lightbulb fa-2x"></i></a>
            <a href="https://github.com/muonium/core" class="github" title="GitHub"><i class="fab fa-github fa-2x"></i></a>
            <?php echo $html; ?>
        </div>
    </header>
    <?php
}
?>
