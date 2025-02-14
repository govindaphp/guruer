<?php



namespace App\Providers;



use Illuminate\Support\ServiceProvider;


use Illuminate\Support\Facades\View;
use App\Http\Controllers\HomeController;


class AppServiceProvider extends ServiceProvider

{

    /**

     * Register any application services.

     *

     * @return void

     */

    public function register()

    {

        //

    }



    /**

     * Bootstrap any application services.

     *

     * @return void

     */

     public function boot(HomeController $homeController)
     {
            View::composer('front.layouts.header', function ($view) use ($homeController) {
            $data['chats'] = $homeController->getAllChats_byUser();

            $data['wishlist_by_session_user'] = $homeController->getAllFav_wishlist();

            $view->with('data', $data);
            });

            require_once app_path('Helpers/UserHelper.php');
     }

}

