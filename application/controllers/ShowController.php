<?php

namespace Icinga\Module\xkcd\Controllers;

use Icinga\Web\Controller;

class ShowController extends Controller
{
    public function randomAction()
    {
        $response = file_get_contents("https://xkcd.com/info.0.json");
        $data = json_decode($response);
        $comic_number = rand(1, $data->num);

        $comic_response = file_get_contents("https://xkcd.com/$comic_number/info.0.json");
        $comic_data = json_decode($comic_response);

        $this->view->comic_title = $comic_data->title;
        $this->view->comic_alt = $comic_data->alt;
        $this->view->comic_image = $comic_data->img;
    }

    public function downloadAction()
    {
        if (isset($_POST['submit-download'])) {
            // Handle download functionality if needed
        }
    }

    // Remove the createDirectories and removeDoubleDots functions as they are not needed for XKCD comics
}

