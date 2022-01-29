<?php

namespace App\Models;

use Predis\Client;

class Gallery extends Model
{
    private int $user_id;
    private string $name;
    private string $description;
    private string $slug;
    private int $nsfw;
    private int $hidden;

    public function __construct()
    {
      parent::__construct();
    }

    public function getUserId():int
    {
        return $this->user_id;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getDescription():string
    {
        return $this->description;
    }

    public function getSlug():string
    {
        return $this->slug;
    }
    public function getNsfw():int
    {
        return $this->nsfw;
    }

    public function getHidden():int
    {
        return $this->hidden;
    }

    /**
     * Get hidden and nsfw galleries of not logged user
     * @param $slug $id of current user
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
            return  $galleries;
        }else {
            return unserialize($redis->get($key));
        }
    }

    /**
     * Show all comments of gallery
     * @param $id
     * @return mixed
     */
    public function indexComments($id):mixed
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
            return $comments;
        }else {
            return unserialize($redis->get($key));
        }
    }

    /**
     * List of  galleries
     * @param $id $id Users id
     * @return mixed
     */
    public function index($username): array
    {
        $redis = new Client();
        $key = "galleries_of_user_{$username}_page_{$_GET['page']}";
        $limit =50;
        $page =$_GET["page"] -1;
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "SELECT  gallery.id as 'galleryId', description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden,  u.username as 'username' 
            FROM gallery 
            inner join user u on gallery.user_id = u.id
            WHERE u.username =:username limit $limit offset $offset");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();

        if (!$redis->exists($key)) {
            $galleries = [];
            while ($row = $this->conn->single()) {
                $galleries[] = $row;
            }
            $redis->set($key, serialize($galleries));
            $redis->expire($key, 300);
            return $galleries;
        }else {
            return unserialize($redis->get($key));
        }
    }

    /**
     * Show all images in gallery
     * @param $id
     * @return mixed
     */
    public function show($id):mixed
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
     * Create gallery
     * @param $galleryData
     * @return void
     */
    public function createGallery($galleryData):void
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
     * Insert data in moderator_logging
     * @param $galleryData
     * @return void
     */
    public function createLogg($galleryData): void
    {
        $this->conn->queryPrepare(
            "insert into moderator_logging (moderator_username, user_username,gallery_id, gallery_nsfw, gallery_hidden)
            values (:moderator_username, :user_username, :gallery_id, :gallery_nsfw, :gallery_hidden)");
        $this->conn->bindParam(":moderator_username", $galleryData["sessionName"]);
        $this->conn->bindParam(":user_username", $galleryData["userUsername"]);
        $this->conn->bindParam(":gallery_id", $galleryData["galleryId"]);
        $this->conn->bindParam(":gallery_nsfw", $galleryData["nsfw"]);
        $this->conn->bindParam(":gallery_hidden", $galleryData["hidden"]);
        $this->conn->execute();
    }

    /**
     * Create comment for gallery
     * @param $commentData
     * @return mixed
     */
    public function createGalleryComment($commentData):void
    {
        $redis = new Client();
        $redis->del("gallery_{$commentData['galleryId']}_comments");
        $this->conn->queryPrepare("insert into comment (user_id, gallery_id, comment) values (:user_id, :gallery_id, :comment)");
        $this->conn->bindParam(":user_id", $commentData["userId"]);
        $this->conn->bindParam(":gallery_id", $commentData["galleryId"]);
        $this->conn->bindParam(":comment", $commentData["comment"]);
        $this->conn->execute();
    }

    /**
     * Update gallery data
     * @param $galleryData
     * @return void
     */
    public function active($galleryData): void
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
        $this->conn->execute();
    }

    /**
     * Delete gallery
     * @param $id
     * @return void
     */
    public function deleteGallery($id):void
    {

        $redis = new Client();
        $redis->del("galleries_of_user_{$_POST['userUsername']}_page_{$_POST['page']}");
        $this->conn->queryPrepare("DELETE FROM gallery WHERE id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
    }

    /**
     * Pages for pagination
     * @param $slug
     * @return float
     */
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

    /**
     * Pages for pagination without hidden or nsfw galleries
     * @param $slug
     * @return float
     */
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
}