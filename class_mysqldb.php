<?php
namespace contacts;

use contacts\models\Contact;
use contacts\models\ContactGroup;
use contacts\models\Post;

require_once dirname( plugin_dir_path( __FILE__ ), 3).'/wp-config.php';
require_once plugin_dir_path(__FILE__).'/models/Contact.php';
require_once plugin_dir_path(__FILE__).'/models/Post.php';
require_once plugin_dir_path(__FILE__).'/models/ContactGroup.php';

class mysqldb {
	protected \mysqli|false $mysql;

	public function __construct(){
		$this->mysql = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		mysqli_set_charset($this->mysql, "utf8");
		if(mysqli_connect_error()){
			echo "Something went wrong when tried to connect to the database!";
			exit;
		}
	}

	public function executeSQL($sql): \mysqli_result|bool
    {
		$query = mysqli_query($this->mysql, $sql);
		if(mysqli_error($this->mysql)){
			echo "Something went wrong with your query!";
			echo "<br/>".mysqli_error($this->mysql)."<br/>";
			return false;
		}
		return $query;
	}

    public function getPostByName(string $postName): Post{
        $data = mysqli_fetch_object($this->executeSQL("select * from wp_contacts_posts where name='$postName'"));
        return Post::fromObj($data);
    }

    /**
     * @param Post $post
     * @return Contact[]
     */
    public function getContactByPost(Post $post): array {
		$result = $this->executeSQL("select * from wp_contacts_holders where post=".$post->id);
        $arr = array();
		while($rawData = mysqli_fetch_object($result)){
            $arr[] = new Contact($rawData->id, $post, $rawData->holder, $rawData->class, $rawData->email);
        }
        return $arr;
	}

	public function checkPost(Post $post): bool
    {
		return mysqli_num_rows($this->executeSQL("SELECT * FROM wp_contacts_holders WHERE post=".$post->id)) > 0;
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
		if(mysqli_num_rows($this->executeSQL("SELECT * FROM wp_contacts_posts WHERE id=".$post->id."")) == 0) return false;
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
        $post_names = mysqli_fetch_all($this->executeSQL("select name from wp_contacts_posts"));
        $out = array();
        foreach ($post_names as $post_name){
            $out[] = $this->getPostByName($post_name[0]);
        }
        return $out;
    }

    /**
     * @return array|ContactGroup[]
     */
	public function getAllContacts(): array {
		$posts = $this->getAllPost();
        $out = array("0" => array(), "1" => array(), "2" => array());
        foreach ($posts as $post) {
            foreach (array_keys($out) as $key) {
                if(strval($post->sort) == $key){
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

	private function getAllKodPost(): array {
		$result = $this->executeSQL("select * from wp_contacts_posts where iskodpost=1");
		$out = array();
		while($post_data = mysqli_fetch_object($result)){
            $out[] = Post::fromObj($post_data);
        }
        return $out;
	}

    /**
     * @return ContactGroup[]
     */
    public function getAllKodContact(): array{
        $posts = $this->getAllKodPost();
        $out = array();
        foreach ($posts as $post) {
            $out[] = ContactGroup::fromArray($this->getContactByPost($post));
        }
        return $out;
    }
}
