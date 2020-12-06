<?php
define("IN_SYSTEM", true);
require "system/config.php";
require "system/functions/translateSort.php";
require "system/functions/array_csv_download.php";

// Get all initial data from the database
$email_data = $db->fetchAll("SELECT * FROM `subscriptions` ORDER BY `time`");

// Putting email providers into a unique list taken from data in the subscriptions table
$email_providers = array();
foreach($email_data as $email) {
    $email_providers[] = $email['email_provider'];
}

$email_providers = array_unique($email_providers);

if (isset($_POST['delete'])) {
    // If the delete button is pressed, we run send a delete command to the database
    $db->delete("DELETE FROM `subscriptions` WHERE `id` = ?", array(htmlspecialchars($_POST['delete'][0])));
    // Here we simply refresh the data after deletion
    $email_data = $db->fetchAll("SELECT * FROM `subscriptions` ORDER BY `time`");
}

if (isset($_POST['search']) OR isset($_POST['providers']) OR isset($_POST['sort'])) {
    // Checking if any of the filters have been applied

    if (isset($_POST['sort'])) {
        $sort = translateSort($_POST['sort']);
        $sort_key = $sort['type'];
        $sort_direction = $sort['sort'];
    }

    $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : null;
    $provider = isset($_POST['providers']) ? $_POST['providers'] : null;
    // One of the filters is applied
    if (!empty($_POST['search']) AND isset($_POST['providers']) AND isset($_POST['sort'])) {

        // All filters are applied
        $email_data = $db->fetchAll("SELECT * FROM `subscriptions` WHERE `email_provider` = '$provider' AND `email` LIKE '%$search%' ORDER BY $sort_key $sort_direction");

    } elseif (!empty($_POST['search']) AND isset($_POST['providers'])) {

        // If search and email provider filter is applied
        $email_data = $db->fetchAll("SELECT * FROM `subscriptions` WHERE `email_provider` = '$provider' AND `email` LIKE '%$search%' ORDER BY `time`");

    } elseif (isset($_POST['providers']) AND isset($_POST['sort'])) {

        // If email provider and sorting is applied
        $email_data = $db->fetchAll("SELECT * FROM `subscriptions` WHERE `email_provider` = '$provider' ORDER BY $sort_key $sort_direction");

    } elseif (!empty($_POST['search']) AND isset($_POST['sort'])) {

        // If search and sort is applied
        $email_data = $db->fetchAll("SELECT * FROM `subscriptions` WHERE `email` LIKE '%$search%' ORDER BY $sort_key $sort_direction");

    } elseif (!empty($_POST['search'])) {

        // If search is applied and contains value
        $email_data = $db->fetchAll("SELECT * FROM `subscriptions` WHERE `email` LIKE '%$search%' ORDER BY `time`");

    } elseif (isset($_POST['sort'])) {

        // If sort is applied
        $email_data = $db->fetchAll("SELECT * FROM `subscriptions` ORDER BY $sort_key $sort_direction");

    } elseif (isset($_POST['providers'])) {

        // If providers is applied
        $email_data = $db->fetchAll("SELECT * FROM `subscriptions` WHERE `email_provider` = '$provider' ORDER BY `time`");

    }
}

if (isset($_POST['export'])) {
    if (isset($_POST['emailId'])) {
        $ids = array_values($_POST['emailId']);
        $ids_list = implode(",", $ids);
        $testdata = $db->fetchAll("SELECT * FROM `subscriptions` WHERE `id` IN($ids_list)");

        array_csv_download($testdata, "export-" . date("d-m-Y-H-i", time()) . ".csv");
    }
}

// Checking if an existing filter has been applied and adding values to each input
$existing_search = isset($_POST['search']) ? $_POST['search'] : "";
$selected_provider = isset($_POST['providers']) ? $_POST['providers'] : "";
$selected_sort = isset($_POST['sort']) ? $_POST['sort'] : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/data_style.css"/>
    <script src="./assets/js/resetForm.js"></script>
    <script src="./assets/js/checkAll.js"></script>
    <title>Email Data</title>
</head>
<body>
    <table>
    <tr>
        <form method="POST" id="form">
        <th>
        Search:
        <input type="text" name="search" placeholder="Search..." value="<?=$existing_search?>"/>
        </th>
        <th>
        Filter:
            <select name="sort">
                <option selected="true" disabled="disabled">Select sort</option>
                <option value="date_asc" <?=($selected_sort === "date_asc") ? "selected" : ""?>>Date (ascending)</option>
                <option value="date_desc" <?=($selected_sort === "date_desc") ? "selected" : ""?>>Date (descending)</option>
                <option value="email_asc" <?=($selected_sort === "email_asc") ? "selected" : ""?>>Email (ascending)</option>
                <option value="email_desc" <?=($selected_sort === "email_desc") ? "selected" : ""?>>Email (descending)</option>
            </select>
        </th>
        <th>
        Email providers:
            <select name="providers">
                <option selected="true" disabled="disabled">Select provider</option>
                <?php foreach($email_providers as $provider): ?>
                    <option value="<?=$provider?>" <?=($selected_provider === $provider) ? "selected" : ""?>><?=$provider?></option>
                <?php endforeach; ?>
            </select>
        </th>
        <th>
            <button type="button" onClick="resetForm()">Reset</button>
            <button type="submit">Filter</button>
        </th>
        </form>
    </tr>
    <tr>  
        <th><input type="checkbox" onClick="checkAll(this)"/></th>
        <th>Email</th>
        <th>Date & Time</th>
        <th>Delete?</th>
    </tr>
    <?php if (!empty($email_data)): ?>
    <form method="POST">
    <?php foreach($email_data as $email): ?>
    <tr>
        <td><input type="checkbox" name="emailId[]" value="<?=$email['id']?>" class="emailCheckbox"/></td>
        <td><?=$email['email']?></td>
        <td><?=date("d.m.Y H:i", $email['time'])?></td>
        <td><button name="delete[]" value="<?=$email['id']?>">Delete</button></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="4" style="text-align: left;"><button name="export">Export as csv</button></td>
    </tr>
    </form>
    <?php else: ?>
    <tr>
        <td colspan="4">No data</td>
    </tr>
    <?php endif; ?>
    </table>
</body>
</html>