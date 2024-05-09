<?php
session_start();

if ($_SESSION['loggedin'] !== "admin") {
    header("Location: admin.html");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create NFT | Job Dashboard</title>
  <link rel="stylesheet" href="style.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
  <div class="container">
    <nav>
      <div class="navbar">
        <div class="logo">
          <img src="/dashboard.jpg" alt="">
          <h2>Dashboard</h2>
        </div>
        <ul>

      <li><a href="?s=create">Create NFT</a></li>
      
      <li><a href="?s=edit">Edit NFT</a></li>
      <li><a href="?Support">View Tickets</a></li>
      <li><a href="?users">View Users</a></li>

          <ul>
            <li><a href="logout.php" class="logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-item">Logout</span>
              </a>
            </li>
          </ul>
        </ul>
      </div>
    </nav>
    <?php
    if (isset($_GET['Support'])) {
        include 'view_tickets.php';
    } elseif (isset($_GET['users'])) {
        include 'view_users.php'; // Include view users file
    } elseif (isset($_GET['s']) && $_GET['s'] == 'create') {
        // Include create NFT form
    } elseif (isset($_GET['s']) && $_GET['s'] == 'edit') {
        // Include edit NFT form
    }
    ?>

<?php if(isset($_GET['s']) && $_GET['s'] == 'create'): ?>
    <section class="main" id="createNFTSection">
      <div class="main-top">
        <p>Create new NFT</p>
      </div>
      <div class="main-body">
        <form action="create_nft.php" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
          </div>
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
          </div>
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>
          </div>
          <div class="form-group">
            <label for="for_sale">For Sale:</label>
            <select id="for_sale" name="for_sale" required>
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
          <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
              <option value="digital_art">Digital Art</option>
              <option value="abstract_art">Abstract Art</option>
              <option value="aI_art">AI Art</option>
              <option value="sci-fi_art">Sci-Fi Art</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit">Create NFT</button>
          </div>
        </form>
        <?php if (isset($_GET['message'])): ?>
            <p><?= $_GET['message'] ?></p>
        <?php endif; ?>
    </section>
<?php elseif(isset($_GET['s']) && $_GET['s'] == 'edit'): ?>
    <section class="main" id="editNFTSection">
    <div class="main-top">
        <p>Create new NFT</p>
      </div>
      <div class="main-body">
        <form action="edit_nft.php" method="POST" enctype="multipart/form-data">
          <div class="form-group">
          <label for="id">NFT ID:</label>
            <input type="number" id="nft_id" name="nft_id" min="1" required>
          </div>
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
          </div>
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>
          </div>
          <div class="form-group">
            <label for="for_sale">For Sale:</label>
            <select id="for_sale" name="for_sale" required>
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
          <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
              <option value="digital_art">Digital Art</option>
              <option value="abstract_art">Abstract Art</option>
              <option value="aI_art">AI Art</option>
              <option value="sci-fi_art">Sci-Fi Art</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit">Edit NFT</button>
          </div>
        </form>
        <div class="delete-form error">
          <h3>Delete NFT by ID</h3>
          <form action="delete_nft.php" method="POST">
            <div class="form-group">
              <label for="delete_id">Enter ID to Delete:</label>
              <input type="number" id="delete_id" name="delete_id" min="1" required>
            </div>
            <div class="form-group">
              <button type="submit" name="delete_submit">Delete NFT</button>
            </div>
          </form>
        </div>
    </section>
<?php endif; ?>

  </div>
</body>
</html>
