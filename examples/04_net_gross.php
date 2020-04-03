<?php namespace ProcessWire;
$form = $this->modules->get('InputfieldForm');
$form->attr('x-data', 'invoice()');
$form->attr('x-init', "\$watch('items', value => console.log(value))");

$form->add([
  'type' => 'markup',
  'label' => 'Description',
  'value' => "This example show how to combine both AlpineJS + jQuery",
]);

$form->add([
  'type' => 'markup',
  'label' => 'Items',
  'value' => '<table class="uk-table uk-table-small uk-table-striped">'
    .'<thead><tr>'
      .'<th>#</th>'
      .'<th class="uk-width-expand">Item</th>'
      .'<th class="short">Net</th>'
      .'<th class="short">Gross</th>'
      .'<th class="short">Amount</th>'
      .'<th class="short">Total</th>'
    .'</tr></thead>'
    .'<tbody>'
    .'<template x-for="(item,index) in items" :key="item">'
    .'<tr class="item">'
      .'<td x-text="(index+1)"></td>'
      .'<td><input type="text" class="uk-input uk-form-small" x-model="item.desc"></td>'
      .'<td><input type="number" step="10" class="short uk-input uk-form-small" x-model="item.net" @input="update(\'net\', index, $event.target.value)"></td>'
      .'<td><input type="number" step="10" class="short uk-input uk-form-small" x-model="item.gross" @input="update(\'gross\', index, $event.target.value)"></td>'
      .'<td><input type="number" class="short uk-input uk-form-small" x-model="item.amount" @input="update(\'amount\', index, $event.target.value)"></td>'
      .'<td><span class="uk-text-right" x-text="item.total"></span></td>'
    .'</tr>'
    .'</template>'
    .'</tbody>'
    .'<tfoot>'
    .'<tr class="totals">'
      .'<td></td>'
      .'<td><input type="text" id="itemdesc" style="width: 200px;"><button class="uk-button uk-button-default" @click.prevent="newItem()">Add new item</button></td>'
      .'<td></td>'
      .'<td></td>'
      .'<td></td>'
      .'<td class="uk-text-right uk-text-bold" x-text="total()"></td>'
    .'</tr>'
    .'</tfoot>'
    .'</table>',
]);
?>
<style>
.short { width: 100px; text-align: right !important; }
tfoot { border-top: 2px solid #afafaf; }
</style>
<?= $form->render() ?>

<script>
function Item() {
  this.desc = null;
  this.net = 0;
  this.gross = 0;
  this.amount = 1;
  this.tax = 1.2;
  this.total = 0;
}

Item.prototype.round = function(val) {
  return Math.round(val * 100) / 100;
}

Item.prototype.setNet = function(val) {
  this.net = this.round(val);
  this.gross = this.round(this.net * this.tax);
  this.setTotal();
}

Item.prototype.setGross = function(val) {
  this.gross = this.round(val);
  this.net = this.round(this.gross / this.tax);
  this.setTotal();
}

Item.prototype.setAmount = function(val) {
  this.amount = val;
  this.setTotal();
}

Item.prototype.setTotal = function() {
  this.total = this.round(this.gross * this.amount);
}

function invoice() {
  return {
    items: [],

    newItem() {
      var item = new Item();
      item.desc = $('#itemdesc').val() || 'foo';
      item.setNet(100);
      this.items.push(item);
      this.total()
    },

    total() {
      var total = 0;
      $.each(this.items, function(i, item) {
        total += item.total*1;
      });
      return total;
    },

    update(type, index, val) {
      if(type=='net') this.items[index].setNet(val);
      if(type=='gross') this.items[index].setGross(val);
      if(type=='amount') this.items[index].setAmount(val);
      this.items.push();
    }
  }
}
</script>
