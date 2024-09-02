<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
</head>
<body>
    <h1>Submit Your Review</h1>
    <form id="reviewForm" method="POST" action="portal.php">
        <label for="reviewName">Name:</label>
        <input type="text" id="reviewName" name="reviewName" required><br><br>
        
        <label for="reviewEmail">Email:</label>
        <input type="email" id="reviewEmail" name="reviewEmail" required><br><br>
        
        <label for="reviewRating">Rating (1-5):</label>
        <input type="number" id="reviewRating" name="reviewRating" min="1" max="5" required><br><br>
        
        <label for="reviewMessage">Message:</label>
        <textarea id="reviewMessage" name="reviewMessage" rows="4" required></textarea><br><br>
        
        <button type="submit">Submit Review</button>
    </form>
</body>
</html>
