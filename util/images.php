<?php
function processImage($dir, $fileName) {
    // Set up the variables
    $i = strrpos($fileName, '.');
    $imageName = substr($fileName, 0, $i);
    $ext = substr($fileName, $i);

    // Set up the read path
    $imagePath = $dir . $fileName;

    // Set the write path
    $imagePath_m = $dir . $imageName . '_m' . $ext;
    $imagePath_s = $dir . $imageName . '_s' . $ext;

    // Create an image that is a maximum of 400x300 pixels
    resizeImage($imagePath, $imagePath_m, 400, 300);

    // Create a thumbnail that is a maximum of 100x100 pixels
    resizeImage($imagePath, $imagePath_s, 100, 100);
}

/************************************
 * Resize image to 400x300 max
 ************************************/
function resizeImage($oldImagePath, $newImagePath, $maxWidth, $maxHeight) {

    // Get the image type
    $imageInfo = getimagesize($oldImagePath);
    $imageType = $imageInfo[2];

    // Set up the function names
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $imageFromFile = 'imagecreatefromjpeg';
            $imageToFile = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $imageFromFile = 'imagecreatefromgif';
            $imageToFile = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $imageFromFile = 'imagecreatefrompng';
            $imageToFile = 'imagepng';
            break;
        default:
            echo 'File must be a JPEG, GIF or PNG image.';
            exit;
    }

    // Get the old image and its height and width
    $oldImage = $imageFromFile($oldImagePath);
    $oldWidth = imagesx($oldImage);
    $oldHeight = imagesy($oldImage);

    // Calculate height and width ratios
    $widthRatio = $oldWidth / $maxWidth;
    $heightRatio = $oldHeight / $maxHeight;

    // If image is larger than specified ratio, create the new image
    if ($widthRatio > 1 || $heightRatio > 1) {
        // Calculate height and width for the new image
        $ratio = max($widthRatio, $heightRatio);
        $newHeight = round($oldHeight / $ratio);
        $newWidth = round($oldWidth / $ratio);

        // Create the new image
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Set transparency according to type
        if ($imageType == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
            imagecolortransparent($newImage, $alpha);
        }
        if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
        }

        // Copy old image to new image - this resizes the image
        $newX = 0;
        $newY = 0;
        $oldX = 0;
        $oldY = 0;
        imagecopyresampled($newImage, $oldImage, $newX, $newY, $oldX, $oldY, $newWidth, $newHeight, $oldWidth, $oldHeight);

        // Write the new image to a new file
        $imageToFile($newImage, $newImagePath);

        // Free any memory associated with the new image
        imagedestroy($newImage);
    } else {
        // Write the old image to a new file
        $imageToFile($oldImage, $newImagePath);
    }
    // Free any memory associated with the old image
    imagedestroy($oldImage);
}
