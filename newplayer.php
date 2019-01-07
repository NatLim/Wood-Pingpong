<?php
if (!isset($_POST['send'])){
?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    New Player Entry (20 character maximum)
    <p>Name: <input type="text" name="pname">
        <input type="submit" name="send" value="Submit">
    </form>
<?php }
else{
    $pname = $_POST['pname'];
    
    $link = mysqli_connect("localhost","root");
    mysqli_set_charset($link, 'utf8');
    $sql = "USE wood_pingpong";
    $result = mysqli_query($link, $sql);
    $sql = "INSERT INTO player (name) VALUES('$pname')";
    $result = mysqli_query($link, $sql);
    $sql = "CREATE TABLE '$pname'(game_number int(4) NOT NULL AUTO INCREMENT UNSIGNED PRIMARY KEY,"
            . " time_played DATETIME, won_against VARCHAR(20) NOT NULL, lost_to VARCHAR(20) NOT NULL";
    $result = mysqli_query($link, $sql);
    if($result){
        echo "New player registered successfully!<br>";
        mysqli_close($link);
    }else{
        echo "Unable to register new player<br>";
    }
    echo '<a href=newplayer.php>Enter a new player</a><br>';
    echo '<a href=index.html>Go back to main page</a>';
}
?>


