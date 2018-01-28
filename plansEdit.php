<?php
define('ROOT', dirname(__DIR__, 2));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

if(!empty($_POST)) {
    if($DAO->isProductAlradyInDatabase($_POST['id'])) {
        if(!$DAO->isProductIDAlradyInDatabase($_POST['id'], $_POST['productID'])) {
            $DAO->modifyStoragePlan($_POST['id'], $_POST['size']*1000, $_POST['price'], $_POST['duration'], $_POST['productID']);
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
                <form action="./plansEdit.php" method="post">
                   <div>
                        <label for="id">ID</label>  
                        <div>
                            <input class="readonly" type="number" name="id" value="<?php echo $plan['id']; ?>" readonly>
                        </div>
                    </div>
                    <br/>
                    <div>
                        <label for="size">Size (MB)</label>  
                        <div>
                            <input type="number" name="size" value="<?php echo $plan['size']/1000; ?>" step="10" min="0" required>
                        </div>
                    </div>
                    <br/>
                    <div>
                        <label for="price">Price (€)</label>  
                        <div>
                            <input type="number" name="price" value="<?php echo $plan['price']; ?>" min="0" required>
                        </div>
                    </div>
                    <br/>
                    <div>
                        <label for="duration">Duration (months)</label>  
                        <div>
                            <input type="number" name="duration" value="<?php echo $plan['duration']; ?>" min="1" required>
                        </div>
                    </div>
                    <br/>
                    <div>
                        <label for="productID">Product ID</label>  
                        <div>
                            <input type="text" name="productID" value="<?php echo $plan['product_id']; ?>" required>
                        </div>
                    </div>
                    <br/>
                    <div>
                        <button type="submit" id="editButton" name="editButton">Edit</button>
                        <button type="cancel" id="cancelButton" name="cancelButton">Cancel</button>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
    <?php include("./includes/footer.php"); ?>
</body>
</html>