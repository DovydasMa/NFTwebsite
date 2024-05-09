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

      <li><a href="?for_sale=0">My NFTs</a></li>
      <li><a href="?for_sale=1">My Store</a></li>
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

    <script>
        window.onload = function() {
            
            function fetchNFTs(for_sale) {
              
              fetch(`users_nfts.php?for_sale=${for_sale}`)
                  .then(response => response.json())
                  .then(data => {
                    const nftContainer = document.getElementById('nftContainer');
                      nftContainer.innerHTML = '';
                      if(for_sale == 0){
                      data.forEach(nft => {
                          const nftCard = `
                              <div class="nft-card">
                                  <img class="nft-image" src="uploads/${nft.image_url}" alt="NFT Image">
                                  <div class="nft-name">${nft.name}</div>
                                  <div class="nft-description">${nft.description}</div>
                                  <form class="sell-form" onsubmit="sellNFT(event, ${nft.id})">
                                      <input class="sell-input" type="number" name="price" placeholder="Enter price" required>
                                      <button class="sell-btn" type="submit">Sell</button>
                                  </form>
                              </div>
                          `;
                          nftContainer.innerHTML += nftCard;
                      });}
                      if(for_sale == 1){
                      data.forEach(nft => {
                          const nftCard = `
                              <div class="nft-card">
                                  <img class="nft-image" src="uploads/${nft.image_url}" alt="NFT Image">
                                  <div class="nft-name">${nft.name}</div>
                                  <div class="nft-description">${nft.description}</div>
                                  <form class="sell-form" onsubmit="removesellingNFT(${nft.id})">

                                      <button class="sell-btn" type="submit">Remove NFT From Store</button>
                                  </form>
                              </div>
                          `;
                          nftContainer.innerHTML += nftCard;
                      });}




                  })
                  .catch(error => console.error('Error fetching existing NFTs:', error));
        }
      
        const urlParams = new URLSearchParams(window.location.search);
    const forSaleParam = urlParams.get('for_sale');

    if (forSaleParam !== null) {
        fetchNFTs(forSaleParam);
    } else {
        fetchNFTs(0); 
    }
      };

        function sellNFT(event, nftId) {
            event.preventDefault();
            const form = event.target;
            const price = form.querySelector('[name="price"]').value;
            const formData = new FormData();
            formData.append('nft_id', nftId);
            formData.append('price', price);

            fetch('sell.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                alert('NFT was listed for sale!'); window.location.href='profile.php?for_sale=1';
            })
            .catch(error => console.error('There was a problem with the fetch operation:', error));
        }

        function removesellingNFT(nftId) {
            event.preventDefault();
            const form = event.target;

            const formData = new FormData();
            formData.append('nft_id', nftId);


            fetch('removesellingNFT.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                alert('NFT was delisted from store!'); window.location.href='profile.php?for_sale=0';
            })
            .catch(error => console.error('There was a problem with the fetch operation:', error));
        }
        
    </script>
  </body>
</html>
