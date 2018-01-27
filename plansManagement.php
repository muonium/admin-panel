<?php
define('ROOT', dirname(__DIR__, 2));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

$plans = $DAO->getAllStoragePlans();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - Plans management</title>
    <link href="./assets/css/css.css" rel="stylesheet">
    <link href="../../public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Plans management</h1>
    </header>
    <div>
        <fieldset>
            <legend>Plans management</legend>
            <div>
                <table>
                    <thead>
                        <th>ID</th>
                        <th>Size (MB)</th>
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
                            echo '<td>'.($plan['size']/1000).'</td>';
                            echo '<td>'.$plan['price'].'</td>';
                            echo '<td>'.$plan['currency'].'</td>';
                            echo '<td>'.$plan['duration'].'</td>';
                            echo '<td>'.$plan['product_id'].'</td>';
                            echo '<td><a href="./plansEdit.php?id='.$plan['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
                            echo '<td><a href="./plansDelete.php?id='.$plan['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
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
    <?php include("./includes/footer.php"); ?>
</body>
</html>
