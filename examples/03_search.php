<?php namespace ProcessWire;
$form = $this->modules->get('InputfieldForm');
$form->attr('x-data', 'search()');

/** @var InputfieldText $f */
$f = $this->wire('modules')->get('InputfieldText');
$f->label = 'Find User';
$f->attr('x-model', 'query');
$f->attr('x-on:input.debounce.750ms', 'find()');
$f->attr('autocomplete', 'off');
$f->notes = 'Search is debounced 750ms';
$form->add($f);

$form->add([
  'type' => 'markup',
  'id' => 'result',
  'label' => 'Search Result',
  'value' => "<div x-text='showResult()'></div>",
  'collapsed' => true,
]);

$form->add([
  'type' => 'markup',
  'id' => 'log',
  'label' => 'Search Log',
  'value' => '<template x-for="item in log" :key="item">'
    .'<div x-text="item"></div>'
    .'</template>',
  'collapsed' => true,
]);

echo $form->render();
?>

<script>
function search() {
  return {
    query: '',
    _result: '',
    log: [],
    showResult() {
      if(!this._result) return '';
      var person = this._result;
      return person.name.title + " "
        + person.name.first + " "
        + person.name.last
        + " ("+person.gender+")";
    },
    find() {
      if(!this.query) {
        this._result = null;
        Inputfields.close($('#result'));
        return;
      }

      this.log.push(this.query);
      fetch('https://randomuser.me/api/')
        .then(response => response.json())
        .then(data => {
          Inputfields.open($('#result'));
          Inputfields.open($('#log'));
          this._result = data.results[0];
        });
    },
  }
}
</script>
