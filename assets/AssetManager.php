<?php
namespace contacts\assets;

class AssetManager
{
    private function check_current_site(array $sites): bool{
        foreach ($sites as $site) {
            if(str_contains($_SERVER['REQUEST_URI'], $site)) return true;
        }
        return false;
    }

    private function load_script(string $handle, string $filename, array $sites, string ...$deps){
        if(!$this->check_current_site($sites)) return;
        wp_enqueue_script($handle, plugin_dir_url(__FILE__)."js/".$filename, $deps);
    }

    private function load_style(string $handle, string $filename, array $sites){
        if(!$this->check_current_site($sites)) return;
        wp_enqueue_style($handle, plugin_dir_url(__FILE__)."css/".$filename);
    }

    private function load_jquery(){
        wp_enqueue_script("jquery", "https://code.jquery.com/jquery-3.7.1.min.js");
    }

    public function loadAdminAssets(){
        $this->load_jquery();
        $this->load_script("overlay-js", "overlay.js", array("contact_categories"),"jquery");
        $this->load_style("overlay-styles", "overlay.css", array("contact_categories"));
    }
}
