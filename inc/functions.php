<?php


function get_list_entries() 
{
    include 'connection.php';

    $sql = "SELECT  entries.id, entries.title, entries.date, GROUP_CONCAT(tags.name, ' ') AS name FROM entries
        LEFT OUTER JOIN the_link ON entries.id = the_link.entry_id 
        LEFT OUTER JOIN tags ON the_link.tags_id = tags.id
        GROUP BY entries.id ORDER BY date DESC";

    try {
        return $db->query($sql);
    } catch (Exception $e) {
        echo 'ERROR!: ' . $e->getMessage() . ' 😕 <br>';
        return [];
    }
}

function pull_tags() 
{
    include 'connection.php';

    try {


        $tagsArray = [];
        $tags = $db->query('SELECT name FROM tags')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tags as $tag) {
            $tagsArray[] = $tag['name'];
        }
        return $tagsArray;
    } catch (Exception $e) {
        echo 'ERROR!: ' . $e->getMessage() . ' 😕 <br>';
        return [];
    }
}

function add_entry($title, $date, $timeSpent, $learned, $resources = null, $tags = null)
{
    include 'connection.php';

    try {


        $db->beginTransaction();

        $sql = 'INSERT INTO entries (title, date, time_spent, learned, resources) VALUES (?, ?, ?, ?, ?)';
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $timeSpent, PDO::PARAM_STR);
        $results->bindValue(4, $learned, PDO::PARAM_STR);
        $results->bindValue(5, $resources, PDO::PARAM_STR);
        $results->execute();
        $entry_id = $db->lastInsertId();

        foreach ($tags as $tag) {

            if (isset($tag) && (in_array($tag, get_tags())) == false) {
                $sql = 'INSERT INTO tags (name) VALUES (?)';
                $results = $db->prepare($sql);
                $results->bindValue(1, $tag, PDO::PARAM_STR);
                $results->execute();
                $tags_id = $db->lastInsertId();

                $sql = "INSERT INTO the_link (entry_id, id_tags) VALUES ($entry_id, $id_tags)";
                $db->query($sql);

            } elseif (isset($tag)) {

                $sql = 'SELECT id FROM tags WHERE name = ?';
                $results = $db->prepare($sql);
                $results->bindValue(1, $tag, PDO::PARAM_STR);
                $results->execute();
                $id_tags = $results->fetch();
                $id_tags = $id_tags[0];

                $sql = "INSERT INTO the_link (entry_id, id_tags) VALUES ($entry_id, $id_tags)";
                $db->query($sql);
            }
        }

        $db->commit();

    } catch (Exception $e) {
        echo 'ERROR!: ' . $e->getMessage() . ' 😕 <br>';
        $db->rollBack();
        return false;
    }
    return true;
}

function get_entry($id)
{
    include 'connection.php';

    $sql = "SELECT entries.id, entries.title, entries.date, entries.time_spent, entries.learned, entries.resources, GROUP_CONCAT(tags.name, ' ') AS name
        FROM entries 
        LEFT OUTER JOIN the_link ON entries.id = the_link.entry_id 
        LEFT OUTER JOIN tags ON id_link_tags = id_tags
        WHERE entries.id = ?
        GROUP BY entries.id ORDER BY date DESC";

    try {

        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();

    } catch (Exception $e) {

        echo 'ERROR!: ' . $e->getMessage() . ' 😕 <br>';
        return false;
    }
    return $results->fetch();
}

function edit_entry($id, $title, $date, $timeSpent, $learned, $resources = null, $tags = null)
{
    include 'connection.php';

    try {

        $db->beginTransaction();

        $sql = 'DELETE FROM a_link WHERE entry_id = ?';
        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();

        $sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? WHERE id = ?';
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $timeSpent, PDO::PARAM_STR);
        $results->bindValue(4, $learned, PDO::PARAM_STR);
        $results->bindValue(5, $resources, PDO::PARAM_STR);
        $results->bindValue(6, $id, PDO::PARAM_INT);
        $results->execute();

        foreach ($tags as $tag) {

            if (isset($tag) && (in_array($tag, get_tags())) == false) {
                $sql = 'INSERT INTO tags (name) VALUES (?)';
                $results = $db->prepare($sql);
                $results->bindValue(1, $tag, PDO::PARAM_STR);
                $results->execute();
                $tags_id = $db->lastInsertId();

                $sql = "INSERT INTO a_link (entry_id, id_tags) VALUES ($id, $id_tags)";
                $db->query($sql);
            } elseif (isset($tag)) {
                $sql = 'SELECT id FROM tags WHERE name = ?';
                $results = $db->prepare($sql);
                $results->bindValue(1, $tag, PDO::PARAM_STR);
                $results->execute();
                $tags_id = $results->fetch();
                $tags_id = $tags_id[0];

                $sql = "INSERT INTO a_link (entry_id, id_tags) VALUES ($id, $id_tags)";
                $db->query($sql);
            }
        }

        $db->commit();

    } catch (Exception $e) {
        echo 'ERROR!: ' . $e->getMessage() . ' 😕 <br>';
        $db->rollBack();
        return false;
    }
    return true;
}

function delete_entry($id) {

    include 'connection.php';

    try {
        
        $db->beginTransaction();

        $sql = 'DELETE FROM entries WHERE id = ?';
        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();

        $sql = 'DELETE FROM a_link WHERE entry_id = ?';
        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();

        $db->commit();

    } catch (Exception $e) {
        echo 'ERROR!: ' . $e->getMessage() . ' 😕 <br>';
        $db->rollBack();
        return false;
    }
    return true;
}

function get_part_tag($name) 
{
    include 'connection.php';

    $sql = 'SELECT entries.id, entries.title, entries.date, tags.name
        FROM entries 
        LEFT OUTER JOIN the_link ON entries.id = the_link.entry_id 
        LEFT OUTER JOIN tags ON id_link_tags = id.tags
        WHERE tags.name = ?
        ORDER BY date DESC';

    try {

        $results = $db->prepare($sql);
        $results->bindValue(1, $name, PDO::PARAM_STR);
        $results->execute();

    } catch (Exception $e) {

        echo 'ERROR!: ' . $e->getMessage() . ' 😕 <br>';
        return false;
    }
    return $results->fetchAll(PDO::FETCH_ASSOC);
}
