<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<?php
// Helper function to calculate word frequencies
function calculateWordFrequencies($inputText, $sortingOrder, $limit) {
    // Convert the input text to lowercase
    $inputText = strtolower($inputText);

    // Tokenize the input text into words
    $words = str_word_count($inputText, 1);

    // Common stop words to ignore
    $stopWords = array("the", "and", "in", "your", "on", "if", "is", "it", "to", "and", "you", /* Add more stop words as needed */);

    // Filter out stop words and count word occurrences
    $filteredWords = array_diff($words, $stopWords);
    $wordFrequencies = array_count_values($filteredWords);

    // Sort by frequency based on user's choice
    if ($sortingOrder === 'asc') {
        asort($wordFrequencies);
    } else {
        arsort($wordFrequencies);
    }

    // Limit the number of words to display
    $wordFrequencies = array_slice($wordFrequencies, 0, $limit, true);

    return $wordFrequencies;
}

// Main code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputText = $_POST['text'];
    $sortingOrder = $_POST['sort']; // 'asc' or 'desc'
    $limit = intval($_POST['limit']);

    if (empty($inputText)) {
        echo "Please enter some text.";
    } else {
        $wordFrequencies = calculateWordFrequencies($inputText, $sortingOrder, $limit);
    }
}
?>

<body>
    <h1>Word Frequency Counter</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="text">Paste your text here:</label><br>
        <textarea id="text" name="text" rows="10" cols="50" required style="margin: 0 auto;"></textarea><br><br>

        <label for="sort">Sort by frequency:</label>
        <select id="sort" name="sort">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select><br><br>

        <label for="limit">Number of words to display:</label>
        <input type="number" id="limit" name="limit" value="10" min="1"><br><br>

        <input type="submit" value="Calculate Word Frequency">
    </form>

    <?php if (isset($wordFrequencies)): ?>
        <h2>Word Frequencies</h2>
        <ul>
            <?php foreach ($wordFrequencies as $word => $frequency): ?>
                <li><?php echo $word . ': ' . $frequency; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>