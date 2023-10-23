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
