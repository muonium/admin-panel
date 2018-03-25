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

if(!empty($_POST)) {
    if(isset($_POST['cancelButton'])) {
        header('Location: ./plansManagement.php');
    } elseif(isset($_POST['deleteButton'])) {
        $DAO->deleteStoragePlan($_POST['storagePlanID']);
        header('Location: ./plansManagement.php');
    }
} else {
    if(empty($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: ./plansManagement.php');
    }

    $plan = $DAO->getStoragePlan($_GET['id']);
    
    if(!$plan) {
        header('Location: ./plansManagement.php');
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Delete storage plan</title>
    <link id="style" href="./assets/css/<?php echo $_SESSION["design"]; ?>.css" rel="stylesheet">
</head>
<body>
    <?php include('./includes/header.php'); ?>
    <div id="main">
        <?php include('./includes/navbar.php'); ?>
        <div class="container-max">
            <section>
                <fieldset>
                    <legend>Delete confirmation</legend>
                    <div>
                        Are you sure you want to delete this storage plan ?
                        <br/>
                        <br/>
                        <?php echo 'Product ID : '.$plan['product_id']; ?>
                        <br/>
                        <br/>
                        <form action="./plansDelete.php" method="post">
                            <div>
                                <button type="submit" id="deleteButton" name="deleteButton">Delete</button>
                                <button type="submit" id="cancelButton" name="cancelButton">Cancel</button>
                                <input type="hidden" id="storagePlanID" name="storagePlanID" value="<?php echo $_GET['id']; ?>">
                            </div>
                        </form>
                    </div>
                </fieldset>
                <div class="addNewPlanLink">
                    <a href="./plansAdd.php"><i class="fa fa-plus" aria-hidden="true"></i> Add a new storage plan</a>
                </div>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>