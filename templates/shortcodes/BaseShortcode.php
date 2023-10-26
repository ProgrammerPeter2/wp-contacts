<?php
namespace contacts\templates\shortcodes;


class BaseShortcode {
	public string $tag;

	/**
	 * @param string $tag
	 */
	public function __construct( string $tag ) {
		$this->tag = $tag;
	}


	public function renderShortcode($atts, $content, $tag): string
    {
		return "<h1>".$tag."</h1>";
	}

	public function registerShortcode(): void
    {
		add_shortcode($this->tag, array($this, 'renderShortcode'));
	}

}