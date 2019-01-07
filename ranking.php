<html>
    <body>
        <?php
                $link = mysqli_connect("localhost", "root");
                if(!$link){
                    die('Could not connect: ' . mysqli_error());
                }
                
                $sql = "USE wood_pingpong";
                $result = mysqli_query($link, $sql);
                                
                $sql = "SELECT name, rating, wins, loses FROM player";
                $result = mysqli_query($link, $sql);  
                ?>
                
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>Wins</th>
                        <th>Loses</th>
                    </tr>
                <?php
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr><td>".$row["name"]."</td><td>".$row["rating"]."</td><td>".$row["wins"]."</td><td>".$row["loses"]."</td></tr>"; 
                    }
                } else{
                    echo "No data";
                }
                ?>
                </table>
                <?php
                
                mysqli_close($link);
                echo '<br><a href=index.html>Go back to main page</a>';
        ?>
        
    </body>
