<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require realpath(__DIR__ . '/../../vendor/autoload.php');
require_once '../Models/Tag.php';
use App\Models\Tag;

// Initialize the Tag model
$tagModel = new Tag();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tagId']) && isset($_POST['tagName'])) {
    $tagId = $_POST['tagId']; // Get the tag ID from the form
    $tagName = $_POST['tagName']; // Get the new tag name from the form

    // Prepare data for update
    $updateData = ['name' => $tagName];

    // Update tag
    if ($tagModel->update($updateData, $tagId)) {
        header("Location: tagManagement.php");
        exit();
    } else {
        $errorMessage = "Failed to update the tag.";
    }
} elseif (isset($_GET['id'])) {
    // Fetch tag data to pre-fill the form
    $tag = $tagModel->selectRecords("Tags", "*", "tag_id = " . $_GET['id']);
    if (empty($tag)) {
        die("Tag not found.");
    }
} else {
    die("Tag ID not provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tag</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-center mb-6">Edit Tag</h1>

        <?php if (isset($errorMessage)): ?>
            <div class="text-red-600 text-center mb-4"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <form action="updateTag.php" method="POST">
                <input type="hidden" name="tagId" value="<?php echo htmlspecialchars($tag[0]['tag_id']); ?>">

                <div class="mb-4">
                    <label for="tagName" class="block text-sm font-medium text-gray-700">Tag Name</label>
                    <input type="text" name="tagName" id="tagName" class="w-full p-2 mt-1 border rounded-md" value="<?php echo htmlspecialchars($tag[0]['name']); ?>" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg">Update Tag</button>
            </form>
        </div>
    </div>
</body>
</html>
