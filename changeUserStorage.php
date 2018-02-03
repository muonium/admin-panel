<?php
define('ROOT', dirname(dirname(__DIR__)));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

if(!empty($_POST)) {
    if(isset($_POST['cancelButton'])) {
        header('Location: ./userDetails.php');
    } elseif(isset($_POST['changeQuotaButton'])) {
        $id = $_POST['userID'];
        $DAO->changeStorageUser($id, $_POST['newQuotaValue']*1000000);
        $infos = $DAO->getInfos($id);
        $storage = $DAO->getStorage($id);
        $messageSuccess = 'Successfully changed user\'s storage';
    }
} else {
    
    if(empty($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: ./userDetails.php');
    }

    $id = $_GET['id'];
    $infos = $DAO->getInfos($id);
    
    if(!$infos) {
        header('Location: ./userDetails.php');
    }
    
    $storage = $DAO->getStorage($id);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - Change user's storage</title>
    <link href="./assets/css/css.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Change user's storage</h1>
    </header>
    <div>
        <?php
        if(isset($messageSuccess)) {
            echo $messageSuccess;
        }
        ?>
        <fieldset>
            <legend>Change user's storage</legend>
            <div>
                <br/>
                <?php
                    echo 'ID : '.$id.'<br/>'; 
                    echo 'Email : '.$infos['email'].'<br/>'; 
                    echo 'Login : '.$infos['login'].'<br/>'; 
                    echo 'Actual storage : '.$storage/1000000 .' MB<br/>';
                ?>
                <br/>
                <form action="./changeUserStorage.php" method="post">
                    <div>
                        <input type="number" id="newQuotaValue" name="newQuotaValue" min="0" value="<?php echo $storage/1000000; ?>"> MB
                        <br/>
                        <button type="submit" id="changeQuotaButton" name="changeQuotaButton">Change</button>
                        <button type="submit" id="cancelButton" name="cancelButton">Cancel</button>
                        <input type="hidden" id="userID" name="userID" value="<?php echo $id; ?>">
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
    <?php include("./includes/footer.php"); ?>
</body>
</html>