<?php namespace ProcessWire;
$form = $this->modules->get('InputfieldForm');
$form->attr('x-data', 'InvoiceItem()');

$form->add([
  'type' => 'markup',
  'label' => 'Invoice',
  'value' => '<table class="uk-table uk-table-striped uk-table-small uk-table-middle">'
    .'<thead>'
      .'<th class="center">Pos</th>'
      .'<th class="uk-width-expand">Description</th>'
      .'<th class="center min">Net</th>'
      .'<th class="center min">Gross</th>'
      .'<th class="center min">Amount</th>'
      .'<th class="center min">Total</th>'
    .'</thead>'
    .'<tbody>'
      .'<tr x-data="InvoiceItem()">'
        .'<td class="right">1</td>'
        .'<td x-text="desc"></td>'
        .'<td><input class="right min" type="number" step="10" x-model="net" @input="setNet($event.target.value)"></td>'
        .'<td><input class="right min" type="number" step="10" x-model="gross" @input="setGross($event.target.value)"></td>'
        .'<td><input class="right min" type="number" x-model="amount" @input="setAmount($event.target.value)"></td>'
        .'<td class="right min" x-text="total"></td>'
      .'</tr>'
    .'</tbody>'
    .'</table>',
]);
?>
<style>
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
    },
  }
}
</script>
