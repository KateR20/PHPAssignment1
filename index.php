<?php
require_once('database.php');

$query = 'SELECT contacts.*, categories.category_name
          FROM contacts
          LEFT JOIN categories
          ON contacts.category_id = categories.category_id
          ORDER BY contacts.lastName';

$statement = $db->prepare($query);
$statement->execute();
$contacts = $statement->fetchAll();
$statement->closeCursor();

include('header.php');
?>

<h2>Contact List</h2>
<p><a href="add_contact.php">Add New Contact</a></p>

<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Category</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($contacts as $contact) : ?>
        
    <tr>
        <td><?php echo $contact['firstName']; ?></td>
<td><?php echo $contact['lastName']; ?></td>
<td><?php echo $contact['email']; ?></td>
<td><?php echo $contact['phone']; ?></td>

<td><?php echo $contact['category_name']; ?></td>

<td>
    <?php if (!empty($contact['image'])) : ?>
        <img src="uploads/<?php echo $contact['image']; ?>" width="80" alt="Contact Image">
    <?php endif; ?>
</td>

<td>
    <a href="edit_contact.php?id=<?php echo $contact['contactID']; ?>">Edit</a>
    |
    <a href="delete_contact.php?id=<?php echo $contact['contactID']; ?>">Delete</a>
</td>
        
    </tr>
    <?php endforeach; ?>
</table>

<?php include('footer.php'); ?>