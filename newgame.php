<?php
if (!isset($_POST['send'])){
?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h1>New Game</h1>
        <p>the result of the game was (please don't beat yourself):</p>
    <select name="winner">
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
        beat
    <select name="loser">
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
            } ?>     
    </select>
    <input type="submit" name="send" value="Submit">
    </form>
        <?php
            }
            mysqli_close($link);
            echo '<br><a href=index.html>Go back to main page</a>';
    ?>
<?php }

else{
    $winner = $_POST['winner'];
    $loser = $_POST['loser'];
    $link = mysqli_connect("localhost","root");
    if(!$link){
                die('Could not connect: ' . mysqli_error());
            }
    mysqli_set_charset($link, 'utf8');
    $sql = "USE wood_pingpong";
    $result = mysqli_query($link, $sql);
    $sql = "SELECT rating FROM player WHERE name = '$winner' ";
    $result = mysqli_query($link, $sql);
    $ratingW = mysqli_fetch_assoc($result);
    $sql = "SELECT rating FROM player WHERE name = '$loser' ";
    $result = mysqli_query($link, $sql);
    $ratingL = mysqli_fetch_assoc($result);
    echo "$winner"."'s rating was ". $ratingW['rating'] ."<br>";
    echo "$loser"."'s rating was ". $ratingL['rating'] ."<br>";
    echo "<br>";
 
    $QA = pow(10,($ratingW['rating'] / 400));
    $QB = pow(10,($ratingL['rating'] / 400));
    $EA = $QA/($QA+$QB);
    $EB = $QB/($QA+$QB); 

    echo "$winner"."'s probability of winning was ". $EA*100 ."%<br>";
    echo "$loser"."'s probability of winning was ". $EB*100 ."%<br>";
    echo "<br>";
    
    $newratingW = $ratingW['rating'] + (32*(1-$EA));
    $newratingL = $ratingL['rating'] + (32*(0-$EB));
    
    echo "$winner"."'s NEW rating is ". $newratingW ."<br>";
    echo "$loser"."'s NEW rating is ". $newratingL ."<br>";
    echo "<br>";    
    
    $sql = "UPDATE player SET wins = wins+1, rating = $newratingW WHERE name = '$winner' ";
    $result = mysqli_query($link, $sql);
    if($result){
        echo "Winner's ELO updated successfully!<br>";
    }else{
        echo "Unable to update ELO<br>";
    }
    $sql = "UPDATE player SET loses = loses+1, rating = $newratingL WHERE name = '$loser' ";
    $result = mysqli_query($link, $sql);
    if($result){
        echo "Loser's ELO updated successfully!<br>";
    }else{
        echo "Unable to update ELO<br>";
    }
 
    $elogain = $newratingW - $ratingW['rating'];
    $eloloss = $newratingL - $ratingL['rating'];
    
    echo "<br>ELO changes is +/- ". $elogain ."<br>";
    echo "<br>";    
    
    $time = date("Y-m-d H:i:s");
    $sql = "INSERT into $winner (time_played, won_against, rating, changes) VALUES ('$time', '$loser', '$newratingW', '$elogain')";
    $result = mysqli_query($link, $sql);
    if(!$result){
        die('error'.mysqli_error());
    }
    $sql = "INSERT into $loser (time_played, lost_to, rating, changes) VALUES ('$time', '$winner', '$newratingL', '$eloloss')";
    $result = mysqli_query($link, $sql);
    if(!$result){
        die('error'.mysqli_error());
    }
    
    mysqli_close($link);
    
    echo '<a href="ranking.php">View Ranking</a>';
    echo '<br><a href=index.html>Go back to main page</a>';
}
?>