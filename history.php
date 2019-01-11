<?php
if (!isset($_POST['send'])){
?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h1>View Match History</h1>
        <p>Select Player:</p>
    <select name="pname">
    <option value=""> </option><br>
        <?php
            $link = mysqli_connect("localhost", "root");
            if(!$link){
                die('Could not connect: ' . mysqli_error());
            }
            $sql = "USE wood_pingpong";
            $result = mysqli_query($link, $sql);
                                
            $sql = "SELECT name FROM player";
            $result = mysqli_query($link, $sql);  
                
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    ?><option value="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></option><br>
                    <?php
            } }?> 
    </select>
  
    <input type="submit" name="send" value="Submit">
    </form>
    <?php
            mysqli_close($link);
            echo '<br><a href=index.html>Go back to main page</a>';
    ?>
<?php }

else{
    $pname = $_POST['pname'];
    $link = mysqli_connect("localhost","root");
    if(!$link){
                die('Could not connect: ' . mysqli_error());
            }
    mysqli_set_charset($link, 'utf8');
    $sql = "USE wood_pingpong";
    $result = mysqli_query($link, $sql);
    $sql = "SELECT * FROM $pname";
    $result = mysqli_query($link, $sql);
    echo "<h2> $pname"."'s Match History </h2>";
    if(mysqli_num_rows($result) > 0){
        echo "<table border=1>
            <tr>
            <th>Game</th>
            <th>Time</th>
            <th>Won against</th>
            <th>Lost to</th>
            <th>Post-game rating</th>
            <th>Rating changes</th>
            </tr>";
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>$row[game_number]</td><td> $row[time_played]</td><td>$row[won_against]</td><td>$row[lost_to]</td><td>$row[rating]</td><td>$row[changes]</td></tr>"; 
        }
        echo "</table>";
    }else{
        echo "No data";
    }
 
    mysqli_close($link);
    
    echo '<br><a href=index.html>Go back to main page</a>';
}
?>

