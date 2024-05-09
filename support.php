<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.html");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>NFT</title>
  <style>
    
    .nft-container {

        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .nft-card {
        margin: 10px 10px 10px 10px; /* Added margin-left to shift cards to the right */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 200px;
        overflow: hidden; 
    }

    .nft-image {
        width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .nft-name {
        font-size: 18px;
        font-weight: bold;
        margin-top: 10px;
        height: 30px; 
        overflow: hidden; 
        text-overflow: ellipsis; 
    }

    .nft-description {
        margin-top: 5px;
        height: 100px; 
        overflow: auto; 
    }

    .nft-price {
        margin-top: 5px;
        font-weight: bold;
    }

    .add-to-cart-btn {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .add-to-cart-btn:hover {
        background-color: #0056b3;
    }
    </style>

<link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
  <div class="container">
    <nav>
      <div class="navbar">
        <div class="logo">
          <img src="/nft.webp" alt="">
          <h2>NFT Market</h2>
        </div>
        <li><a href="menu.php?category=all">
        <i class="fas fa-chart-bar"></i>
        <span class="nav-item">Store</span>
      </a></li>

      <li><a href="profile.php?for_sale=0">My NFTs</a></li>
      <li><a href="profile.php?for_sale=1">My Store</a></li>
      <li><a href="support.php">Support</a></li>
        <ul>
          <li><a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Logout</span>
            
          </a></li>

        </ul>
      </div>
    </nav>

    <div class="nft-container" id="nftContainer"></div>
    <div class="support-form">
    <h2>Submit Support Ticket</h2>
    <form action="send_support.php" method="post">
        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br>
        
        <!-- Add a hidden input field to store the logged-in user's ID -->
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['loggedin']; ?>">
        
        <input type="submit" value="Submit">
    </form>
</div>

<div class="container">
    <!-- Your existing HTML content -->

    <!-- Display support tickets -->
    <div class="support-tickets">
        <h2>My Support Tickets</h2>
        <?php include 'display_tickets.php'; ?>
    </div>
</div>


    <script>
        window.onload = function() {
            

      };


        
    </script>
  </body>
</html>
