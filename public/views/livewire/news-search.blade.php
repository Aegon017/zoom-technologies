<div class="sidebar__single sidebar__search">
    <div class="sidebar__title-box">
        <h3 class="sidebar__title">Search Here</h3>
    </div>
    <form class="sidebar__search-form">
        <input id="search" wire:model.live.debounce.500ms='search' type="search" placeholder="Enter Keyword">
        <button type="submit"><i class="icon-magnifying-glass"></i></button>
    </form>
</div>
