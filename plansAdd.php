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
    if(!$DAO->isProductIDAlradyInDatabase($_POST['productID'])) {
        $DAO->addStoragePlan($_POST['size']*1000000000, $_POST['price'], $_POST['duration'], $_POST['productID']);
        $message = "Storage plan successfully added.";
    } else {
        $message = "Product ID already exists.";
    }
    
    header('refresh:2;url=./plansManagement.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Storage plan</title>
    <link id="style" href="./assets/css/<?php echo $_SESSION["design"]; ?>.css" rel="stylesheet">
</head>
<body>
    <?php include('./includes/header.php'); ?>
    <div id="main">
        <?php include('./includes/navbar.php'); ?>
        <div class="container-max">
            <section>
                <?php
                if(isset($message)) {
                    echo '<div class="userDetails">';
                    echo $message;
                    echo '</div>';
                }
                ?>
                <br/>
                <br/>
                <fieldset>
                    <legend>Add a storage plan</legend>
                    <div>
                        <form action="./plansAdd.php" method="post">
                            <div>
                                <label for="size">Size (GB)</label>  
                                <div>
                                    <input type="number" name="size" step="1" min="0" required>
                                </div>
                            </div>
                            <br/>
                            <div>
                                <label for="price">Price (€)</label>  
                                <div>
                                    <input type="number" name="price" min="0" required>
                                </div>
                            </div>
                            <br/>
                            <div>
                                <label for="duration">Duration (months)</label>  
                                <div>
                                    <input type="number" name="duration" min="1" required>
                                </div>
                            </div>
                            <br/>
                            <div>
                                <label for="productID">Product ID</label>  
                                <div>
                                    <input type="text" name="productID" required>
                                </div>
                            </div>
                            <br/>
                            <div>
                                <button type="submit" id="submitButton" name="submitButton">Add</button>
                                <button type="cancel" id="cancelButton" name="cancelButton">Cancel</button>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>