<?php
/**
 * Connection to base
 *
 * PHP version 8
 *
 * @category Connection
 * @package  DataBaseConnection
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */

namespace App\Controllers;

use App\Blade\Blade;
use App\Models\User;

/**
 * Connection to base
 *
 * PHP version 8
 *
 * @category Connection
 * @package  DataBaseConnection
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */
class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct(new User());
    }

    /**
     * List of users in users tab
     * @return void
     */
    public function indexUsers()
    {

        $pages = $this->model->getPages();
        $result = $this->model->index($_SESSION["username"]);
        $result = $result["data"]["users"];

        Blade::render("/users", compact("result", "pages"));

    }

    /**
     * Update logged user account
     * @return void
     */
    public function updateAccount()
    {
        $result = $this->model->show($_SESSION["username"]);
        $result = $result["data"]["user"];

        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {

            Blade::render("/updateAccount", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {

            $result = $this->model->updateLoggedUserAccount();

            if (isset($result["data"]["error"])) {

                $error = $result["data"]["error"];

                Blade::render("/updateAccount", compact("error"));

            } else {

                header("Location: /profile");
            }
        }
    }

    /**
     * Update not logged user account
     * @param $slug
     * @return void
     */
    public function updateUser($slug)
    {
        $result = $this->model->show($slug);
        $result = $result["data"]["user"];

        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {


            Blade::render("/updateUsers", compact("result"));

        } elseif (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {


            $user = $this->model->updateNotLoggedUser();

            if (isset($user["data"]["error"])) {

                $error = $user["data"]["error"];

                Blade::render("/updateUsers", compact("error", "result"));

            } else {

                header("Location: /profile/users?page=" . $_POST["page"]);

            }
        }
    }
}
