<?php
require_once('database.php');

$query = 'SELECT * FROM contacts ORDER BY lastName';
$statement = $db->prepare($query);
$statement->execute();
$contacts = $statement->fetchAll();
$statement->closeCursor();

include('header.php');
?>

<h2>Contact List</h2>

<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
    </tr>

    <?php foreach ($contacts as $contact) : ?>
    <tr>
        <td><?php echo $contact['firstName']; ?></td>
        <td><?php echo $contact['lastName']; ?></td>
        <td><?php echo $contact['email']; ?></td>
        <td><?php echo $contact['phone']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include('footer.php'); ?>