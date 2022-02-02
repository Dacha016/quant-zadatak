<?php

namespace App\Models;

use App\Adapters\PaymentAdapter;
use App\Interfaces\Subscribe;
use Predis\Client;


class Subscription extends Model implements Subscribe
{
    private string $user_id = "";
    private string $plan = "Free";
    private string $start = "";
    private string $end = "";
    private int $active = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getPlan()
    {
        return $this->plan;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getActive()
    {
        return $this->active;
    }

    /**
     * Users subscription
     * @param $username
     * @return mixed
     */
    public function index($username)
    {

        $redis = new Client();
        $key = "users_subscription_{$_SESSION['id']}";

        if (!$redis->exists($key)) {

            $this->conn->queryPrepare(
                "SELECT  subscription.* FROM subscription
                inner join user u on subscription.user_id = u.id
                WHERE u.username = :username");
            $this->conn->bindParam(":username", $username);
            $this->conn->execute();

            $subscriptions = [];

            while ($row = $this->conn->single()) {
                $subscriptions[] = $row;
            }

            $redis->set($key, serialize($subscriptions));
            $redis->expire($key, 300);

            if (isset($subscriptions)) {

                $response["data"] = [
                    "subscriptions" => $subscriptions,
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
                "subscriptions" => unserialize($redis->get($key)),
                "status_code" => 'HTTP/1.1 200 Success'
            ];

        }
        return $response;
    }

    /**
     * Show active subscription
     * @param $username
     * @return mixed|void
     */
    public function show($username)
    {

        $this->conn->queryPrepare(
            "select subscription.* from subscription
            inner join user u on subscription.user_id = u.id
            where u.username = :username and subscription.active = 1");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();

        $result = $this->conn->single();

        if (!$result) {

            $response["data"] = [
                "error" => "Content not found",
                "status_code" => 'HTTP/1.1 404 Not Found'
            ];

        } else {

            $response["data"] = [
                "subscription" => $result,
                "status_code" => 'HTTP/1.1 200 Success'
            ];
        }

        return $response;
    }

    /**
     * @param $userData
     * @return
     * @throws \Exception
     */
    public function subscribe($userData)
    {

        $subscribe = $this->show($userData["username"]);
        $subscribe = $subscribe["data"]["subscription"];

        if ($_SESSION["id"]) {

            $redis = new Client();
            $redis->del("users_subscription_{$_SESSION['id']}");

            $user = new PaymentAdapter(new User());

            if (!$user->pay()) {

                $response["data"] = [
                    "error" => "Payment problem",
                    "status_code" => 'HTTP/1.1 402 Payment Required'
                ];

                return $response;
            }
        }

        $this->conn->queryPrepare(
            "insert into subscription (user_id, plan, start, end, active) 
            VALUES (:user_id, :plan, :start, :end, :active ) ");
        $this->conn->bindParam(":user_id", $userData["id"]);
        $this->conn->bindParam(":plan", $userData["subscription"]);

        if ($userData["subscription"] == "Free") {

            if (isset($subscribe->plan) == "Month" || isset($subscribe->plan) == "6 months" || isset($subscribe->plan) == "Year") {

                $this->conn->bindParam(":start", $subscribe->end);
                $this->conn->bindParam(":end", date("Y-m-d", strtotime($subscribe->end . "+100 years")));
                $this->conn->bindParam(":active", $this->getActive());
                $this->conn->execute();

            } else {

                $this->conn->bindParam(":start", date("Y-m-d"));
                $this->conn->bindParam(":end", date("Y-m-d", strtotime('+100 years')));
                $this->conn->bindParam(":active", $this->getActive());
                $this->conn->execute();

                $now = new \DateTime();
                $ends = new \DateTime(date("Y-m-d", strtotime('+100 years')));
                $interval = $now->diff($ends);

                $_SESSION["plans end"] = $interval->format('%r%a days');
                $_SESSION["plan"] = $userData["subscription"];

                $subscribe = $this->selectLast($_SESSION["id"]);
                $this->active($subscribe->id);

                $subscribe = $this->selectActivated($_SESSION["id"]);
                $this->deactivate($subscribe->id);

            }
        } elseif ($userData["subscription"] == "Month") {

            if ($subscribe->plan == "6 months" || $subscribe->plan == "Year") {

                $this->conn->bindParam(":start", $subscribe->end);
                $this->conn->bindParam(":end", date("Y-m-d", strtotime($subscribe->end . "+1 month")));
                $this->conn->bindParam(":active", $this->getActive());
                $this->conn->execute();

            } else {

                $this->conn->bindParam(":start", date("Y-m-d"));
                $this->conn->bindParam(":end", date("Y-m-d", strtotime('+1 month')));
                $this->conn->bindParam(":active", $this->getActive());
                $this->conn->execute();

                $now = new \DateTime();
                $ends = new \DateTime(date("Y-m-d", strtotime('+1 month')));
                $interval = $now->diff($ends);

                $_SESSION["plans end"] = $interval->format('%r%a days');
                $_SESSION["plan"] = $userData["subscription"];

                $subscribe = $this->selectLast($_SESSION["id"]);
                $this->active($subscribe->id);

                $subscribe = $this->selectActivated($_SESSION["id"]);
                $this->deactivate($subscribe->id);

            }
        } elseif ($userData["subscription"] == "6 months") {

            if ($subscribe->plan == "Year") {

                $this->conn->bindParam(":start", $subscribe->end);
                $this->conn->bindParam(":end", date("Y-m-d", strtotime($subscribe->end . "+6 months")));
                $this->conn->bindParam(":active", $this->getActive());
                $this->conn->execute();

            } else {

                $this->conn->bindParam(":start", date("Y-m-d"));
                $this->conn->bindParam(":end", date("Y-m-d", strtotime('+6 months')));
                $this->conn->bindParam(":active", $this->getActive());
                $this->conn->execute();

                $now = new \DateTime();
                $ends = new \DateTime(date("Y-m-d", strtotime('+6 month')));
                $interval = $now->diff($ends);

                $_SESSION["plans end"] = $interval->format('%r%a days');
                $_SESSION["plan"] = $userData["subscription"];

                $subscribe = $this->selectLast($_SESSION["id"]);
                $this->active($subscribe->id);

                $subscribe = $this->selectActivated($_SESSION["id"]);
                $this->deactivate($subscribe->id);

            }
        } elseif ($userData["subscription"] == "Year") {

            $this->conn->bindParam(":start", date("Y-m-d"));
            $this->conn->bindParam(":end", date("Y-m-d", strtotime('+1 year')));
            $this->conn->bindParam(":active", $this->getActive());
            $this->conn->execute();

            $now = new \DateTime();
            $ends = new \DateTime(date("Y-m-d", strtotime('+1 month')));
            $interval = $now->diff($ends);

            $_SESSION["plans end"] = $interval->format('%r%a days');
            $_SESSION["plan"] = $userData["subscription"];

            $subscribe = $this->selectLast($_SESSION["id"]);
            $this->active($subscribe->id);

            $subscribe = $this->selectActivated($_SESSION["id"]);
            $this->deactivate($subscribe->id);

        }

        $response["data"] = [
            "status_code" => 'HTTP/1.1 200 Success'
        ];

        return $response;

    }

    /**
     * Set active status to 1
     * @param $id
     * @return void
     */
    public function active($id): void
    {

        $this->conn->queryPrepare("update subscription set active = 1 where id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

    }

    /**
     * Set active status to 0
     * @param $id
     * @return void
     */
    public function deactivate($id): void
    {

        $this->conn->queryPrepare("update subscription set active = 0 where id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

    }

    /**
     * Select next plan (after active plan)
     * @param $id
     * @return mixed
     */
    public function selectNext($id)
    {

        $this->conn->queryPrepare(
            "select id from subscription  
                where user_id =:id and 
                id  > (select id from subscription where user_id =:id and active = 1) limit 1");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

        return $this->conn->single();

    }

    /**
     * Select users last plan
     * @param $id
     * @return mixed
     */
    public function selectLast($id)
    {

        $this->conn->queryPrepare("select id from subscription where user_id =:id order by id desc limit 1");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

        return $this->conn->single();

    }

    /**
     * Select active plan when user subscribes new plan
     * @param $id
     * @return mixed
     */
    public function selectActivated($id)
    {

        $this->conn->queryPrepare("select id from subscription where user_id =:id and active = 1  limit 1");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

        return $this->conn->single();

    }
}