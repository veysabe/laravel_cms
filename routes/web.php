<?php

use App\Helpers\Arrays;
use App\Http\Controllers\Content\ContentController;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\URL\URLController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    $page = Page::where('url', '/')->first()->toJson();
    $page = json_decode($page, true);
    $config = json_decode($page['config'], true);
    if ($config['blocks']) {
        foreach ($config['blocks'] as $block) {
            $controller = \App\Http\Controllers\MainController::inject($block);
            $data = $controller->draw();
            echo "______________________________<br>";
            echo 'Тип блока: ' . $block['type'] . "<br>";
            echo 'Шаблон: ' . $block['template'] . "<br>";
            echo 'Тип контента: ' . $block['data']['items'] . "<br>";
            echo 'Результат выборки:<br>';
            foreach ($data as $datum) {
                echo '<ul>';
                echo "<li>" . $datum->name . "</li>";
                if (!empty($datum->banner)) {
                    echo 'Баннер:';
                    echo '<ul>';
                    echo "<li>" . $datum->banner->title . "</li>";
                    echo '</ul>';
                }
                echo '</ul>';
            }
            echo "______________________________<br>";

        }
    }
//    if ($cfg['data']) {
//        $data_type = $cfg['data']['items'];
//        $filter = $cfg['data']['filter'];
//        return (new MainController())->content($data_type, $filter);
//    }
});

//$urls = URLController::init()->generateUrls()->slug()->get();
//
//foreach ($urls as $url) {
//    $slug = $url->slug;
//    Route::get($url->url, function () use ($slug) {
//        $section = Section::where('code', $slug)->first();
//        echo "<pre>";
//        echo print_r($section->name, true);
//        echo "</pre>";
//    });
//}
