<?php
namespace contacts\models;

use contacts\mysqldb;

require_once dirname(__FILE__, 2).'/class_mysqldb.php';
require_once __DIR__.'/ContactGroup.php';

class Contact {
	public readonly Post $post;
    public readonly int $id;
	public  $holder;
	public  $class;
	public  $email;

    /**
     * @param int $id
     * @param Post $post
     * @param  $holder
     * @param  $class
     * @param  $email
     */
	public function __construct(int $id, Post $post, $holder, $class, $email) {
        $this->id = $id;
		$this->post      = $post;
		$this->holder    = (empty($holder) || $holder == "") ? null : $holder;
		$this->class     = (empty($class) || $class == "") ? null : $class;
		$this->email     = (empty($email) || $email == "") ? null : $email;
	}

	public function renderToHTML(bool $showPost, bool $hasEmailText = false, string $emailText = "", string $params = ""): string {
		if((empty($this->holder) || empty($this->class)) || empty($this->holder) && empty($this->class)){
			return <<<HTML
				<h3>Hiba!</h3>
				<h5>Kérlek add meg a(z) {$this->post->name} elérhetőségeit!</h5>
			HTML;

		}else{
			$resp = "<div class=\"post\">";
			if(!$showPost) $resp .= "<h4>".$this->post->name."</h4>";
			$resp .= "<p $params>$this->holder<br/>$this->class<br/>";
			if(!empty($this->email)){
				if(!$hasEmailText) $resp .= "<a href=\"mailto:{$this->email}\">{$this->email}</a>";
				else $resp .= "<a href=\"mailto:{$this->email}\">{$emailText}</a>";
			}
			$resp .= "</p></div>";
			return $resp;
		}
	}

	public function generateShortcode(): string {
		return "[kapcsolat post=\"".$this->post->name."\"]";
	}

	public function renderForm(): string {
		$holder = (empty($this->holder)) ? "" : $this->holder;
		$class = (empty($this->class)) ? "" : $this->class;
		$email = (empty($this->email)) ? "" : $this->email;
		return <<<HTML
			<div class="contactform">
				<p>Név:<br/><input type="text" name="{$this->id}-holder" value="{$holder}"/></p>
				<p>Osztály:<br/><input type="text" name="{$this->id}-class" value="{$class}"/></p>
				<p>E-mail cím:<br/><input type="text" name="{$this->id}-email" value="{$email}"/></p>
				<p> Rövidkód: <br/>{$this->generateShortcode()}</p>
			</div>
		HTML;
	}

	public static function toContact($contact): Contact{
		return $contact;
	}
}