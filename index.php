<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<?php
// process.php was used by my classmates but I prefer this method
function Word_Frequency_Counter($inputText, $sortingOrder, $limit) {
    // // Convert the input text to lowercase
    // $inputText = strtolower($inputText);

    // Tokenization process
    $words = str_word_count($inputText, 1);

    // ignoring common words
    $stopWords = array("the", "and", "in", "your", "on", "if", "is", "it", "to", "and", "you");

    // Filtering out stop words and count word occurrences
    $filteredWords = array_diff($words, $stopWords);
    // $wordFrequencies = array_count_values($filteredWords);

    // Convertas the filtered words to lowercase, except for specific words that include "I"
    $filteredWords = array_map(function ($word) {
        if ($word !== 'I' && $word !== "I'll" && $word !== "I'm" && $word !== "I'd") {
            return strtolower($word);
        } else {
            return $word;
        }
    }, $filteredWords);

    $wordFrequencies = array_count_values($filteredWords);

    // Sorting by frequency
    if ($sortingOrder === 'asc') {
        asort($wordFrequencies);
    } else {
        arsort($wordFrequencies);
    }

    // Limit the number of words to display
    // can be used to display the most used word by limiting to 1 and descending
    $wordFrequencies = array_slice($wordFrequencies, 0, $limit, true);

    return $wordFrequencies;
}

// Main body of code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputText = $_POST['text'];
    $sortingOrder = $_POST['sort']; // 'asc' or 'desc'
    $limit = intval($_POST['limit']);

    if (empty($inputText)) {
        echo "Please enter some text.";
    } else {
        $wordFrequencies = Word_Frequency_Counter($inputText, $sortingOrder, $limit);
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