<?php

class PostController
{
    private $app;
    private $post;

    public function __construct($app)
    {
        include_once 'models\Post.php';

        $this->app = $app;
        $this->post = new Post();
    }

    public function getAll()
    {
        $result = $this->post->read();

        $num = $result->rowCount();

        if ($num > 0) {
            $posts_arr = array();
            $posts_arr['data'] = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $post_item = array(
                    'id' => $id,
                    'title' => $title,
                    'body' => html_entity_decode($body),
                    'author' => $author,
                    'category_id' => $category_id,
                    'category_name' => $category_name,
                );
                array_push($posts_arr['data'], $post_item);
            }
            echo json_encode($posts_arr);
        } else {
            echo json_encode(array('message' => 'No Posts Found'));
        }
    }

    public function getSingle($id)
    {
        $this->post->id = isset($id) ? $id : die();

        $result = $this->post->read_single();

        $num = $result->rowCount();

        if ($num > 0) {
            $posts_arr = array();
            $posts_arr['data'] = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $post_item = array(
                    'id' => $id,
                    'title' => $title,
                    'body' => html_entity_decode($body),
                    'author' => $author,
                    'category_id' => $category_id,
                    'category_name' => $category_name,
                );
                array_push($posts_arr['data'], $post_item);
            }
            echo json_encode($posts_arr);
        } else {
            echo json_encode(array('message' => 'Post Not Found'));
        }
    }

    public function create()
    {
        header('Content-type: application/json');
        $data = json_decode(file_get_contents("php://input"));

        $this->post->title = $data->title;
        $this->post->body = $data->body;
        $this->post->author = $data->author;
        $this->post->category_id = $data->category_id;

        if ($this->post->create()) {
            echo json_encode(
                array('message' => 'Post Created')
            );
        } else {
            echo json_encode(
                array('message' => 'Post Not Created')
            );
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));

        $this->post->id = isset($id) ? $id : die();
        $this->post->title = $data->title;
        $this->post->body = $data->body;
        $this->post->author = $data->author;
        $this->post->category_id = $data->category_id;

        if ($this->post->update()) {
            echo json_encode(
                array('message' => 'Post Updated')
            );
        } else {
            echo json_encode(
                array('message' => 'Post Not Updated')
            );
        }
    }

    public function delete($id)
    {
        $this->post->id = isset($id) ? $id : die();

        if ($this->post->delete()) {
            echo json_encode(
                array('message' => 'Post Deleted')
            );
        } else {
            echo json_encode(
                array('message' => 'Post Not Deleted')
            );
        }
    }
}
