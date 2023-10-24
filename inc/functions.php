<?php
// Application functions

function get_projects_list()
{
    //Import the database connection: 
    // PDO: $database_connection
    include 'database_connection.php';

    try {
        // Get all projects
        return $database_connection->query(
            'SELECT project_id, title, category
            FROM projects'
        );
    } catch (Exception $e) {
        echo 'Error getting projects list: '
            . $e->getMessage()
            . '</br>';
        // Return an empty array the UI in case of an error 
        return array();
    }
}


function add_project($title, $category)
{
    include 'database_connection.php';

    $query = "
    INSERT INTO projects (title, category)
    VALUES (?, ?)
    " ;

    try {
        $results = $database_connection->prepare($query);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $category, PDO::PARAM_STR);
        $results->execute();
    } catch (Exception $e) {
        echo "Error adding project to database: " . $e->getMessage() . '<br />';
        return false;
    }
    return true;
}


function get_tasks_list()
{
    //Import the database connection: 
    // PDO: $database_connection
    include 'database_connection.php';

    $query = "
    SELECT tasks.*, projects.title AS project FROM tasks
    JOIN projects ON tasks.project_id = projects.project_id 
    ";

    try {
        // Get all projects
        return $database_connection->query($query);
    } catch (Exception $e) {
        echo 'Error getting tasks list: '
            . $e->getMessage()
            . '</br>';
        // Return an empty array the UI in case of an error 
        return array();
    }
}

function add_task($project_id, $title, $date, $time)
{
    include 'database_connection.php';

    $query = "
    INSERT INTO tasks (project_id, title, date, time)
    VALUES (?, ?, ?, ?)
    " ;

    try {
        $results = $database_connection->prepare($query);
        $results->bindValue(1, $project_id, PDO::PARAM_INT);
        $results->bindValue(2, $title, PDO::PARAM_STR);
        $results->bindValue(3, $date, PDO::PARAM_STR);
        $results->bindValue(4, $time, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error adding task to database: " . $e->getMessage() . '<br />';
        return false;
    }
    return true;
}