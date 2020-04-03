<strong>These examples are taken from the docs (<a href='https://github.com/alpinejs/alpine'>https://github.com/alpinejs/alpine</a>)</strong>

<hr>

<h2>Dropdown/Modal</h2>
<div x-data="{ open: false }">
    <button @click="open = true">Open Dropdown</button>

    <ul
        x-show="open"
        @click.away="open = false"
    >
        Dropdown Body
    </ul>
</div>
<hr>

<h2>Tabs</h2>
<div x-data="{ tab: 'foo' }">
    <button :class="{ 'active': tab === 'foo' }" @click="tab = 'foo'">Foo</button>
    <button :class="{ 'active': tab === 'bar' }" @click="tab = 'bar'">Bar</button>

    <div x-show="tab === 'foo'">Tab Foo</div>
    <div x-show="tab === 'bar'">Tab Bar</div>
</div>
<hr>

<h2>AJAX</h2>
<div x-data="{ open: false }">
    <div>Data is loaded when button is hovered (mouseenter); See devtools network tab!</div>
    <button
        @mouseenter.once="
            fetch('http://worldtimeapi.org/api/timezone/Europe/Vienna')
                .then(response => response.json())
                .then(data => { $refs.dropdown.innerHTML = data.datetime })
        "
        @click="open = true"
    >Show Current Time in Vienna</button>

    <div x-ref="dropdown" x-show="open" @click.away="open = false">
        Loading Spinner...
    </div>
</div>
<hr>
