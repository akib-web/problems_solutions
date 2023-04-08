

<?php



function base64ToImage(Request $request) {

    // Validate the request data
    $validator = Validator::make($request->all(), [
        'image_base64' => 'required|base64image'
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {

        return response()->json([
            'status' => false,
            'message' => $validator->errors()
        ], 400);

    } else {

        // Get image data from base64 string
        $image_data = base64_decode($request->input('image_base64'));

        // Generate a random file name for the image
        $file_name = uniqid().'.jpg';

        // Save image to a folder in public directory and store the path in a variable
        $saved_image = file_put_contents('public/images/'.$file_name,$image_data);

        // Return success response with the saved image path
        return response()->json([
            'status' => true,
            'message' => 'Image uploaded successfully',
            'path' => '/images/'.$file_name   // Path of the saved image in public directory  										                                                  folder

        ], 200);

    }
}



// add this validation to app service provider
/* Add custom validator to validate base64 image code start */
Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
    $explode = explode(',', $value);
    $allow = ['png', 'jpg', 'svg', 'jpeg', 'webp'];
    $format = str_replace(
        [
            'data:image/',
            ';',
            'base64',
        ],
        [
            '', '', '',
        ],
        $explode[0]
    );

    // check file format
    if (!in_array($format, $allow)) {
        return false;
    }

    // check base64 format
    if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
        return false;
    }

    return true;
});
/* Add custom validator to validate base64 image code end */











$path = config('location.user.path');

$base64Image = explode(";base64,", $request->profile_image);
$explodeImage = explode("image/", $base64Image[0]);
$imageType = $explodeImage[1];
$image_base64 = base64_decode($base64Image[1]);
$image_name = uniqid(). time() . '.'.$imageType;
$file_name = $path. $image_name;
