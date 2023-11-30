<?php
namespace contacts\assets;

class AssetManager
{
    private function load_script(string $handle, string $filename, string ...$deps){
        wp_enqueue_script($handle, plugin_dir_url(__FILE__)."/js/".$filename, $deps);
    }

    private function load_style(string $handle, string $filename){
        wp_enqueue_style($handle, plugin_dir_url(__FILE__)."/css/".$filename);
    }

    private function load_jquery(){
        wp_enqueue_script("jquery", "https://code.jquery.com/jquery-3.7.1.min.js");
    }

    public function loadAdminAssets(){
        $this->load_jquery();
        $this->load_script("overlay-js", "overlay.js");
        $this->load_style("overlay-styles", "overlay.css");
    }
}
