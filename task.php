<?php
require 'inc/functions.php';

$pageTitle = "Task | Time Tracker";
$page = "tasks";

// Initialise variables for form fields as empty strings
$project_id = $title = $date = $time = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = trim(filter_input(INPUT_POST, 'project_id', FILTER_SANITIZE_NUMBER_INT));
    $title = trim(htmlspecialchars($_POST['title']));
    $date = trim(htmlspecialchars($_POST['date']));
    $time = trim(filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT));

    // Parse the string date entered into day/month/year
    $date_separated = explode('/', $date);

    if (empty($project_id) || empty($title) || empty($date) || empty($time)) {
        $error_message = "Please fill in the required fields: Project, Title, Date, Time";
    } elseif (
        // If there is not a value for day, month, & year
        count($date_separated) != 3
        // If the values for day, month, or year are not the correct number of characters long
        || strlen($date_separated[0]) != 2
        || strlen($date_separated[1]) != 2
        || strlen($date_separated[2]) != 4
        || !checkdate($date_separated[0], $date_separated[1], $date_separated[2])
    ) {
        $error_message = 'Invalid date';
    } else {
        if (add_task($project_id, $title, $date, $time)) {
            header('Location: task_list.php');
            exit;
        } else {
            $error_message = "Unable to add task";
        }
    }
}

include 'inc/header.php';
?>

<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">Add Task</h1>
            <?php
            if (isset($error_message)) {
                echo "<p class='message'>$error_message</p>";
            }
            ?>
            <form class="form-container form-add" method="post" action="task.php">
                <table>
                    <tr>
                        <th>
                            <label for="project_id">Project</label>
                        </th>
                        <td>
                            <select name="project_id" id="project_id">
                                <option value="">Select One</option>
                                <?php
                                // Populate the UI with projects from the database
                                foreach (get_projects_list() as $project) {
                                    echo '<option value="'
                                        . $project['project_id']
                                        . '" ';
                                    if ($project_id == $project['project_id']) {
                                        echo ' selected';
                                    }
                                    echo '>'
                                        . $project['title']
                                        . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="title">Title<span class="required">*</span></label></th>
                        <td><input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="date">Date<span class="required">*</span></label></th>
                        <td><input type="text" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>" placeholder="mm/dd/yyyy" /></td>
                    </tr>
                    <tr>
                        <th><label for="time">Time<span class="required">*</span></label></th>
                        <td><input type="text" id="time" name="time" value="<?php echo htmlspecialchars($time); ?>" /> minutes</td>
                    </tr>
                </table>
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>