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

use App\Models\User;
use PDO;
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
    protected $conn;
    /**
     * Connection to base
     * 
     * @param $conn Data base connection
     */
    public function __construct($conn)
    {
        parent::__construct(new User($conn));
    }
    /**
     * Connection to base
     * 
     * @param $id User id
     * 
     * @return object
     */
    public function show($id)
    {
        $result = $this->model->read($id);
        $n=$result->rowCount();
        if ($n>0) {
            $inArr=[];
            while ($row= $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $in=[
                    "username"=>$row["username"],
                    "email"=>$row["email"],
                    "password"=>$row["password"],
                    "role"=>$row["role"]
                ];
                array_push($inArr, $in);
            }
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($inArr);
            return $response;
        }
    }
}
?>