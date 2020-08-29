<?php


use Illuminate\Support\Facades\Storage;



if (!function_exists('upload_image_base64')) {

    function upload_image_base64($table, $image)
    {
        try {
            $path = storage_path('/public/' . $table);
            if (!(\File::exists($path))) {
                \File::makeDirectory($path, $mode = 0777, true, true);
            }
            $image_data = base64_decode($image);
            //$image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
            $f = finfo_open();
            $mime_type = get_extension(finfo_buffer($f, $image_data, FILEINFO_MIME_TYPE));
            $imageName = uniqid() . '.' . str_replace("image/", "", $mime_type);
            if (!in_array($mime_type, ['jpg', 'jpeg', 'png', 'gif'])) {
                return false;
            }
            $destinationPath = '/public/' . $table . '/' . $imageName;
            Storage::put($destinationPath, $image_data);
            return $imageName;
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    function get_extension($image)
    {
        $extension = '';
        switch ($image) {//check image's extension
            case "image/jpeg":
                $extension = "jpeg";
                break;
            case "image/png":
                $extension = "png";
                break;
            case "image/jpg":
                $extension = "jpg";
                break;
            case "image/gif":
                $extension = "gif";
                break;

        }
        return $extension;
    }

}
if (!function_exists('change_parameter_lowercase')) {

    function change_parameter_lowercase($string)
    {
        $result = $string[0];
        $length = strlen($string);
        for ($i = 1; $i <= $length; $i++) {
            if (ctype_upper($string[$i]) == ctype_upper($string[$i + 1])) {
                $result .= strtolower($string[$i]);
            } else {
                if ($string[$i] == $string[$length - 1]) {
                    $result .= strtolower($string[$i]);
                } else {
                    $result .= $string[$i];
                }
            }
        }
        return strtolower(preg_replace("/(?<=[a-zA-Z])(?=[A-Z])/", "_", $result));
    }
}
if (!function_exists('un_link_image')) {

    function un_link_image($table, $image)
    {
        $path = storage_path("/app/public/" . $table);
        $image_path = $path . '/' . $image;
        if (file_exists($image_path)) {
            Storage::delete($image_path);
            // @unlink($image_path);
        }
    }
}
if (!function_exists('returnHtmlResponse')) {
    function returnHtmlResponse($message, $status)
    {
        $status . "   " . $message;
        return '
         <!doctype html>
         <html lang="en">
        <head>
          <meta charset="utf-8">
          <title>Basicallyme</title>
          <link rel="icon" href="http://163.172.78.65:4031/favicon.ico" type="image/x-icon">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><style>
        html, body{background: #fff;color: #000;font-size: 1rem;overflow-x: hidden;}
        .logo{margin-top: 150px;margin-bottom: 50px}
        .logo img{width: auto}
        .soon{font-size: 1.3rem;color: #5C5C5C;line-height: 1.9;}
        .btn-success {padding: 10px 45px;color: #fff;background-color: #213c53;border-color: #213c53;}
        .btn-success:hover, .btn-success:focus {box-shadow:none; color: #fff;background-color: #213c53;border-color: #213c53;}
        .footer{position: absolute;width: 100%;bottom: 0;height: 50px;}
        </style>
        </head>
            <body>
            <div class="col-lg-6 mx-auto text-center pt-2 align-self-center">
            <div class="logo">
            <img src="http://163.172.78.65:4031/assets/images/icon/logo.png">
            </div>
              <h4 class="soon">
              ' . $message . '
            </h4>
            <a class="btn btn-success my-4" href="http://basicallymexx.net/">Continue</a>
            </div>

            <div class="row mx-0 footer">
                <div class="col-sm-12 text-right pr-lg-5">
                  <div class="footer-end">
                    <p><i class="fa fa-copyright" aria-hidden="true"></i> © Basicallyme powered by
                     <a href="http://retailak.com/" target="_black">Retailak</a>.</p>
                  </div>
                </div>
                </div>

            </body>
            </html>
                ';
    }
}

if (!function_exists('get_language')) {
    function get_language($lang)
    {
        return DB::table('language')->where('lang', $lang)->first();
    }
}


