<?php

namespace App\Models;

use Predis\Client;

class Gallery extends Model
{
    public function __construct()
    {
      parent::__construct();
    }
    /**
     * List of logged user galleries
     * @param $id $id Users id
     * @return mixed
     */
    public function index($id): array
    {
        $redis = new Client();
        $key = "galleries_of_user_{$id}_page_{$_GET['page']}";
        $limit =50;
        $page = $_GET["page"];
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "SELECT  gallery.id as 'galleryId', description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden,  u.username as 'username' 
            FROM gallery 
            inner join user u on gallery.user_id = u.id
            WHERE u.id =:id limit $limit offset $offset");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        if (!$redis->exists($key)) {
            $galleries = [];
            while ($row = $this->conn->single()) {
                $galleries[] = $row;
            }
            $redis->set($key, serialize($galleries));
            $redis->expire($key, 300);
        }
        return unserialize($redis->get($key));
    }

    public function show($id)
    {
        $this->conn->queryPrepare(
            "SELECT gallery.id as 'galleryId',description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden, u.username as 'userUsername' 
            FROM gallery
            inner join user u on gallery.user_id = u.id
            WHERE gallery.id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        return $this->conn->single();
    }

    /**
     * List of not logged user galleries
     * @param $id $id Users id
     * @return mixed
     */
    public function indexAll($id): array
    {
        $redis = new Client();
        $key = "galleries_of_user_{$id}_page_{$_GET['page']}";
        $limit =50;
        $page = $_GET["page"];
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "SELECT  gallery.id as 'galleryId', description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden,  u.username as 'username' 
            FROM gallery 
            inner join user u on gallery.user_id = u.id
            WHERE u.id =:id limit $limit offset $offset");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        if (!$redis->exists($key)) {
            $galleries = [];
            while ($row = $this->conn->single()) {
                $galleries[] = $row;
            }
            $redis->set($key, serialize($galleries));
            $redis->expire($key, 300);
        }
        return unserialize($redis->get($key));
    }

    /**
     * Get hidden and nsfw galleries of not logged user
     * @param $id $id of current user
     * @return array
     */
    public function indexHiddenOrNsfw($id): array
    {
        $redis = new Client();
        $key = "hidden_galleries_of_user_{$id}_page_{$_GET['page']}";
        $limit =50;
        $page = $_GET["page"];
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "SELECT id as 'galleryId',description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden 
            FROM gallery
            WHERE user_id =:id AND hidden = 0 AND nsfw = 0 limit $limit offset $offset");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        if (!$redis->exists($key)) {
            $galleries = [];
            while ($row = $this->conn->single()) {
                $galleries[] = $row;
            }
            $redis->set($key, serialize($galleries));
            $redis->expire($key, 300);
        }
        return unserialize($redis->get($key));
    }

    /**
     * @param $galleryData
     */
    public function create($galleryData)
    {
        $this->conn->queryPrepare(
            "insert into gallery (user_id, name, nsfw, hidden, description, slug)
            values (:user_id, :name, :nsfw, :hidden, :description, :slug)");
        $this->conn->bindParam(":user_id", $galleryData["userId"]);
        $this->conn->bindParam(":name", $galleryData["name"]);
        $this->conn->bindParam("nsfw", $galleryData["nsfw"]);
        $this->conn->bindParam(":hidden", $galleryData["hidden"]);
        $this->conn->bindParam(":description", $galleryData["description"]);
        $this->conn->bindParam(":slug", $galleryData["slug"]);
        $this->conn->execute();
    }

    /**
     * @param $galleryData
     * @return mixed
     */
    public function update($galleryData): mixed
    {
        $redis = new Client();
        $redis->del("galleries_of_user_{$galleryData['userId']}_page_{$_POST['page']}");
        $this->conn->queryPrepare(
            "update gallery 
            set name =:name, slug =:slug, description =:description, hidden =:hidden, nsfw =:nsfw
            where id =:id");
        $this->conn->bindParam(":name", $galleryData["name"]);
        $this->conn->bindParam(":slug", $galleryData["slug"]);
        $this->conn->bindParam(":description", $galleryData["description"]);
        $this->conn->bindParam(":hidden", $galleryData["hidden"]);
        $this->conn->bindParam(":nsfw", $galleryData["nsfw"]);
        $this->conn->bindParam(":id", $galleryData["galleryId"]);
        return $this->conn->execute();
    }

    /**
     * @param $id
     * @return float
     */

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $redis = new Client();
        $redis->del("galleries_page_{$_POST['page']}");
        $this->conn->queryPrepare("DELETE FROM gallery WHERE id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
    }

    public function getPages($id): float
    {
        $limit =50;
        $this->conn->queryPrepare("select count(*) as 'row' from gallery where user_id = :id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        return floor($rows/$limit);
    }

    /**
     * @param $id
     * @return float
     */
    public function getPagesVisible($id): float
    {
        $limit =50;
        $this->conn->queryPrepare("select count(*) as 'row' from gallery where user_id = :id and hidden = 0 and nsfw =0");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        return floor($rows/$limit);
    }

    /**
     * @param $galleryData
     * @return bool
     */
    public function createLogg($galleryData): bool
    {
        $this->conn->queryPrepare(
            "insert into moderator_logging (moderator_username, user_username,gallery_id, gallery_nsfw, gallery_hidden)
            values (:moderator_username, :user_username, :gallery_id, :gallery_nsfw, :gallery_hidden)");
        $this->conn->bindParam(":moderator_username", $galleryData["sessionName"]);
        $this->conn->bindParam(":user_username", $galleryData["userUsername"]);
        $this->conn->bindParam(":gallery_id", $galleryData["galleryId"]);
        $this->conn->bindParam(":gallery_nsfw", $galleryData["nsfw"]);
        $this->conn->bindParam(":gallery_hidden", $galleryData["hidden"]);
        return $this->conn->execute();
    }
}