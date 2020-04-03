<?php namespace ProcessWire;
$form = $this->modules->get('InputfieldForm');
$form->attr('x-data', 'Invoice()');
$form->attr('x-init', "init()");

for($i=0; $i<2; $i++) {
  $form->add([
    'type' => 'markup',
    'label' => 'Invoice',
    'value' => '<table class="invoice uk-table uk-table-striped uk-table-small uk-table-middle">'
      .'<thead>'
        .'<th class="center">Pos</th>'
        .'<th class="uk-width-expand">Description</th>'
        .'<th class="center min">Net</th>'
        .'<th class="center min">Gross</th>'
        .'<th class="center min">Amount</th>'
        .'<th class="center min">Total</th>'
      .'</thead>'
      .'<tbody id="tmp'.$i.'">'
        // .'<template x-for="(item, index) in items" :key="index">'
        .'<tr x-data="InvoiceItem()">'
          .'<td colspan=4 x-text="1"></td>'
          .'<td><input class="right min" type="number" x-model="amount" @input="setAmount($event.target.value)"></td>'
          .'<td class="center min">Total</td>'
        .'</tr>'
        // .'</template>'
      .'</tbody>'
      .'</table>'
      .'<small><button class="ui-button ui-priority-primary" @click.prevent="addItem()">Add Item</button></small>'
      ,
  ]);
}
?>
<style>
.invoice td { padding: 2px 10px; }
.right { text-align: right !important; }
.center { text-align: center !important; }
.min { min-width: 100px; }
</style>
<?= $form->render() ?>

<script>
function InvoiceItem() {
  return {
    desc: 'foo',
    net: 0,
    tax: 1.2,
    gross: 0,
    amount: 1,
    total: 0,

    round(val) {
      return Math.round(val * 100) / 100;
    },
    
    setNet(val) {
      this.net = this.round(val);
      this.gross = this.round(val * this.tax);
      this.setTotal();
    },
    setGross(val) {
      this.gross = this.round(val);
      this.net = this.round(val / this.tax);
      this.setTotal();
    },
    setAmount(val) {
      this.amount = val;
      this.setTotal();
    },
    setTotal() {
      this.total = this.round(this.gross * this.amount);
      this.$dispatch('foo');
    },
  }
}

function Invoice() {
  return {
    items: [1, 2, 3],

    init() {
      console.log('invoice initialized');
      $(document).on('changed', function(e) {
        console.log('changed!', this.items);
      });
    },

    addItem() {
      this.items.push("x");
    },
    foo() {
      console.log('foo!');
    }
  }
}
</script>
