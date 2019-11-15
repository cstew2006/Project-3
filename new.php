<?php
require 'inc/functions.php';
$title = $date = $time = $learned = $resources = $tag = '';
$page = 'New Entry';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_NUMBER_INT));
    $timeUnits = trim(filter_input(INPUT_POST, 'timeSpentUnits', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));
    $tag = trim(filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING));
    if (add_entry($title, $date, $time, $timeUnits, $learned, $resources, $tag)) {
        echo 'Successfully added entry.';
        header('refresh: 1; url = index.php');
    } else {
        echo 'Unable to add entry. Try again.';
    }
}
include 'inc/header.php'; ?>
    <section>
      <div class="container">
        <div class="new-entry">
          <h2>New Entry</h2>
          <form method="post">
            <label for="title">Title<span style="color:red">*</span></label>
            <input id="title" type="text" name="title" required><br>
            <label for="date">Date<span style="color:red">*</span></label>
            <input id="date" type="date" name="date" required><br>
            <label for="time-spent">Time Spent<span style="color:red">*</span></label>
            <input id="time-spent" type="number" name="timeSpent" required>
            <select name="timeSpentUnits" required>
              <option value="hour(s)">hour(s)</option>
              <option value="minute(s)">minute(s)</option>
            </select>
            <label for="what-i-learned">What I Learned<span style="color:red">*</span></label>
            <textarea id="what-i-learned" rows="5" name="whatILearned" required></textarea>
            <label for="resources-to-remember">Resources to Remember (separate with commas)</label>
            <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"></textarea>
            <label for="tags">Tags (separate with commas)</label>
            <textarea id="tags" rows="2" name="tags"></textarea>
            <input type="submit" value="Publish Entry" class="button">
            <a href="index.php" class="button button-secondary">Cancel</a>
          </form>
        </div>
      </div>
    </section>
<?php include 'inc/footer.php'; ?>