<?php
require_once('database.php');

// Get categories for the dropdown
$query = 'SELECT * FROM categories ORDER BY category_name';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();

// Add contact when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $category_id = $_POST['category_id'];
    $image = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $image = basename($_FILES['image']['name']);
    $target = 'uploads/' . $image;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
}

    $query = 'INSERT INTO contacts
          (firstName, lastName, email, phone, category_id, image)
          VALUES
          (:firstName, :lastName, :email, :phone, :category_id, :image)';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':category_id', $category_id);
    $statement->bindValue(':image', $image);
    $statement->execute();
    $statement->closeCursor();

    header('Location: index.php');
    exit();
}

include('header.php');
?>

<h2>Add Contact</h2>

<form action="add_contact.php" method="post" enctype="multipart/form-data">
    <label>First Name:</label>
    <input type="text" name="firstName" required><br><br>

    <label>Last Name:</label>
    <input type="text" name="lastName" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <label>Phone:</label>
    <input type="text" name="phone" required><br><br>

    <label>Category:</label>
    <select name="category_id" required>
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['category_id']; ?>">
                <?php echo $category['category_name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label>Image:</label>
<input type="file" name="image" accept="image/*">

    <br><br>

    <input type="submit" value="Add Contact">

</form>

<p><a href="index.php">Back to Contact List</a></p>

<?php include('footer.php'); ?>