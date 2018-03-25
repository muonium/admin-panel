<div class="sidebar">
    <ul>
        <li><a href="./index.php"><i class="fas fa-home fa-2x"></i></a><span>Admin panel</span></li>
        <li><a href="./runCron.php"><i class="fas fa-play fa-2x"></i></a><span>Run cron</span></li>
        <li><a href="./stats.php"><i class="fas fa-chart-bar fa-2x"></i></a><span>Stats</span></li>
        <li><a href="./addUser.php"><i class="fas fa-user-plus fa-2x"></i></a><span>Add user</span></li>
        <li><a href="./plansManagement.php"><i class="fas fa-edit fa-2x"></i></a><span>Plans management</span></li>
        <li><a href="./deleteUser.php"><i class="fas fa-user-times fa-2x"></i></a><span>Delete user</span></li>
        <li><a href="./userDetails.php"><i class="fas fa-address-card fa-2x"></i></a><span>User details</span></li>
        <?php
        if(!empty($_SESSION["rank"])) {
            if($_SESSION["rank"] == "master") {
                echo '<li><a href="./addAdmin.php"><i class="fas fa-plus-circle fa-2x"></i></a><span>Add admin</span></li>';      
            }
        }
        ?>
    </ul>
</div>
