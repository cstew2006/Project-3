<?php
function get_entries() {
    include 'connection.php';
    try {
        return $db->query('SELECT date, ID, TITLE, tags FROM entries ORDER BY date DESC');
        
    } catch (Exception $e) {
        
        echo "Error: " . $e->getMessage() . "<br>";
        return array();
    }
}
function get_entry($id){
    include 'connection.php';
$sql = 'SELECT id,title,date,time_spent,learned,resources FROM entries WHERE id = ?';
try{
    $results = $db->prepare($sql);
    $results->bindValue(1, $id, PDO::PARAM_INT);
    $results->execute();
} catch (Exception $e) {
    echo "Error!: " . $e->getMessage() . "<br />";
    return false;
  }
  
return $results->fetch();
  
}

function add_entry($title, $date, $time_spent, $learned, $resources, $id = null){
    include 'connection.php';
if ($id){
  $sql = 'UPDATE entries SET title=?, date =?, time_spent=?,learned=?,resources=? WHERE id = ?';
}else{
$sql = 'INSERT INTO entries(title, date, time_spent, learned, resources) VALUES(?,?,?,?,?)';
}
  
try{
    $results = $db->prepare($sql);
    $results->bindValue(1, $title, PDO::PARAM_STR);
    $results->bindValue(2, $date, PDO::PARAM_STR);
    $results->bindValue(3, $time_spent, PDO::PARAM_STR);
    $results->bindValue(4, $learned, PDO::PARAM_STR);
    $results->bindValue(5, $resources, PDO::PARAM_STR);
    if ($id){
      $results->bindValue(6, $id, PDO::PARAM_INT);
    }
    $results->execute();
} catch (Exception $e) {
    echo "Error!: " . $e->getMessage() . "<br />";
    return false;
}
  
  return true;
}

function delete_entry($id){
      include 'connection.php';
$sql = 'DELETE FROM entries WHERE id = ?';
  try{
      $results = $db->prepare($sql);
      $results->bindValue(1, $id, PDO::PARAM_INT);
      $results->execute();
  } catch (Exception $e) {
      echo "Error!: " . $e->getMessage() . "<br />";
      return false;
    }
  
return true;
  
}
