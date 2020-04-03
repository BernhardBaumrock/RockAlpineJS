<?php namespace ProcessWire;
/**
 * AlpineJS Playground Module for ProcessWire
 * 
 * // TODO add module to https://github.com/alpinejs/awesome-alpine when ready
 *
 * @author Bernhard Baumrock, 30.03.2020
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class ProcessRockAlpineJS extends Process {
  const pageName = 'alpinejs-playground';

  public static function getModuleInfo() {
    return [
      'title' => 'RockAlpineJS Playground',
      'version' => '0.0.1',
      'summary' => 'RockAlpineJS Playground',
      'icon' => 'child',
      'requires' => ['RockAlpineJS'],
      'installs' => [],
      
      // page that you want created to execute this module
      'page' => [
        'name' => self::pageName,
        'parent' => 'setup',
        'icon' => 'child',
        'title' => 'AlpineJS-Playground'
      ],
    ];
  }

  public function init() {
    parent::init(); // always remember to call the parent init
    $this->config->scripts->add($this->config->urls($this)."alpine.js");
  }

  /**
   * 
   */
  public function execute() {
    if(!$this->user->isSuperuser()) throw new WireException("Access only for Superusers!");
    $name = $this->input->get('example');
    $this->headline("AlpineJS Playground $name");
    $this->browserTitle("AlpineJS Playground $name");

    $out = '';
    if($name) $out = "<div class='uk-margin-bottom'><a href='./'>Back to index</a></div>";
    $out .= $this->renderExample() ?: $this->renderLinks();
    return $out;
  }

  private function renderExample() {
    if(!$ex = $this->input->get('example')) return;
    $file = __DIR__ . "/examples/$ex.php";
    if(!is_file($file)) {
      $this->error("File $file not found");
      return;
    }
    return $this->files->render($file);
  }

  private function renderLinks() {
    $ff = $this->files->find(__DIR__. '/examples', ['extensions'=>['php']]);
    $out = '<strong>Examples</strong><ul>';
    foreach($ff as $file) {
      $info = new WireData();
      $info->setArray(pathinfo($file));
      $out .= "<li><a href='./?example={$info->filename}'>{$info->filename}</a></li>";
    }
    $out .= "</ul>";
    return $out;
  }
}