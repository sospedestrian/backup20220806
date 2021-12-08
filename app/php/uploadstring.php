<?php
    if(isset($_POST["n"]) && isset($_POST["key"])
    &&
    ctype_digit($_POST["n"]) && ctype_digit($_POST["key"])/* && ctype_digit($_POST["string"]) && ctype_digit($_POST["type"])*/
    )    {
        define("protectedPrivateKeysPath", dirname($_SERVER["DOCUMENT_ROOT"]) . "/protected/private/keys/");
        define("upload", "../uploads/");
        define("uploadstrings", upload . "strings/");
        define("descriptions", uploadstrings . "descriptions/");
        define("descriptiontimes", uploadstrings . "descriptiontimes/");
        define("locations", uploadstrings . "locations/");
        define("locationtimes", uploadstrings . "locationtimes/");
        $keyPath = protectedPrivateKeysPath . $_POST["n"];
        if(!file_exists($keyPath))    {
            exit("-1");
        }
        function saveData($dataPath, $timePath, $string)  {
            $path = $dataPath . $_POST["n"] . ".txt";
            if(file_exists($path))    {
                exit("-3");
            }
            if(!password_verify($_POST["key"], file_get_contents($GLOBALS["keyPath"])))    {
                exit("-4");
            }
            if(file_put_contents($path, $string))   {
                file_put_contents($timePath . $_POST["n"] . ".txt", time());
            }
        }
        if(isset($_POST["description"]))    {
            saveData(descriptions, descriptiontimes, $_POST["description"]);
            if(isset($_POST["submit"]))    {
                header("Location: view.php?n=" . $_POST["n"]);
            }
            else    {
                echo "1";
            }
        }
        else if(isset($_POST["latitude"]) && isset($_POST["longitude"]) && is_numeric($_POST["latitude"]) && is_numeric($_POST["longitude"]))   {
            saveData(locations, locationtimes, $_POST["latitude"] . ", " . $_POST["longitude"]);
            echo "1";
        }
    }
    else    {
        exit("0");
    }
?>