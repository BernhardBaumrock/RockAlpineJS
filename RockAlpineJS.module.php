<?php namespace ProcessWire;
// info snippet
class RockAlpineJS extends WireData implements Module, ConfigurableModule {

  public static function getModuleInfo() {
    return [
      'title' => 'RockAlpineJS',
      'version' => '0.0.1',
      'summary' => 'Integrate AlpineJS Microframework into ProcessWire',
      'autoload' => true,
      'singular' => true,
      'icon' => 'code',
      'requires' => [],
      'installs' => ['ProcessRockAlpineJS'],
    ];
  }

  public function init() {
  }

  /**
  * Config inputfields
  * @param InputfieldWrapper $inputfields
  */
  public function getModuleConfigInputfields($inputfields) {
    $url = $this->pages->get(ProcessRockAlpineJS::pageName)->url;
    $inputfields->add([
      'type' => 'markup',
      'label' => 'Getting Started',
      'icon' => 'smile-o',
      'value' => "<div>Read <a href='https://github.com/alpinejs/alpine/issues/237'>this issue about security considerations</a></div>"
        ."<div>Read the AlpineJS Docs: <a href='https://github.com/alpinejs/alpine'>https://github.com/alpinejs/alpine</a></div>"
        ."<div>See the release notes and compare features with shipped version! <a href='https://github.com/alpinejs/alpine/releases'>https://github.com/alpinejs/alpine/releases</a></div>"
        ."<div>See the Playground: <a href='$url'>$url</a></div>"
        ,
    ]);
    return $inputfields;
  }
}