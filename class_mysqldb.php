<?php
namespace contacts;

use contacts\models\Contact;
use contacts\models\ContactGroup;
use contacts\models\Post;
use contacts\models\PostCategory;

require_once dirname( plugin_dir_path( __FILE__ ), 3).'/wp-config.php';
require_once plugin_dir_path(__FILE__).'/models/Contact.php';
require_once plugin_dir_path(__FILE__).'/models/Post.php';
require_once plugin_dir_path(__FILE__).'/models/ContactGroup.php';
require_once plugin_dir_path(__FILE__).'/models/PostCategory.php';

class mysqldb {
	protected \mysqli|false $mysql;
    private string $wp_prefix;
    private const PLUGIN_PREFIX = "contacts_";

	public function __construct(){
        global $wpdb;
		$this->mysql = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		mysqli_set_charset($this->mysql, "utf8");
		if(mysqli_connect_error()){
			echo "Something went wrong when tried to connect to the database!";
			exit;
		}
        $this->wp_prefix = $wpdb->prefix;
	}

    public function get_table_name($table_name){
        return $this->wp_prefix . self::PLUGIN_PREFIX . $table_name;
    }

	public function executeSQL($sql): \mysqli_result|bool
    {
		$query = mysqli_query($this->mysql, $sql);
		if(mysqli_error($this->mysql)){
			echo "Something went wrong with your query!";
			echo "<br/>".mysqli_error($this->mysql)."<br/>";
            error_log(mysqli_error($this->mysql));
			return false;
		}
		return $query;
	}

    public function getPostByName(string $postName): Post{
        $table = $this->get_table_name("posts");
        $data = mysqli_fetch_object($this->executeSQL("select * from $table where name='$postName'"));
        return Post::fromObj($data);
    }

    /**
     * @param Post $post
     * @return Contact[]
     */
    public function getContactByPost(Post $post): array {
        $table = $this->get_table_name("holders");
		$result = $this->executeSQL("select * from wp_contacts_holders where post=".$post->id);
        $arr = array();
		while($rawData = mysqli_fetch_object($result)){
            $arr[] = new Contact($rawData->id, $post, $rawData->holder, $rawData->class, $rawData->email);
        }
        return $arr;
	}

	public function checkPost(Post $post): bool
    {
        $table = $this->get_table_name("holders");
		return mysqli_num_rows($this->executeSQL("SELECT * FROM $table WHERE post=".$post->id)) > 0;
	}

	public function clearPropertyForQuery(string $key, $property, $isCloser=false): string {
		$keyValPair = "$key=";
		if(is_string($property)) $keyValPair .= "\"".mysqli_escape_string($this->mysql, $property)."\"";
		else if(empty($property) || $property == "") $keyValPair .= "null";
		else $keyValPair .= "$property";
		if(!$isCloser) $keyValPair .= ", ";
		return $keyValPair;
	}

	public function editContactByPost(Contact $contact): bool {
		$post = $contact->post;
        $table = $this->get_table_name("posts");
		if(mysqli_num_rows($this->executeSQL("SELECT * FROM $table WHERE id=".$post->id."")) == 0) return false;
		$sql = "update wp_contacts_holders set ".$this->clearPropertyForQuery("holder", $contact->holder).
		       $this->clearPropertyForQuery("class", $contact->class).
				$this->clearPropertyForQuery("email", $contact->email, true)." where ".$this->clearPropertyForQuery("post", $contact->post->id, true);
		echo $sql;
		return !($this->executeSQL($sql) === false);
	}

    /**
     * @return Post[]
     */
    private function getAllPost(): array
    {
        $table = $this->get_table_name("posts");
        $post_names = mysqli_fetch_all($this->executeSQL("select name from $table"));
        $out = array();
        foreach ($post_names as $post_name){
            $out[] = $this->getPostByName($post_name[0]);
        }
        return $out;
    }

    public function getPostById(int $id): Post|false{
        $table = $this->get_table_name("posts");
        if(!($posts = $this->executeSQL("select * from posts where id=$id"))){
            return false;
        }
        return Post::fromObj($posts->fetch_object());
    }
    
    /**
     * @return array|ContactGroup[]
     */
	public function getAllContacts(): array {
		$posts = $this->getAllPost();
        $out = array("0" => array(), "1" => array(), "2" => array());
        foreach ($posts as $post) {
            foreach (array_keys($out) as $key) {
                if(strval($post->category_id) == $key){
                    $contacts = ContactGroup::fromArray($this->getContactByPost($post));
                    if(!empty($contacts)) $out[$key][] = $contacts;
                }
            }
        }
        return $out;
	}

    /**
     * @return Contact[]
     */
    public function getEachContacts(): array{
        $posts = $this->getAllPost();
        $out = array();
        foreach ($posts as $post) {
            $out[] = $this->getContactByPost($post);
        }
        return $out;
    }

    public function getPostCategoryById(int $id): array{
        $table = $this->get_table_name("categories");
        if(!($result = $this->executeSQL("select * from $table where id=$id"))){
            return array();
        }
        return PostCategory::from_object($result->fetch_object());
    }

    public function getAllCategories(): array{
        $table = $this->get_table_name("categories");
        if($result = $this->executeSQL("select * from $table")){
            $categories = array();
            while(!($category = $result->fetch_object())){
                $categories[] = PostCategory::from_object($category);
            }
            return $categories;
        }
        return array();
    }

    public function create_category(PostCategory $category_to_create){
        $table = $this->get_table_name("categories");
        if($this->executeSQL("insert into $table (name, slug) value ('$category_to_create->name', '$category_to_create->slug')")){
            $category_to_create = new PostCategory($this->mysql->insert_id, $category_to_create->name, $category_to_create->slug);
            return $category_to_create;
        }
        return false;
    }

    public function check_category(PostCategory $category){
        $table = $this->get_table_name("categories");
        if(!$result = $this->executeSQL("select * from $table where name = '$category->name' or slug = '$category->slug'")){
            return false;
        }
        return $result->num_rows == 0;
    }
}
