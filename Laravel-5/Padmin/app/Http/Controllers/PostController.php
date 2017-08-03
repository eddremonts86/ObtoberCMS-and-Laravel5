<?php

namespace lvadmin\Http\Controllers;

use lvadmin\ApiRepos\ApiPost;

class PostController extends Controller {

  protected $apiPost;

  public function __construct(ApiPost $apiPost) {
    $this->apiPost = $apiPost;
  }

  public function postlist() {
    $Post_list = $this->apiPost->all();
    return view('articles.list', compact('Post_list'));
  }

  public function post($id) {
    $Post = $this->apiPost->postbyid($id);
    return view('articles.post', compact('Post'));
  }

  public function users() {
    $Users = $this->apiPost->getUsers();
    return view('home', compact('Users'));
  }
}
