<div class="top-bar">
  <div class="row">
    <div>
      <div class="top-bar-left">
        <ul class="dropdown menu" data-dropdown-menu>
          <li><img src="/image/logo.jpg" alt=""></li>
          <li class="hide-for-small-only" v-for="left in top_bar_left"><a href="@{{left.href}}">@{{left.name}}</a></li>
        </ul>
      </div>
      <div class="top-bar-right">
        <ul class="dropdown menu" data-dropdown-menu>
          <li v-for="right in top_bar_right"><a href="@{{right.href}}">@{{right.name}}</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>