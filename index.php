<?php
include("config.php");
include("res.php");
//var_dump($_SERVER);
echo '
<!DOCTYPE html>
<html lang="en">
	';
echo $head;
echo '<body>';
echo HEADER;
echo "<main>";
echo NAV;
if(isset($_GET["clientele"])) include("apps/clientele.php");
if(isset($_GET["budget"])) include("apps/budget.php");
if(isset($_GET["goals"])) include("apps/goals.php");
echo $footer;
echo SCRIPT;
echo "</main>
    </body>
</html>
";
?>