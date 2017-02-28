<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>External Result Example</title>
</head>
<body>
<?php
foreach ($_GET as $key => $value) {
    echo "<p>$key: $value</p>";
}
?>
</body>
</html>
