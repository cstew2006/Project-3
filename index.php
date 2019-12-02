<?php include ("inc/header.php"); ?>

        <section>
            <div class="container">
                <div class="entry-list">

                    <?php
                    if(isset($sortTag)){
                        $entries = sort_by_tags($sortTag);
                        foreach($entries AS $entry) { //Got help with this section from reviewing Allan and Grants projects
                            
                            echo "<article>
                            <h2><a href=\"detail.php?id=". $entry['entry_id'] . "\">" .$entry['title']. "</a></h2>
                            <time datetime=\"" . $entry['date'] . "\">" . date('F, d, Y', strtotime($entry['date'])) . "</time>";
                            
                            $tags = get_tags_by_entry_id($entry['entry_id']);
                            if($tags == true){
                                echo "<p>";
                                $tags = array_column($tags, "tags");
                                foreach($tags as $tag){
                                    echo "<a class='taglink' href=index.php?tag=".$tag. ">#" . $tag . "</a> ";
                                }
                                echo "</p>";
                            }
                            
                             echo "</article>";
    
                        }
                    } else {
                        $entries = get_entry();
                        foreach ($entries as $entry) {
                            echo '<article>
                        <h2><a href="detail.php?id='.$entry['id'].'">'.$entry['title'].'</a></h2>
                        <time datetime="'.$entry['date'].'">'.date('F, d, Y', strtotime($entry['date'])).'</time>';
                            
                                
                                }
                                echo '</p>';
                            }
                            echo '</article>';
                                           
                    ?>

                </div>
            </div>
        </section>

<?php include ("inc/footer.php"); ?>
