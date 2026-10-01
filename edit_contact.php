<?php
require_once('database.php');

$contactID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$contactID) {
    header('Location: index.php');
    exit();
}
$query = 'SELECT * FROM contacts WHERE contactID = :contactID';
$statement = $db->prepare($query);
$statement->bindValue(':contactID', $contactID);
$statement->execute();
$contact = $statement->fetch();
$statement->closeCursor();

$query = 'SELECT * FROM categories ORDER BY category_name';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
include('header.php');
?>

<h2>Edit Contact</h2>

<form action="update_contact.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="contactID"
           value="<?php echo $contact['contactID']; ?>">

    <label>First Name:</label>
    <input type="text" name="firstName"
           value="<?php echo $contact['firstName']; ?>" required>
    <br><br>
    <label>Last Name:</label>
<input type="text" name="lastName"
       value="<?php echo $contact['lastName']; ?>" required>
<br><br>

<label>Email:</label>
<input type="email" name="email"
       value="<?php echo $contact['email']; ?>" required>
<br><br>

<label>Phone:</label>
<input type="text" name="phone"
       value="<?php echo $contact['phone']; ?>" required>
<br><br>
<label>Category:</label>
<select name="category_id" required>
    <?php foreach ($categories as $category) : ?>
        <option value="<?php echo $category['category_id']; ?>"
            <?php if ($category['category_id'] == $contact['category_id']) echo 'selected'; ?>>
            <?php echo $category['category_name']; ?>
        </option>
    <?php endforeach; ?>
</select>
<br><br>

<label>New Image:</label>
<input type="file" name="image" accept="image/*">

<br><br>
<input type="submit" value="Update Contact">

</form>

<p><a href="index.php">Back to Contact List</a></p>

<?php include('footer.php'); ?>