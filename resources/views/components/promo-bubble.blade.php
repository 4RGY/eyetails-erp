<div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-12"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-on:click.prevent="$dispatch('open-modal', 'promo-modal')" class="promo-bubble">
    <i class="fas fa-gift"></i>
    <span>Promo!</span>
</div>