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
     * List of  galleries
     * @param $id $id Users id
     * @return mixed
     */
    public function index($slug): array
    {
        $redis = new Client();
        $key = "galleries_of_user_{$slug}_page_{$_GET['page']}";
        $limit =50;
        $page =$_GET["page"] -1;
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "SELECT  gallery.id as 'galleryId', description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden,  u.username as 'username' 
            FROM gallery 
            inner join user u on gallery.user_id = u.id
            WHERE u.username =:slug limit $limit offset $offset");
        $this->conn->bindParam(":slug", $slug);
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
     * Get hidden and nsfw galleries of not logged user
     * @param $id $id of current user
     * @return array
     */
    public function indexHiddenOrNsfw($slug): array
    {

        $redis = new Client();
        $key = "hidden_galleries_of_user_{$slug}_page_{$_GET['page']}";
        $limit =50;
        $page = $_GET["page"] - 1;
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "select gallery.id as 'galleryId',description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden, u.username as 'username' 
            from gallery
            inner join user u on gallery.user_id = u.id
            where u.username =:slug and gallery.hidden = 0 and gallery.nsfw = 0 limit $limit offset $offset");
        $this->conn->bindParam(":slug", $slug);
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

    public function indexComments($id)
    {
        $redis = new Client();
        $key = "gallery_{$id}_comments";
        $this->conn->queryPrepare(
            "select  g.name as 'galleryName', u.username as 'username', comment from comment
            inner join gallery g on comment.gallery_id = g.id
            inner join user u on comment.user_id = u.id
            where gallery_id =:id");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();
        if (!$redis->exists($key)) {
            $comments = [];
            while ($row = $this->conn->single()) {
                $comments[] = $row;
            }
            $redis->set($key, serialize($comments));
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
        $redis->del("galleries_of_user_{$galleryData['userUsername']}_page_{$_POST['page']}");
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
     * @return void
     */
    public function delete($id)
    {

        $redis = new Client();
        $redis->del("galleries_of_user_{$_POST['userUsername']}_page_{$_POST['page']}");
        $this->conn->queryPrepare("DELETE FROM gallery WHERE id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
    }

    public function getPages($slug): float
    {
        $limit =50;
        $this->conn->queryPrepare(
            "select count(*) as 'row' from gallery 
            inner join user u on gallery.user_id = u.id
            where u.username = :slug");
        $this->conn->bindParam(":slug", $slug);
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        return ceil($rows/$limit);
    }


    public function getPagesVisible($slug): float
    {
        $limit =50;
        $this->conn->queryPrepare(
            "select count(*) as 'row' from gallery 
            inner join user u on gallery.user_id = u.id
            where u.username = :slug and gallery.hidden = 0 and gallery.nsfw =0");
        $this->conn->bindParam(":slug", $slug);
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        return ceil($rows/$limit);
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
    public function createComment($commentData)
    {
        $redis = new Client();
        $redis->del("gallery_{$commentData['galleryId']}_comments");
        $this->conn->queryPrepare("insert into comment (user_id, gallery_id, comment) values (:user_id, :gallery_id, :comment)");
        $this->conn->bindParam(":user_id", $commentData["userId"]);
        $this->conn->bindParam(":gallery_id", $commentData["galleryId"]);
        $this->conn->bindParam(":comment", $commentData["comment"]);
        return $this->conn->execute();
    }
}