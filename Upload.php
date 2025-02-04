<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    
    // Create uploads directory if not exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $gameData = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'genre' => $_POST['genre'],
        'filename' => basename($_FILES['gameFile']['name'])
    ];

    $targetFile = $uploadDir . $gameData['filename'];
    
    // Validate and move uploaded file
    if (move_uploaded_file($_FILES['gameFile']['tmp_name'], $targetFile)) {
        // Save game data to JSON file (you can use database instead)
        $games = json_decode(file_get_contents('games.json'), true) ?? [];
        $games[] = $gameData;
        file_put_contents('games.json', json_encode($games));
        
        echo "Game uploaded successfully!";
    } else {
        echo "Error uploading file.";
    }
}
?>