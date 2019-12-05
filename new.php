<?php
require 'inc/functions.php';

$pageTitle = 'New Entry';
$page = 'new';
$title = $date = $timeSpent = $learned = $resources = $tags = '';

if (isset($_POST['tags'])) {
    $_POST['tags'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $timeSpent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'resourcesToRemember', FILTER_SANITIZE_STRING));
    $tags = filter_input(INPUT_POST, 'tags', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    $timeMatch = explode(' ', $timeSpent);

    if (empty($title) || empty($date) || empty($timeSpent) || empty($learned)) {
        $error_message = 'Please fill in the required fields: Title, Date, Time Spent, What I Learned';
    } elseif (count($timeMatch) != 2 
                    || is_numeric($timeMatch[0]) == false 
                    || (!in_array($timeMatch[1], ['hr(s)','min(s)'], true))) {
        $error_message = 'Invalid format for Time Spent. Use hr(s) or min(s).';
    } else {
        if (add_entry($title, $date, $timeSpent, $learned, $resources, $tags)) {
            header('location: index.php');
            exit;
        } else {
            $error_message = 'Could not create new entry';
        }
    }
}

include 'inc/header.php';
?>



<div class="new-entry">
    <h2>New Entry</h2>
    <?php
    if (isset($error_message)) {
        echo '<p class="message">' . $error_message . '</p>';
    }
    ?>
    <form method="POST" action="new.php">
        <label for="title">Title<span class="required">*</span></label>
        <input id="title" type="text" name="title" value="<?php echo $title; ?>"><br>
        <label for="date">Date<span class="required">*</span></label>
        <input id="date" type="date" name="date" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $date; ?>"><br>
        <label for="time-spent">Time Spent<span class="required">*</span> <i>Use hr(s) or min(s)</i></label>
        <input id="time-spent" type="text" name="timeSpent" placeholder="Example: 1 min(s)" value="<?php echo $timeSpent; ?>"><br>
        <label for="what-i-learned">What I Learned<span class="required">*</span></label>
        <textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo $learned; ?></textarea>
        <label for="resources-to-remember">Resources to Remember</label>
        <textarea id="resources-to-remember" rows="5" name="resourcesToRemember"><?php echo $resources; ?></textarea>
        <label for="tags">Tags</label>
        
            <?php
            foreach (pull_tags() as $tag) {
                echo "<option value='$tag'";
                if (isset($_POST['tags']) && in_array($tag, $_POST['tags'])) {
                    echo ' selected';
                }
                echo ">$tag";
                echo '</option>';
            }
            ?>
        </select>
        <script>
            $(document).ready(function() {
                $("#tags").select2({
                    tags: true,
                    
                });
            });
        </script>
        <input type="submit" value="Publish Entry" class="button">
        <a href="index.php" class="button button-secondary">Cancel</a>
    </form>
</div>

<?php include 'inc/footer.php' ?>
