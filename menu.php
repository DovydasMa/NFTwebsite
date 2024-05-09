<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.html");
    exit();
}

if(isset($_GET['loginname'])) {
  $loginname = $_GET['loginname'];
} else {
  $loginname = "Guest"; 

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
        <li><a href="profile.php">
        <i class="fas fa-chart-bar"></i>
        <span class="nav-item">Profile</span>
      </a></li>
        <ul>
          <li><a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Logout</span>
            
          </a></li>
          <button id="connect-button">Connect Metamask</button>
          <p id="bnb-balance-display">BNB Balance: --</p>
          <button id="env-balance-button">Check ENV Balance</button>
          <p id="balance-display">ENV Balance: --</p>
          <li><a href="menu.php?category=all<?php echo isset($_SESSION['loggedin']) ? '&loginname=' . $loginname : ''; ?>">All</a></li>
          <li><a href="menu.php?category=my_cart<?php echo isset($_SESSION['loggedin']) ? '&loginname=' . $loginname : ''; ?>" onclick="showCartItems()">My Cart</a></li>
          <li><a href="menu.php?category=my_nfts<?php echo isset($_SESSION['loggedin']) ? '&loginname=' . $loginname : ''; ?>">My Nfts</a></li>
          <li><a href="menu.php?category=digital_art<?php echo isset($_SESSION['loggedin']) ? '&loginname=' . $loginname : ''; ?>">Digital Art</a></li>
          <li><a href="menu.php?category=abstract_art<?php echo isset($_SESSION['loggedin']) ? '&loginname=' . $loginname : ''; ?>">Abstract Art</a></li>
          <li><a href="menu.php?category=ai_art<?php echo isset($_SESSION['loggedin']) ? '&loginname=' . $loginname : ''; ?>">AI Art</a></li>
          <li><a href="menu.php?category=sci_fi_art<?php echo isset($_SESSION['loggedin']) ? '&loginname=' . $loginname : ''; ?>">Sci-Fi Art</a></li>
          <li><a href="menu.php?category=all&page=2<?php echo isset($_SESSION['loggedin']) ? '&loginname=' . $loginname : ''; ?>">Next Page</a></li>
          <li><a href="menu.php?category=all&page=1<?php echo isset($_SESSION['loggedin']) ? '&loginname=' . $loginname : ''; ?>">Previous Page</a></li>
          <li>
          <form id="searchForm" onsubmit="handleSearch(event)">
  <input type="hidden" name="category" value="all">
  <input type="text" id="searchInput" name="search" placeholder="Search NFTs">
  <button type="submit">Search</button>
</form>
  </li>

        </ul>
      </div>
    </nav>
    <div id="myNFTsContainer">

    </div>
    
    <div id="cartContainer">

    </div>
    <div class="nft-container" id="nftContainer"></div>

    <script>
      document.getElementById('connect-button').addEventListener('click', event => { 
        let button = event.target;
        ethereum.request({method: 'eth_requestAccounts'}).then(accounts => {
          account = accounts[0];
          console.log(account);
          button.textContent = account;

          // Existing code for checking ETH balance
          ethereum.request({method: 'eth_getBalance' , params: [account, 'latest']}).then(result => {
            console.log(result);
            let wei = parseInt(result,16);
            let balance = wei / (10**18);
            console.log(balance + " BNB");
            document.getElementById('bnb-balance-display').textContent = `${balance} BNB`;
          });
        });
      });
      document.getElementById('env-balance-button').addEventListener('click', () => {
        ethereum.request({
          method: 'eth_call',
          params: [{
            to: '0xa45eC1cbA9949980f6814a9C84afaa0a58f1771b', // Replace with the ENV token contract address
            data: '0x70a08231000000000000000000000000' + account.substring(2)
          }, 'latest']
        }).then(result => {
          console.log(result);
          let wei = parseInt(result, 16);
          const TOKEN_DECIMALS = 20; // Replace with the actual decimal count of ENV coin
          let balance = wei / (10**TOKEN_DECIMALS);
          console.log(balance + " ENV");
          document.getElementById('balance-display').textContent = `${balance} ENV`;
        });
      });

function addToCart(itemName, itemPrice, loginname) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_to_cart.php', true); 
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Item added to cart: ' + itemName);
        } else {
            alert('Failed to add item to cart, item exists');
        }
    };
    const data = JSON.stringify({ loginname: loginname, name: itemName, price: itemPrice });
    xhr.send(data);
}
    
    const loginname = "<?php echo $loginname; ?>";
    console.log('Login name:', loginname);

    function fetchNFTs(category, page, search, loginname) {
      fetch(`get_existing_nfts.php?category=${category}&page=${page}&search=${search}&loginname=${loginname}`)
        .then(response => response.json())
        .then(data => {
          const nftContainer = document.getElementById('nftContainer');
          nftContainer.innerHTML = '';

          data.forEach(nft => {
            const nftCard = `
              <div class="nft-card">
                <img class="nft-image" src="uploads/${nft.image_url}" alt="NFT Image">
                <div class="nft-name">${nft.name}</div>
                <div class="nft-description">${nft.description}</div>
                <div class="nft-owner">${loginname}</div>
                <div class="nft-price">${nft.price} ENV</div> <!-- Display price -->
                <button class="add-to-cart-btn" onclick="addToCart('${nft.name}', ${nft.price}, '${loginname}')">Add to Cart</button> <!-- Add to Cart button -->
              </div>
            `;
            nftContainer.innerHTML += nftCard;
          });
        })
        .catch(error => console.error('Error fetching NFTs:', error));
    }

    
    
 
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get('category');
    const search = urlParams.get('search');
    const page = urlParams.get('page') || 1;
    


    
    if (category != 'my_cart') {
      const loginname = "<?php echo $loginname; ?>";
      fetchNFTs(category, page, "all", loginname);
    }
    if (category === 'my_cart') {
      const loginname = "<?php echo $loginname; ?>";
      showCartItems();
    }
    if (category === 'my_nfts') {
      const loginname = "<?php echo $loginname; ?>";
      showMyNFTs();
    }
    else {
      const loginname = "<?php echo $loginname; ?>";
      fetchNFTs('all', page, "all", loginname);
    }



  function fetchCartItems() {
    const urlParams = new URLSearchParams(window.location.search);
    console.log(loginname)
    return fetch(`get_cart_items.php?loginname=${loginname}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
}


function showCartItems() {
  fetchCartItems()
    .then(cartItems => {
      // Construct HTML for displaying cart items
      let cartHTML = `<h2>Cart</h2>`;
      cartItems.forEach(item => {
        cartHTML += `
          <div>
            <span>${item.name} - $${item.price}</span>
            <button onclick="removeFromCart('${item.name}')">Remove from Cart</button>
            <button onclick="buyNow('${item.name}', ${item.price})">Buy this nft</button>
          </div>`;
      });
      // Write HTML to the cart container
      document.getElementById("cartContainer").innerHTML = cartHTML;
    })
    .catch(error => {
      console.error('Error fetching cart items:', error);
      // Display error message
      document.getElementById("cartContainer").innerHTML = `<h2>Error</h2><p>There was an error fetching cart items.</p>`;
    });
}

function buyNow(itemName, itemPrice) {
    
    const loginname = "<?php echo $loginname; ?>";

    // Prepare JSON data
    const data = {
        itemName: itemName,
        price: itemPrice,
        loginname: loginname
    };

    // Send transaction for the NFT purchase
    sendTransaction(itemPrice)
     .then(txHash => {
            console.log('Transaction hash:', txHash);
            // If transaction succeeds, send a POST request to buynow.php
            fetch('buynow.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to add NFT to My NFTs');
                }
                
                return response.text(); // Return response body as text
            })
            .then(message => {
                console.log(message); // Log the success message
                // Optionally, display the success message to the user
                alert(message);
                // After successful purchase, remove the purchased nft
                removeFromCart(itemName);
            })
            .catch(error => {
                console.error('Error purchasing NFT:', error);
                // Display an error message to the user
                alert('Failed to purchase NFT. Please try again later.');
            });
        })
        .catch(error => {
            // If transaction fails, display an error message to the user
            console.error('Error sending transaction:', error);
            alert('Failed to send transaction. Please try again.');
        });
}

function sendTransaction(itemPrice) {
    return new Promise((resolve, reject) => {
        
        const recipientAddress = '0xa45eC1cbA9949980f6814a9C84afaa0a58f1771b'; // Replace with recipient address
        const account = '0x6328f6bD7A303Ab4Bc332C63159aE051278d8c8B'; // Replace with user's Ethereum account
        const amount = itemPrice;
        const TOKEN_DECIMALS = 20; // Replace with token decimals
        const amountInWei = BigInt(itemPrice * (10 ** TOKEN_DECIMALS));
        // Construct data for the transfer function
        const data = '0xa9059cbb' + recipientAddress.substring(2).padStart(64, '0') + amountInWei.toString(16).padStart(64, '0');
        // Prepare transaction parameters
        const transactionParam = {
            from: account,
            to: '0xa45eC1cbA9949980f6814a9C84afaa0a58f1771b', // Replace with contract address
            data: data
        };
        // Send transaction
        ethereum.request({ method: 'eth_sendTransaction', params: [transactionParam] })
            .then(txHash => {
                console.log('Transaction hash:', txHash);
                resolve(txHash); 
            })
            .catch(error => {
                console.error('Error sending transaction:', error);
                reject(error); 
            });
    });
}




function fetchMyNFTs() {
    const urlParams = new URLSearchParams(window.location.search);
    const loginname = urlParams.get('loginname');
    return fetch(`get_my_nfts.php?loginname=${loginname}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
}

function showMyNFTs() {
    fetchMyNFTs()
        .then(nfts => {
            let nftHTML = `<h2>My NFTs</h2>`;
            nfts.forEach(nft => {
                nftHTML += `
                    <div>
                        <span>${nft.name} - $${nft.price}</span>
                    </div>`;
            });
            document.getElementById("myNFTsContainer").innerHTML = nftHTML;
        })
        .catch(error => {
            console.error('Error fetching NFTs:', error);
            document.getElementById("myNFTsContainer").innerHTML = `<h2>Error</h2><p>There was an error fetching NFTs.</p>`;
        });
}


function removeFromCart(itemName) {
    // Retrieve loginname from session or wherever you store it
    const loginname = "<?php echo $loginname; ?>";

    // Prepare JSON data
    const data = {
        itemName: itemName,
        loginname: loginname
    };

    // Send a POST request to remove the item from the cart
    fetch('remove_from_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to remove item from cart');
        }
        // Reload cart items after successful removal
        showCartItems();
    })
    .catch(error => {
        console.error('Error removing item from cart:', error);
        // Optionally, display an error message or handle the error in another way
    });
}

function handleSearch(event) {
  event.preventDefault(); // Prevent default form submission

  const searchInput = document.getElementById("searchInput").value;
  const url = `get_existing_nfts.php?category=all&page=1&search=${searchInput}`;

  // Update browser URL
  history.pushState(null, "", url);

  // Fetch NFTs based on the search term
  fetchNFTs('all', 1, searchInput);
}


</script>

  </body>
</html>