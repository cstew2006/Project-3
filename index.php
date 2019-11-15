<?php
require 'inc/functions.php';

$date = $learned = $title = $time = $resources = $tag = '';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$item = get_entry($id);

$page = 'Edit Entry';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_NUMBER_INT));
    $timeUnits = trim(filter_input(INPUT_POST, 'timeSpentUnits', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));
    $tag = trim(filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING));
    if (edit_entry($title, $date, $time, $timeUnits, $learned, $resources, $tag, $id)) {
        echo 'The entry has been successfully updated.';
        header('refresh: 1; url = detail.php?id=' . $id . '');
    } else {
        echo 'Edit invalid. Please try again.';
    }
    
}

include 'inc/header.php'; ?>
    <section>
      <div class="container">
        <div class="edit-entry">
          <h2>Edit Entry</h2>
          <form method="post">
            <label for="title">Title</label>
            <input id="title" type="text" name="title" value="<?php echo $item['title']; ?>"><br>
            <label for="date">Date</label>
            <input id="date" type="date" name="date" value="<?php echo $item['date']; ?>"><br>
            <label for="time-spent">Time Spent</label>
            <input id="time-spent" type="number" name="timeSpent" value="<?php echo $item['time_spent']; ?>">
            <select name="timeSpentUnits" required>
              <option value="hour(s)" <?php if ($item['time_units'] == 'hour(s)') { echo 'selected'; } ?>>hour(s)</option>
              <option value="minute(s)" <?php if ($item['time_units'] == 'minute(s)') { echo 'selected'; } ?>>minute(s)</option>
            </select>
            <label for="what-i-learned">What I Learned</label>
            <textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo $item['learned']; ?></textarea>
            <label for="resources-to-remember">Resources to Remember (separate with commas)</label>
            <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"><?php echo $item['resources']; ?></textarea>
            <label for="tags">Tags (separate with commas)</label>
            <textarea id="tags" rows="2" name="tags"><?php echo $item['tags']; ?></textarea>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Edit Entry" class="button">
            <a href="index.php" class="button button-secondary">Cancel</a>
          </form>
        </div>
      </div>
    </section>
<?php include 'inc/footer.php'; ?>
