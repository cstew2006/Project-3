<?php
require 'inc/functions.php';

$pageTitle = 'Edit Entry';
$page = 'edit';
$title = $date = $timeSpent = $learned = $resources = $tags = '';


if (isset($_GET['entry'])) {
    list($id, $title, $date, $timeSpent, $learned, $resources, $tags) = get_entry(filter_input(INPUT_GET, 'entry', FILTER_SANITIZE_NUMBER_INT));
    $_POST['tags'] = explode(" ", $tags);
}

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

    if (empty($date) || empty($learned) || empty($timeSpent) || empty($title)) {
        $error_message = 'Please fill in the required fields: Title, Date, Time Spent, What I Learned';
    } elseif (count($timeMatch) != 2 
                    || is_numeric($timeMatch[0]) == false 
                    || (!in_array($timeMatch[1], ['hr(s)','min(s)'], true))) {
        $error_message = 'Incorrect format. Try again using hr(s) or min(s).';
    } else {
        if (edit_entry($id, $title, $date, $timeSpent, $learned, $resources, $tags)) {
            header("location: detail.php?entry=$id");
            exit;
        } else {
            $error_message = 'unable to update entry';
        }
    }
}

include 'inc/header.php';
?>


<div class="edit-entry">
    <h2>Edit Entry</h2>
    <?php
    if (isset($error_message)) {
        echo '<p class="message">' . $error_message . '</p>';
    }
    ?>
    <form method="POST" action="edit.php">
        <label for="title">Title<span class="required">*</span></label>
        <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($title); ?>"><br>
        <label for="date">Date<span class="required">*</span></label>
        <input id="date" type="date" name="date" value="<?php echo htmlspecialchars($date); ?>"><br>
        <label for="time-spent">Time Spent<span class="required">*</span> <i>Use hr(s) or min(s)</i></label>
        <input id="time-spent" type="text" name="timeSpent" placeholder="Example: 3 min(s)" value="<?php echo htmlspecialchars($timeSpent); ?>"><br>
        <label for="what-i-learned">What I Learned<span class="required">*</span></label>
        <textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo htmlspecialchars($learned); ?></textarea>
        <label for="resources-to-remember">Resources to Remember</label>
        <textarea id="resources-to-remember" rows="5" name="resourcesToRemember"><?php echo htmlspecialchars($resources); ?></textarea>
        <label for="tags">Tags</label>
        
            <?php
            foreach (get_tags() as $tag) {
                echo "<option value='$tag'";
                if (isset($_POST['tags']) && in_array($tag, $_POST['tags'])) {
                    echo ' selected';
                }
                echo ">$tag";
                echo '</option>';
            }
            ?>
        </select>

        <?php
        if (!empty($id)) {
            echo '<input type="hidden" name="id" value="' . $id . '">';
        }
        ?>
        
        <input type="submit" value="Update Entry" class="button">
        <a href="detail.php?entry=<?php echo $id; ?>" class="button button-secondary">Cancel</a>
    </form>
</div>

<?php include 'inc/footer.php' ?>
