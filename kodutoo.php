<?php
require_once 'config/mysqli.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Minu JavaScriptid -->
    <script src="js/my_scripts.js" type="text/javascript"></script> 

    <title>CRUD Kodutoo leht</title>
</head>

<body>
    <!-- MENÜÜ -->
    <div class="container">
        <div class="row">
            <div class="col text-center">
            <div class="d-flex justify-content-center mb-1 bg-body-tertiary">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="index.php?page=create"><i class="fa-solid fa-square-plus text-success"></i> Create</a>
                    <a class="nav-link" href="index.php?page=read"><i class="fa-solid fa-book-open text-primary"></i> Read</a>
                    <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=update"><i class="fa-solid fa-pen-to-square text-warning"></i> Update</a>
                    <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=delete"><i class="fa-regular fa-trash-can text-danger"></i> Delete</a>
                    <a class="nav-link" href="kodutoo.php"><i class="fa-solid fa-bank text-info"></i> Kodutöö</a>
                </div>
            </div>
        </div>
    </nav>
</div>
            </div>
        </div>
    </div>

    <!-- Siin toimub autmaatne sisu lugemine -->
    
    <div class="container">
        <?php function title() { ?>
    <h2 class="text-center">KODUTÖÖ</h2>
        <!-- Siia tuleb üks kompleksne if lause :) -->
        <?php 

        }
        echo title();
        if(isset($_GET['page'])) {
            $file = $_GET['page'].'.php';

            if(file_exists($file) and is_file($file)) {
                require $file;
            } else {
            }
        } 

// Lisame siia leheküljendamise

// Siia tuleb suurem ports PHP koodi aga kõik on loogiline

$sql = 'SELECT COUNT(id) AS total FROM simple;';
$res = $database->dbGetArray($sql);
$total = $res[0]['total'];
if ($total > 0) {
    if (isset($_GET['pg'])) {
        $pg = $_GET['pg'];
    } else {
        $pg = 1;
    }
} else {
    $pg = 1;
}

$totalRows = $total;
$maxPerPage = MAXPERPAGE;
$pageCount = ceil($totalRows / $maxPerPage);

if (empty($pg) || $pg < 1 || $pg > $pageCount) {
    $pg = 1;
}

$nextStart = $pg * $maxPerPage;
$start = $nextStart - $maxPerPage;

// Tee sobilik päring tabelisse. Vaata koodi peale inlcude 'paginate.php' (näiteks homepage.php)

?>
<nav aria-label="Page navigation">
    <ul class="pagination pagination-color justify-content-center">
        <li class="page-item">

            <a class="page-link <?php echo ($pg == 1) ? 'disabled' : null; ?>" href="kodutoo.php?pg=1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item">

            <a class="page-link <?php echo ($pg == 1) ? 'disabled' : null; ?>" href="kodutoo.php?pg=<?php echo (($pg - 1) == 0) ? "1" : ($pg - 1); ?> " aria-label="Previous">
                <span aria-hidden="true">&lsaquo;</span>
            </a>
        </li>
        <?php
        // for-loop algus
        for ($x = 0; $x < $pageCount; $x++) {
        ?>
            <li class="page-item">
                <a class="page-link <?php echo (($x + 1) == $pg) ? 'active' : null; ?>" href="kodutoo.php?pg=<?php echo ($x + 1); ?>"><?php echo ($x + 1); ?></a>
            </li>
        <?php
            // for-loop lõpp
        }
        ?>
        <li class="page-item">
            <a class="page-link <?php echo ($pg >= $pageCount) ? 'disabled' : null; ?>" href="kodutoo.php?pg=<?php echo (($pg + 1) > $pageCount) ?: ($pg + 1); ?> " aria-label="Next">
                <span aria-hidden="true">&rsaquo;</span>
            </a>
        </li>
        <li class="page-item">

            <a class="page-link <?php echo ($pg >= $pageCount) ? 'disabled' : null; ?>" href="kodutoo.php?pg=<?php echo $pageCount; ?> " aria-label="Previous">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?php
// sql lause, päring ja if lause
$sql = 'SELECT * FROM simple ORDER BY added DESC LIMIT '.$start.', '.$maxPerPage;
$res = $database->dbGetArray($sql);
if($res !== false) {
   // $database->show($res);
?>

<table class="table table-hover table-bordered">
    <thead>
        <tr class="text-center">
            <th>Jrk.</th>
            <th>Nimi</th>
            <th>Sünniaeg</th>
            <th>Palk</th>
            <th>Pikkus</th>
            <th>Lisatud</th>
            <th>Tegevus</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $page = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
        $jrk_end = $page * 5;
        $jrk_start = ($page - 1) * 5 + 1;
        $jrk = ($page - 1) * 5;
        if ($jrk_end > count($res)) {
            $jrk_end = count($res);
        }
        foreach($res as $key => $val) {
            $jrk++;
            if ($jrk < $jrk_start and $jrk > $jrk_end) {
                continue; 
            }
        
            $date = new DateTime($val['birth']);
            $birth = $date->format('d.m.Y');
            $dateTime = new DateTime($val['added']);
            $added = $dateTime->format('d.m.Y H:i:s');
        ?>
        <tr>
            <td class="text-center"><?php echo $jrk; ?></td>
            <td><?php echo $val['name']; ?>.</td>
            <td class="text-center"><?php echo $birth; ?></td>
            <td class="text-end"><?php echo $val['salary']; ?></td>
            <td class="text-end"><?php echo $val['height']; ?></td>
            <td class="text-end"><?php echo $added; ?></td>
            <td class="text-center">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=hw_update-by-id&ids=<?php echo $val['id']; ?>"><i class="fa-solid fa-pen-to-square text-warning" title="Edit">  </i></a>
            
            <a href="?page=&ids=<?php echo $val['id']; ?>" onclick="if (confirm('Kas oled kindel?')) { return true; } else { return false; }"><i class="fa-solid fa-trash-can text-danger" title="Delete"></i></a></td>
        </tr>
        <?php
    }
        ?>
    </tbody>
</table>
<?php
} 


        
        

?>
    </div>
</body>

</html>