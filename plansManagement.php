<?php
session_start();

if(empty($_SESSION["design"])) {
    $_SESSION["design"] = "dark";
}

if(empty($_SESSION["connected"])) {
    $_SESSION["connected"] = false;
    $_SESSION["rank"] = null;
}
if(!$_SESSION["connected"]) {
    header('Location: ./login.php');
}

define('ROOT', dirname(dirname(__DIR__)));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

$plans = $DAO->getAllStoragePlans();
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Plans managements</title>
    <link id="style" href="./assets/css/<?php echo $_SESSION["design"]; ?>.css" rel="stylesheet">
</head>
<body>
    <?php include('./includes/header.php'); ?>
    <div id="main">
        <?php include('./includes/navbar.php'); ?>
        <div class="container-max">
            <section>
                <div>
                    <fieldset>
                        <legend>Plans management</legend>
                        <div>
                            <table>
                                <thead>
                                    <th>ID</th>
                                    <th>Size (GB)</th>
                                    <th>Price</th>
                                    <th>Currency</th>
                                    <th>Duration (Months)</th>
                                    <th>Product_ID</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($plans as $plan) {
                                        echo '<tr>';
                                        echo '<td>'.$plan['id'].'</td>';
                                        echo '<td>'.($plan['size']/1000000000).'</td>';
                                        echo '<td>'.$plan['price'].'</td>';
                                        echo '<td>'.$plan['currency'].'</td>';
                                        echo '<td>'.$plan['duration'].'</td>';
                                        echo '<td>'.$plan['product_id'].'</td>';
                                        echo '<td><a href="./plansEdit.php?id='.$plan['id'].'"><i class="fas fa-edit"></i></i>Edit</a></td>';
                                        echo '<td><a href="./plansDelete.php?id='.$plan['id'].'"><i class="fa fa-times" aria-hidden="true"></i>Delete</a></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    <div class="addNewPlanLink">
                        <a href="./plansAdd.php"><i class="fa fa-plus" aria-hidden="true"></i> Add a new storage plan</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>