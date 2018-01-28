<?php
define('ROOT', dirname(__DIR__, 2));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

if(!empty($_POST)) {
    if(!$DAO->isProductIDAlradyInDatabase($_POST['productID'])) {
        $DAO->addStoragePlan($_POST['size']*1000000, $_POST['price'], $_POST['duration'], $_POST['productID']);
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
    <title>Admin Panel - Add a storage plan</title>
    <link href="./assets/css/css.css" rel="stylesheet">
    <link href="../../public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Add a storage plan</h1>
    </header>
    <div>
        <?php
        if(isset($message)) {
            echo $message;
        }
        ?>
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
    </div>
    <?php include("./includes/footer.php"); ?>
</body>
</html>