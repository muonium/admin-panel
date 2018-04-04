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
    if($DAO->isProductAlradyInDatabase($_POST['id'])) {
        if(!$DAO->isEditProductID($_POST['id'], $_POST['productID'])) {
            $DAO->modifyStoragePlan($_POST['id'], $_POST['size']*1000000000, $_POST['price'], $_POST['duration'], $_POST['productID']);
            $plan = $DAO->getStoragePlan($_POST['id']);
            $message = "Storage plan successfully edited.";
            header('refresh:2;url=./plansManagement.php'); 
        } else {
            $plan = $DAO->getStoragePlan($_POST['id']);
            $message = "Error : Product ID already in database.";
        }
    } else {
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
    <title>Admin Panel - Adit plan</title>
    <link id="style" href="./assets/css/<?php echo $_SESSION["design"]; ?>.css" rel="stylesheet">
</head>
<body>
    <?php include('./includes/header.php'); ?>
    <div id="main">
        <?php include('./includes/navbar.php'); ?>
        <div class="container-max">
            <section>
                <div>
                    <?php
                    if(isset($message)) {
                        echo '<div class="userDetails">';
                        echo $message;
                        echo '</div>';
                    }
                    ?>
                    <fieldset>
                        <legend>Add a storage plan</legend>
                        <div>
                            <form action="./plansEdit.php" method="post">
                                <div>
                                    <label for="id">ID</label>
                                    <input class="readonly" type="number" name="id" value="<?php echo $plan['id']; ?>" readonly>
                                    <br/>
                                    <label for="size">Size (GB)</label>
                                    <input type="number" name="size" value="<?php echo $plan['size']/1000000000; ?>" step="1" min="0" required>
                                    <br/>
                                    <label for="price">Price (€)</label>
                                    <input type="number" name="price" value="<?php echo $plan['price']; ?>" min="0" required>
                                    <br/>
                                    <label for="duration">Duration (months)</label>
                                    <input type="number" name="duration" value="<?php echo $plan['duration']; ?>" min="1" required>
                                    <br/>
                                    <label for="productID">Product ID</label>
                                    <input type="text" name="productID" value="<?php echo $plan['product_id']; ?>" required>
                                    <br/>
                                    <button type="submit" id="editButton" name="editButton">Edit</button>
                                    <button type="cancel" id="cancelButton" name="cancelButton">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </fieldset>
                </div>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>
