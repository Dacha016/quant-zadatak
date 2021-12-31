<?php

namespace App\Models;

use App\Config\Connection;

class Gallery
{
    protected Connection $conn;

    public function __construct()
    {
        $this->conn = new Connection;
    }
    /**
     * List of users galleries
     * @param $id $id Users id
     * @return mixed
     */
    public function indexGalleries($id)
    {
        $limit =50;
        $this->conn->queryPrepare("select count(*) as 'row' from gallery where user_id = :id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        $pages = ceil($rows/$limit);
        $page = $_GET["page"];
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "select gallery.id as 'galleryId',description, name, user_id, nsfw, hidden, slug from gallery  
            where gallery.user_id = :id limit $limit offset $offset");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        return $result = $this->conn->multi();
    }
    /**
     * Get galleries for users with role user
     * @param $id $id of current user
     * @return mixed
     */
    public function showUserGalleries($id)
    {
        $limit =50;
        $this->conn->queryPrepare("select count(*) as 'row' from gallery where user_id = :id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        $pages = ceil($rows/$limit);
        $page = $_GET["page"];
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "SELECT id as 'galleryId',description, name, user_id, slug, nsfw, hidden FROM gallery 
            WHERE user_id =:id AND hidden = 0 AND nsfw = 0 limit $limit offset $offset");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        return $this->conn->multi();
    }

    /**
     * Get galleries for other users view (moderator, admin)
     * @param $id $id of current user (not logged user)
     * @return mixed
     */
    public function showUserGalleriesAll($id)
    {
        $limit =50;
        $this->conn->queryPrepare("select count(*) as 'row' from gallery where user_id = :id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        $pages = ceil($rows/$limit);
        $page = $_GET["page"];
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "SELECT  id as 'galleryId', description, name, user_id, slug, nsfw, hidden FROM gallery 
        WHERE user_id =:id limit $limit offset $offset");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

        return $this->conn->multi();

    }

    public function createGallery($userId, $name, $nsfw ,$hidden, $description, $slug,)
    {
        $this->conn->queryPrepare(
            "insert into gallery (user_id, name, nsfw, hidden, description, slug)
            values (:user_id, :name, :nsfw, :hidden, :description, :slug)");
        $this->conn->bindParam(":user_id", $userId);
        $this->conn->bindParam(":name", $name);
        $this->conn->bindParam("nsfw", $nsfw);
        $this->conn->bindParam(":hidden", $hidden);
        $this->conn->bindParam(":description", $description);
        $this->conn->bindParam(":slug", $slug);
        $this->conn->execute();
    }

    /**
     * @param $description
     * @param $hidden
     * @param $nsfw
     * @param $id
     * @return mixed
     */
    public function updateGallery($description,$hidden,$nsfw,$id)
    {
        $this->conn->queryPrepare(
            "update gallery 
            set description =:description, hidden =:hidden, nsfw =:nsfw
            where id =:id");
        $this->conn->bindParam(":description", $description);
        $this->conn->bindParam(":hidden", $hidden);
        $this->conn->bindParam(":nsfw", $nsfw);
        $this->conn->bindParam(":id", $id);
        return $this->conn->execute();
    }

}