<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 14-04-17
 * Time: 14:06
 */

namespace lvadmin\ApiRepos;


class ApiPost extends ApiRequest {
  public function all() {
    return $this->getUrl('posts');
  }
  public function postbyid($id) {
    return $this->getUrl("posts/{$id}");
  }
  public function getUsers(){
    return $this->getUrl("users");
  }


}