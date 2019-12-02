<?php 
include ("inc/header.php"); 

if ('GET' == $_SERVER['REQUEST_METHOD']) {
    if (isset($_GET['id'])) {
        $entryId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    } else {
        header('location: index.php');
    }
}
$thisEntry = get_entry_with_id($entryId);
?>

        <section>
            <div class="container">
                <div class="entry-list single">
                    <article>
                        <h1><?php echo $thisEntry['title']; ?></h1>
                        <time datetime="<?php echo $thisEntry['date']; ?>"><?php echo date('F, d, Y', strtotime($thisEntry['date'])); ?></time>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p><?php echo $thisEntry['time_spent']; ?></p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p><?php echo $thisEntry['learned']; ?></p>
                            
                        </div>
                        <?php
                            if($thisEntry['resources'] != NULL) { ?>
                             <div class="entry">
                           
                            <h3>Resources to Remember:</h3>
                            <ul>
                                <?php 
                                    $resources = explode(",",$thisEntry['resources']);
                                    foreach($resources as $resource){
                                        echo "<li><a href=\"\">". $resource . "</a></li>";
                                    }
                             
                                ?>
                            </ul>
                        </div>
                          <?php  } ?>

                         
                              </div>

                    </article>
                </div>
            </div>
            <div class="edit">
                <p><a href="edit.php?id=<?php echo $entryId; ?>">Edit Entry</a></p>
            </div>
        </section>

<?php include ("inc/footer.php"); ?>
