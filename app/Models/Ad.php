<?php

namespace App\Models;

use Predis\Client;

class Ad extends Model
{
    private string $advertiser;
    private string $content;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAdvertiser()
    {
        return $this->advertiser;
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $username
     * @return array
     */
    public function index($username): array
    {
        $redis = new Client();
        $key = "ads_{$_GET["page"]}";

        if (!$redis->exists($key)) {

            $limit = 20;
            $page = $_GET["page"] - 1;
            $offset = abs($page * $limit);

            $this->conn->queryPrepare(
                "select * from ads limit $limit offset $offset");
            $this->conn->execute();

            $ads = [];

            while ($row = $this->conn->single()) {
                $ads[] = $row;
            }

            $redis->set($key, serialize($ads));
            $redis->expire($key, 300);

            if (isset($users)) {

                $response["data"] = [
                    "ads" => $ads,
                    "status_code" => 'HTTP/1.1 200 Success'
                ];

            } else {

                $response["data"] = [
                    "error" => "Content not found, something is wrong",
                    "status_code" => 'HTTP/1.1 404 Not Found'
                ];

            }

        } else {

            $response["data"] = [
                "ads" => unserialize($redis->get($key)),
                "status_code" => 'HTTP/1.1 200 Success'
            ];

        }
        return $response;
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    /**
     * Pages for pagination
     * @return float
     */
    public function getPages(): float
    {

        $limit = 20;

        $this->conn->queryPrepare("select count(*) as 'row' from ads");
        $this->conn->execute();

        $result = $this->conn->single();
        $rows = $result->row;

        return ceil($rows / $limit);
    }
}