<?php

namespace App\Models;

use App\Interfaces\Subscribe;
use Predis\Client;


class Subscription extends Model implements Subscribe
{
   private string $user_id = "";
   private string $plan = "Free";
   private string $start = "";
   private string $end = "";
   private int $active = 1;

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
       return$this->active;
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
        $this->conn->queryPrepare(
            "SELECT  subscription.* FROM subscription
            inner join user u on subscription.user_id = u.id
            WHERE u.username = :username");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();

        if (!$redis->exists($key)) {
            $subscription = [];
            while ($row = $this->conn->single()) {
                $subscription[] = $row;
            }
            $redis->set($key, serialize($subscription));
            $redis->expire($key, 300);
            return $subscription;
        }else {
            return unserialize($redis->get($key));
        }
    }

    /**
     * Show active subscription
     * @param $username
     * @return mixed|void
     */
    public function show($username)
    {
        $this->conn->queryPrepare(
            "SELECT subscription.* FROM subscription
            inner join user u on subscription.user_id = u.id
            WHERE u.username = :username");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();
        $result = $this->conn->multi();

        foreach ($result as $row) {

            if ($row->active == 1) {
                return $row;
            }
        }
    }

    /**
     * @param $userData
     * @return string|void
     * @throws \Exception
     */
    public function subscribe($userData)
    {
        $redis = new Client();
        $redis->del("users_subscription_{$_SESSION['id']}");
        $result = $this->show($userData["username"]);
        $this->conn->queryPrepare(
            "insert into subscription (user_id, plan, start, end, active) 
        VALUES (:user_id, :plan, :start, :end, :active ) ");
        $this->conn->bindParam(":user_id", $userData["id"]);
        $this->conn->bindParam(":plan", $userData["subscription"]);
        $this->conn->bindParam(":start", date("Y-m-d"));

        if ($userData["subscription"] == "Free") {
            $this->conn->bindParam(":end", date("Y-m-d", strtotime('+100 years')));
            $now = new \DateTime();
            $ends = new \DateTime(date("Y-m-d", strtotime('+100 years')));
            $interval = $now->diff($ends);
            $_SESSION["plans end"] = $interval->format('%r%a days');
        } elseif ($userData["subscription"] == "Month") {
            $this->conn->bindParam(":end", date("Y-m-d", strtotime('+1 month')));
            $now = new \DateTime();
            $ends = new \DateTime(date("Y-m-d", strtotime('+1 month')));
            $interval = $now->diff($ends);
            $_SESSION["plans end"] = $interval->format('%r%a days');
        } elseif ($userData["subscription"] == "6 months") {
            $this->conn->bindParam(":end", date("Y-m-d", strtotime('+6 months')));
            $now = new \DateTime();
            $ends = new \DateTime(date("Y-m-d", strtotime('+6 month')));
            $interval = $now->diff($ends);
            $_SESSION["plans end"] = $interval->format('%r%a days');
        } elseif ($userData["subscription"] == "Year") {
            $this->conn->bindParam(":end", date("Y-m-d", strtotime('+1 year')));
            $now = new \DateTime();
            $ends = new \DateTime(date("Y-m-d", strtotime('+1 month')));
            $interval = $now->diff($ends);
            $_SESSION["plans end"] = $interval->format('%r%a days');
        }

        $this->conn->bindParam(":active", $this->getActive());
        $_SESSION["plan"] = $userData["subscription"];
        $this->conn->execute();

        if ($result) {
            $this->update($result->id);
        }
        return true;

    }

    /**
     * Set active status to 0
     * @param $id
     * @return void
     */
    public function update($id)
    {
        $this->conn->queryPrepare("update subscription set active = 0 where id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
    }

}