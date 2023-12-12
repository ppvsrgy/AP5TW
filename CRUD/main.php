<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Databaze</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li ><a href="popis.php">Info</a></li>
                <li class="active"><a href="index.php">Zákaznici</a></li>
                <li ><a href="search.php">Hledat</a></li>
            </ul>
        </div>
    </nav>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Zákaznici</h2>
                        <a href="create.php" class="btn btn-success pull-right">Přidat nového zákaznika</a>
                    </div>
                    <?php

                    require_once "config.php";
                    
                    if(!empty($_GET["sort"]))
					{
						$sort = $_GET["sort"];
						$sql = "SELECT * FROM zakaznici ORDER BY ".$sort;
					}
					else
					{
                    $sql = "SELECT * FROM zakaznici";
					}
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>"."<a href='index.php?sort=jmeno"."' title='Sort by Jmeno' data-toggle='tooltip'>Jméno</a>"."</th>";
                                        echo "<th>"."<a href='index.php?sort=prijmeni"."' title='Sort by Prijmeni' data-toggle='tooltip'>Přijmení</a>"."</th>";
                                        echo "<th>"."<a href='index.php?sort=ulice"."' title='Sort by Ulice' data-toggle='tooltip'>Ulice</a>"."</th>";
                                        echo "<th>"."<a href='index.php?sort=cp"."' title='Sort by CP' data-toggle='tooltip'>ČP</a>"."</th>";
                                        echo "<th>"."<a href='index.php?sort=mesto"."' title='Sort by Mesto' data-toggle='tooltip'>Město</a>"."</th>";
                                        echo "<th>"."<a href='index.php?sort=psc"."' title='Sort by PSC' data-toggle='tooltip'>PSČ</a>"."</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['jmeno'] . "</td>";
                                        echo "<td>" . $row['prijmeni'] . "</td>";
                                        echo "<td>" . $row['ulice'] . "</td>";
                                        echo "<td>" . $row['cp'] . "</td>";
                                        echo "<td>" . $row['mesto'] . "</td>";
                                        echo "<td>" . $row['psc'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='Zobrazení záznamu' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Editace záznamu' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Smazat záznam' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>