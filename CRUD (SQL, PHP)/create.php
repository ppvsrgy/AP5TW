<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$jmeno = $prijmeni = $ulice = $cp = $mesto = $psc = "";
$jmeno_err = $prijmeni_err = $ulice_err = $cp_err = $mesto_err = $psc_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_jmeno = trim($_POST["jmeno"]);
    if(empty($input_jmeno)){
        $jmeno_err = "Napište jméno.";
    } elseif(!filter_var($input_jmeno, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $jmeno_err = "Prosím, napište spravné jméno.";
    } else{
        $jmeno = $input_jmeno;
    }
    
    // Validate prijmeni
    $input_prijmeni = trim($_POST["prijmeni"]);
    if(empty($input_prijmeni)){
        $prijmeni_err = "Napište přijmení";     
    } else{
        $prijmeni = $input_prijmeni;
    }

    //Validate ulici

    $input_ulice = trim($_POST["ulice"]);
    if(empty($input_ulice)){
        $ulice_err = "Napište ulici";     
    } else{
        $ulice = $input_ulice;
    }
    
    // Validate cp
    $input_cp = trim($_POST["cp"]);
    if(empty($input_cp)){
        $cp_err = "Napište CP.";     
    } elseif(!ctype_digit($input_cp)){
        $cp_err = "Napište kladné číslo.";
    } else{
        $cp = $input_cp;
    }

    //Validate Mesto
    $input_mesto = trim($_POST["mesto"]);
    if(empty($input_mesto)){
        $mesto_err = "Napište město";     
    } else{
        $mesto = $input_mesto;
    }

    // Validate psc
    $input_psc = trim($_POST["psc"]);
    if(empty($input_psc)){
        $psc_err = "Napište psc.";     
    } elseif(!ctype_digit($input_psc)){
        $psc_err = "Napište kladné číslo.";
    } else{
        $psc = $input_psc;
    }
    
    // Check input errors before inserting in database
    if(empty($jmeno_err) && empty($prijmeni_err) && empty($ulice_err) && empty($cp_err) && empty($mesto_err) && empty($psc_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO zakaznici (jmeno, prijmeni, ulice, cp, mesto, psc) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_jmeno, $param_prijmeni, $param_ulice, $param_cp, $param_mesto, $param_psc);
            
            // Set parameters
            $param_jmeno = $jmeno;
            $param_prijmeni = $prijmeni;
            $param_ulice = $ulice;
            $param_cp = $cp;
            $param_mesto = $mesto;
            $param_psc = $psc;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Přidat nového zakaznika</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li ><a href="popis.php">Info</a></li>
                <li ><a href="index.php">Zákaznici</a></li>
                <li ><a href="search.php">Hledat</a></li>
            </ul>
        </div>
    </nav>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Přidat nového zakaznika</h2>
                    </div>
                    <p>Prosím o vyplnění formuláře</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($jmeno_err)) ? 'has-error' : ''; ?>">
                            <label>Jméno</label>
                            <input type="text" name="jmeno" class="form-control" value="<?php echo $jmeno; ?>">
                            <span class="help-block"><?php echo $jmeno_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($prijmeni_err)) ? 'has-error' : ''; ?>">
                            <label>Přijmení</label>
                            <input type="text" name="prijmeni" class="form-control" value="<?php echo $prijmeni; ?>">
                            <span class="help-block"><?php echo $prijmeni_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ulice_err)) ? 'has-error' : ''; ?>">
                            <label>Ulice</label>
                            <input type="text" name="ulice" class="form-control" value="<?php echo $ulice; ?>">
                            <span class="help-block"><?php echo $ulice_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cp_err)) ? 'has-error' : ''; ?>">
                            <label>Čislo popisné</label>
                            <input type="text" name="cp" class="form-control" value="<?php echo $cp; ?>">
                            <span class="help-block"><?php echo $cp_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mesto_err)) ? 'has-error' : ''; ?>">
                            <label>Město</label>
                            <input type="text" name="mesto" class="form-control" value="<?php echo $mesto; ?>">
                            <span class="help-block"><?php echo $mesto_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($psc_err)) ? 'has-error' : ''; ?>">
                            <label>PSČ</label>
                            <input type="text" name="psc" class="form-control" value="<?php echo $psc; ?>">
                            <span class="help-block"><?php echo $psc_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Odeslat">
                        <a href="index.php" class="btn btn-default">Konec</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>