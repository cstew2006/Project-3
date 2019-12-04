<?php
include("inc/header.php");
session_start();

          echo "<section>
                <div class='container'>
                    <div class='new-entry'>
                ";
                if(isset($_SESSION['error'])){
                    foreach($_SESSION['error'] as $key => $error){
                        echo "<p class='error__message'>" . $_SESSION['error'][$key] . "</p>";
                    }
                    session_destroy();
                }
                        echo "<h2>New Entry</h2>
                        <form method='post' action='inc/db_add.php'>
                            <label for='title'> Title</label>";
                            if(isset($_SESSION['input']['title'])){
                                echo "<input id='title' type='text' name='title' value='" . $_SESSION['input']['title'] . "'><br>";
                            }else{
                                echo "<input id='title' type='text' name='title'><br>";
                            }
                            echo "<label for='date'>Date</label>";
                            
                            if(isset($_SESSION['input']['date'])){
                                echo "<input id='date' type='date' name='date' value='" . $_SESSION['input']['date'] . "'><br>";
                            }else{
                                echo "<input id='date' type='date' name='date'><br>";
                            }
            
                            echo "<label for='time-spent'> Time Spent</label>";
                            if(isset($_SESSION['input']['time_spent'])){
                                //set the time to keep it
                                echo "<input id='time-spent' type='text' name='timeSpent' placeholder='20 hours' value='" . $_SESSION['input']['time_spent'] . "'><br>";
                            }else{
                                echo "<input id='time-spent' type='text' name='timeSpent' placeholder='20 hours'><br>";
                            }
                            
                   
    
                            echo "
                                <label for='what-i-learned'>Learned</label>
                            ";
                            if(isset($_SESSION['input']['learned'])){
                                //set the learned to keep it
                                echo "<textarea id='what-i-learned' rows='5' name='whatILearned' placeholder='React.js'>" . $_SESSION['input']['learned'] . "</textarea>";
                            }else{
                                echo "<textarea id='what-i-learned' rows='5' name='whatILearned' placeholder='React.js'></textarea>";
                            }
                            echo "
                            <label for='resources-to-remember'>Resources to Remember</label>
                            ";
                            if(isset($_SESSION['input']['resources'])){
                                //set the tag to keep it
                                echo "<textarea id='resources-to-remember' rows='5' name='ResourcesToRemember' placeholder='reactjs.org'>" . $_SESSION['input']['resources'] . "</textarea>";
                            }else{
                                echo "<textarea id='resources-to-remember' rows='5' name='ResourcesToRemember' placeholder='reactjs.org'></textarea>";
                            }
                            echo "<input type='submit' value='Publish Entry' class='button'>
                            <a href='index.php' class='button button-secondary'>Cancel</a>
                        </form>
                    </div>
                </div>
            </section>";
        ?>
        <?php
            include("inc/footer.php");
        ?>
    </body>
</html>
