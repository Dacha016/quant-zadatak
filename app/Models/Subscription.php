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
        $subscribe = $this->show($userData["username"]);
        if ($_SESSION["id"]) {
            $redis = new Client();
            $redis->del("users_subscription_{$_SESSION['id']}");

            $user = new User();
            $user = $user->show($_SESSION["username"]);
            $user = new PaymentAdapter(new User($user->username, $user->email, $user->password, $user->api_key, $user->role, $user->nsfw, $user->active, $user->payment, $user->valid_until));

            if ( !$user->pay()) {
                return false;
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
                $now = new \DateTime();
                $ends = new \DateTime(date("Y-m-d", strtotime('+100 years')));
                $interval = $now->diff($ends);
                $_SESSION["plans end"] = $interval->format('%r%a days');
                $this->conn->bindParam(":active", $this->getActive());
                $_SESSION["plan"] = $userData["subscription"];
                $this->conn->execute();
                $subscribe = $this->selectLast($_SESSION["id"]);
                $this->active($subscribe->id);
                $subscribe = $this->selectActivated($_SESSION["id"]);
                $this->deactive($subscribe->id);
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
                $now = new \DateTime();
                $ends = new \DateTime(date("Y-m-d", strtotime('+1 month')));
                $interval = $now->diff($ends);
                $_SESSION["plans end"] = $interval->format('%r%a days');
                $this->conn->bindParam(":active", $this->getActive());
                $_SESSION["plan"] = $userData["subscription"];
                $this->conn->execute();
                $subscribe = $this->selectLast($_SESSION["id"]);
                $this->active($subscribe->id);
                $subscribe = $this->selectActivated($_SESSION["id"]);
                $this->deactive($subscribe->id);
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
                $now = new \DateTime();
                $ends = new \DateTime(date("Y-m-d", strtotime('+6 month')));
                $interval = $now->diff($ends);
                $_SESSION["plans end"] = $interval->format('%r%a days');
                $this->conn->bindParam(":active", $this->getActive());
                $_SESSION["plan"] = $userData["subscription"];
                $this->conn->execute();
                $subscribe = $this->selectLast($_SESSION["id"]);
                $this->active($subscribe->id);
                $subscribe = $this->selectActivated($_SESSION["id"]);
                $this->deactive($subscribe->id);
            }
        } elseif ($userData["subscription"] == "Year") {

            $this->conn->bindParam(":start", date("Y-m-d"));
            $this->conn->bindParam(":end", date("Y-m-d", strtotime('+1 year')));
            $now = new \DateTime();
            $ends = new \DateTime(date("Y-m-d", strtotime('+1 month')));
            $interval = $now->diff($ends);
            $_SESSION["plans end"] = $interval->format('%r%a days');
            $this->conn->bindParam(":active", $this->getActive());
            $_SESSION["plan"] = $userData["subscription"];
            $this->conn->execute();

            $subscribe = $this->selectLast($_SESSION["id"]);
            $this->active($subscribe->id);
            $subscribe = $this->selectActivated($_SESSION["id"]);
            $this->deactive($subscribe->id);

        }
        return true;
    }

    /**
     * Set active status to 1
     * @param $id
     * @return void
     */
    public function active($id)
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
    public function deactive($id)
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