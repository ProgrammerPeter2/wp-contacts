<?php
namespace contacts\assets;

class AssetManager
{
    private function load_script(string $handle, string $filename){
        wp_enqueue_script($handle, __DIR__."/js/".$filename);
    }

    private function load_style(string $handle, string $filename){
        wp_enqueue_style($handle, __DIR__."/css/".$filename);
    }

    private function load_jquery(){
        wp_enqueue_script("jquery", "https://code.jquery.com/jquery-3.7.1.min.js");
    }

    public function loadAdminAssets(){
        $this->load_script("overlay-js", "overlay.js");
        $this->load_style("overlay-styles", "overlay.css");
        $this->load_jquery();
    }
}
