<?php namespace ProcessWire;
$form = $this->modules->get('InputfieldForm');
$form->attr('x-data', 'showName()');

/** @var InputfieldText $f */
$f = $this->wire('modules')->get('InputfieldText');
$f->name = 'name';
$f->label = 'Name<span x-text="label()"></span>';
$f->entityEncodeLabel = false;
$f->notes = 'Type your name to see the magic';
$f->attr('x-model', 'name');
$f->attr('autocomplete', 'off');
$form->add($f);

$form->add([
  'type' => 'markup',
  'id' => 'mirror',
  'label' => 'Mirror, mirror on the wall: Who\'s the best ProcessWire developer of them all?',
  'value' => '<span x-text="mirror()"></span>',
  'notes' => 'Note that this inputfield gets toggled automatically. Try clearing the Inputfield...',
  'collapsed' => true,
]);

echo $form->render();
?>
<script>
function showName() {
  return {
    name: '',
    mirror() {
      if(this.name) Inputfields.open($('#mirror'));
      else Inputfields.close($('#mirror'));
      return "I'm sorry " + this.name + ", but nobody can beat Ryan ;)";
    },
    label() {
      return this.name ? " ("+this.name+")" : "";
    },
  }
}
</script>
