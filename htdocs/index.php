<html>
<head>
<title>PHP PDO and MySQL Test</title>
</head>
<body>
<?php
$db = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'norman', 'norman');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function getData($db) {
    $statement = $db->query('SELECT * FROM pet');
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        echo $row['name'];
        echo '<br/>';
    }

    echo '<br/>';
    $row_count = $statement->rowCount();
    echo $row_count.' rows selected';
}

try {
    getData($db);
} catch(PDOException $ex) {
    echo "An exception was thrown.";
}

?>
</body>
</html>
