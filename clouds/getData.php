<?php

$host = "localhost";
$username = "root";
$password = "5708936";
$database = "clouds";

$con = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$res["status"] = "OK";
$res["data"] = array();

if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];

    $sqli = "SELECT * FROM `cloud` WHERE id =" . $id;
    $result = mysqli_query($con, $sqli);
    if ($result) {
        $row = mysqli_fetch_array($result);
        foreach ($row as $key => $value) {
            $row[$key] = utf8_encode($value);
        }
        array_push($res["data"], $row);
    }
} elseif (isset($_REQUEST["SearchUp"])) {
    //"loc=" + slct + "&cmpt=" + cmpt + "&os=" + ostrg + "&bs=" + bstrg + "&cdn=" + cdn + "&as=" + atosclng + "&sl=" + srvrls;

    $loc = my_htmlentities($_REQUEST["loc"]);
    $cmpt = $_REQUEST["cmpt"];
    $os = $_REQUEST["os"];
    $bs = $_REQUEST["bs"];
    $cdn = $_REQUEST["cdn"];
    $as = $_REQUEST["as"];
    $sl = $_REQUEST["sl"];

    $sql = "SELECT id,Company AS c,Region AS r, Location AS l,Lon AS lat, Lat AS lon FROM `cloud` WHERE Location = '$loc'";

    if ($loc == -1) {
        $sql = "SELECT id,Company AS c,Region AS r, Location AS l,Lon AS lat, Lat AS lon FROM `cloud` WHERE Location != ''";
    }

    if ($cmpt != 'false') {
        $sql .= " AND Compute != ''";
    }
    if ($os != 'false') {
        $sql .= " AND Object_Storage != ''";
    }
    if ($bs != 'false') {
        $sql .= " AND Block_Storage != ''";
    }
    if ($cdn != 'false') {
        $sql .= " AND CDN != ''";
    }
    if ($as != 'false') {
        $sql .= " AND Auto_Scaling != ''";
    }
    if ($sl != 'false') {
        $sql .= " AND Serverless_compute != ''";
    }

    $result = mysqli_query($con, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($res["data"], array("id" => $row["id"], "com" => utf8_encode($row["c"]), "reg" => utf8_encode($row["r"]), "loc" => utf8_encode($row["l"]), "lat" => $row["lat"], "lon" => $row["lon"]));
        }
    }
} else {

    $sql = "SELECT id,Company AS c,Region AS r, Location AS l,Lon AS lat, Lat AS lon FROM `cloud`";

    $result = mysqli_query($con, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($res["data"], array("id" => $row["id"], "com" => utf8_encode($row["c"]), "reg" => utf8_encode($row["r"]), "loc" => utf8_encode($row["l"]), "lat" => $row["lat"], "lon" => $row["lon"]));
        }
    }
}


//$retD = json_encode($res, JSON_PRETTY_PRINT);
mysqli_close($con);

echo json_encode($res);

//if (json_last_error() == 5) {
//    $clean = utf8ize($res);
//    echo json_encode($clean);
//} else {
//    echo $retD;
//}

function my_htmlentities($input) {
    $string = htmlentities($input, ENT_NOQUOTES, 'UTF-8');
    $string = str_replace('&euro;', chr(128), $string);
    $string = html_entity_decode($string, ENT_NOQUOTES, 'ISO-8859-15');
    return $string;
}

function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } else if (is_string($mixed)) {
        return utf8_encode($mixed);
    }
    return $mixed;
}
