<?php
define('ROOT', dirname(__DIR__, 2));

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
    <title>Admin Panel - Delete confirmation</title>
    <link href="./assets/css/css.css" rel="stylesheet">
    <link href="../../public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Delete confirmation</h1>
    </header>
    <div>
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
    </div>
    <?php include("./includes/footer.php"); ?>
</body>
</html>