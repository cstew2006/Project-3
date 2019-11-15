<?php
function get_entry() {
    include 'connection.php';
    //referred to Chizzys project for another exampe for try/catch
    try {
        return $db->query('SELECT date, ID, TITLE, tags FROM entries ORDER BY date DESC');
        
    } catch (Exception $e) {
        
        echo "Error: " . $e->getMessage() . "<br>";
        return array();
    }
}
function get_entry_list_by_tag($tag) {
    
    include 'connection.php';
    
    try {
        return $db->query("SELECT ID, TITLE, date, tags FROM entries WHERE tags LIKE '%$tag%' ORDER BY date DESC");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return array();
    }
}
function get_entries($id) {
    include 'connection.php';
    $sql = "SELECT * FROM entries WHERE id = ?";
    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
        
    }
    
    return $results->fetch(PDO::FETCH_ASSOC);
    
}

function search_entries($search, $searchby) {
    include 'connection.php';
    try {
        if ($searchby == 'title') {
            return $db->query("SELECT TITLE, ID, date, tags FROM entries WHERE title LIKE '%$search%' ORDER BY date DESC");
        } else {
            return $db->query("SELECT TITLE, ID, date, tags FROM entries WHERE tags LIKE '%$search%' ORDER BY date DESC");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return array();
        
    }
    
}

function entry_count($search, $searchby) {
    include 'connection.php';
    if ($searchby == 'title') {
        $sql = "SELECT COUNT(*) FROM entries WHERE title LIKE '%$search%'";
    } else {
        $sql = "SELECT COUNT(*) FROM entries WHERE tags LIKE '%$search%'";
    }
    try {
        $results = $db->prepare($sql);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    return $results->fetchColumn();
}

function add_entry($date, $time, $title, $timeUnits, $learned, $resources, $tag) {
    include 'connection.php';
    $sql = 'INSERT INTO entries (title, date, timespent, timeunits, learned, resources, tags) VALUES (?, ?, ?, ?, ?, ?, ?)';
    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $time, PDO::PARAM_INT);
        $results->bindValue(4, $timeUnits, PDO::PARAM_STR);
        $results->bindValue(5, $learned, PDO::PARAM_LOB);
        $results->bindValue(6, $resources, PDO::PARAM_LOB);
        $results->bindValue(7, $tag, PDO::PARAM_LOB);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    
    return true;
    
}

function edit_entry($title, $date, $time, $timeUnits, $learned, $resources, $tag, $id) {
    include 'connection.php';
    $sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, time_units = ?, learned = ?, resources = ?, tags = ? WHERE id = ?';
    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $time, PDO::PARAM_INT);
        $results->bindValue(4, $timeUnits, PDO::PARAM_STR);
        $results->bindValue(5, $learned, PDO::PARAM_LOB);
        $results->bindValue(6, $resources, PDO::PARAM_LOB);
        $results->bindValue(7, $tag, PDO::PARAM_LOB);
        $results->bindValue(8, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    
    return true;
    
}

function delete_entry($id) {
    include 'connection.php';
    $sql = 'DELETE FROM entries WHERE id = ?';
    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    return true;
    
}
