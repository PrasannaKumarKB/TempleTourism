<!DOCTYPE html>
<html>
<head>
  <title>Payment Options</title>
  <style>
    body {
      background-image: url('paymentbackground.jpg');
      background-size: cover;
      background-position: center;
      font-family: Arial, sans-serif;
      color: #fff;
    }
    
    .container {
      width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      text-align: center;
    }
    
    h1 {
      font-size: 24px;
      margin-bottom: 20px;
    }
    
    .payment-options {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      margin-top: 20px;
    }
    
    .payment-card {
      width: 200px;
      margin: 10px;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      cursor: pointer;
      transition: transform 0.3s;
    }
    
    .payment-card:hover {
      transform: scale(1.05);
    }
    
    .payment-card img {
      width: 100px;
      margin-bottom: 10px;
    }
    
    .payment-card h3 {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .cta-button {
      display: inline-block;
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      text-decoration: none;
      margin-top: 30px;
    }
    
    .payment-card p {
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Select a Payment Option</h1>
    <div class="payment-options">
      <div class="payment-card">
        <img src="creditcard.png" alt="Credit Card">
        <h3>Card</h3>
        <p>Pay securely with your Credit Card/Debit Card.</p>
        <a class="cta-button" href="card.php">Pay Now!</a>
      </div>
      <div class="payment-card">
        <img src="net.png" alt="PayPal">
        <h3>Net Banking</h3>
        <p>Make Your payment using Net Banking.</p>
        <a class="cta-button" href="netbanking.php">Pay Now!</a>
      </div>
      <div class="payment-card">
        <img src="upi.png" alt="Apple Pay">
        <h3>UPI Payment</h3>
        <p>Make the payment using UPI transaction.</p>
        <a class="cta-button" href="upi.php">Pay Now!</a>
      </div>
    </div>
  </div>
</body>
</html>
